<?php
// hrmis/app.php
restrictPublicAccess();

$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmis';
$page = $appTitle = "Human Resource Management Information System";

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, 'HRMO')) === 0) {
  redirect(uri() . '/pis');  
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('hrmis', 'Employee Search', sanitize($_POST['primary-search-text'])));
}

/* PERSONAL INFORMATION */
if (isset($_POST['update-personal-information'])) {
  $employeeId = $_SESSION[alias() . '_currentEmployeeId'];
  $employeePhoto = $_SESSION[alias() . '_currentEmployeePhoto'];

  if ($_FILES['image-upload']['size'] > 0 && $_FILES['image-upload']['error'] == 0) {
    $fileUpload = $_FILES['image-upload']['name'];
    $temp = $_FILES['image-upload']['tmp_name'];
    $type = $_FILES['image-upload']['type'];
    $ext = pathinfo($fileUpload, PATHINFO_EXTENSION);
    $employeePhoto = 'uploads/images/' . $employeeId . '/' . $employeeId . '.' . $ext;

    move_uploaded_file($temp, '../' . $employeePhoto);
  }

  $dob = isset($_POST['dob']) ? strtotime($_POST['dob']) : strtotime(date('Y-m-d'));
  $byear = date("Y", $dob);
  $bmonth = date("m", $dob);
  $bday = date("d", $dob);

  updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-others']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), sanitize($_POST['dual-citizenship-country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood_type']), sanitize($_POST['gsis']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), sanitize($_POST['email']), sanitize($_POST['tin']), sanitize($_POST['agency_id']), $employeePhoto, $employeeId);

  if (affectedRows() === 1) {
    $showPrompt = true;
    $message = 'Personal Information has been updated successfully!';
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['update-family-background'])) {
  $employeeId = $_SESSION[alias() . '_currentEmployeeId'];
  $slast = sanitize($_POST['slast']);
  $sfirst = sanitize($_POST['sfirst']);
  $sext = sanitize($_POST['sext']);
  $smiddle = sanitize($_POST['smiddle']);
  $swork = sanitize($_POST['swork']);
  $sbusiness = sanitize($_POST['sbusiness']);
  $sbusinessAddress = sanitize($_POST['sbusiness-address']);
  $stelephone = sanitize($_POST['stelephone']);
  $flast = sanitize($_POST['flast']);
  $ffirst = sanitize($_POST['ffirst']);
  $fext = sanitize($_POST['fext']);
  $fmiddle = sanitize($_POST['fmiddle']);
  $mlast = sanitize($_POST['mlast']);
  $mfirst = sanitize($_POST['mfirst']);
  $mmiddle = sanitize($_POST['mmiddle']);

  if (numRows(family($employeeId)) === 0) {
    createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
  } else {
    updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
  }

  if (affectedRows() === 1) {
    $message = 'Family Background has been updated successfully!';
    $show_prompt = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'family-background';
}

/* CHILDREN */
if (isset($_POST['save-child'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $child_id = !empty($_SESSION[alias() . '_current_child_id']) ? $_SESSION[alias() . '_current_child_id'] : '';
  $clast = sanitize($_POST['clast']);
  $cfirst = sanitize($_POST['cfirst']);
  $cext = sanitize($_POST['cext']);
  $cmiddle = sanitize($_POST['cmiddle']);
  $cdob = sanitize($_POST['cdob']);

  if (empty($child_id)) {
    createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);

    $message = 'Child has been added successfully!';
  } else {
    updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $child_id);

    $message = 'Child has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_child_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'children';
}

if (isset($_POST['DeleteChild'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $child_id = $_SESSION[alias() . '_current_child_id'];

  deleteChild($employeeId, $child_id);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Child has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_child_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'children';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['SaveEducation'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $education_id = !empty($_SESSION[alias() . '_current_education_id']) ? $_SESSION[alias() . '_current_education_id'] : '';
  $level = sanitize($_POST['level']);
  $school = sanitize($_POST['school']);
  $course = sanitize($_POST['course']);
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $ispresent = isset($_POST['ispresent']);
  $highest = sanitize($_POST['highest']);
  $year = sanitize($_POST['year']);
  $scholarship = sanitize($_POST['scholarship']);

  if (empty($education_id)) {
    createEducation($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $employeeId);

    $message = 'Educational Background has been added successfully!';
  } else {
    updateEducation($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $employeeId, $education_id);

    $message = 'Educational Background has been updated successfully!';
  }

  if (affectedRows($con) === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_education_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'educational-background';
}

if (isset($_POST['DeleteEducation'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $education_id = $_SESSION[alias() . '_current_education_id'];

  deleteEducation($employeeId, $education_id);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Educational Background has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_education_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'educational-background';
}

/* CIVIL SERVICE ELIGIBILITY */
if (isset($_POST['SaveEligibility'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $eligibility_id = !empty($_SESSION[alias() . '_current_eligibility_id']) ? $_SESSION[alias() . '_current_eligibility_id'] : '';
  $career = sanitize($_POST['career']);
  $rating = sanitize($_POST['rating']);
  $exam_date = sanitize($_POST['exam_date']);
  $exam_place = sanitize($_POST['exam_place']);
  $license = sanitize($_POST['license']);
  $is_applicable = isset($_POST['isapplicable']);
  $validity = sanitize($_POST['validity']);

  if (empty($eligibility_id)) {
    createEligibility($career, $rating, $exam_date, $exam_place, $license, $is_applicable, $validity, $employeeId);

    $message = 'Civil Service Eligibility has been added successfully!';
  } else {
    updateEligibility($career, $rating, $exam_date, $exam_place, $license, $is_applicable, $validity, $employeeId, $eligibility_id);

    $message = 'Civil Service Eligibility has been updated successfully!';
  }

  if (affectedRows($con) === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_eligibility_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'civil-service-eligibility';
}

if (isset($_POST['DeleteEligibility'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $eligibility_id = $_SESSION[alias() . '_current_eligibility_id'];

  deleteEligibility($employeeId, $eligibility_id);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Civil Service Eligibility has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_eligibility_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'civil-service-eligibility';
}

/* WORK EXPERIENCE */
if (isset($_POST['SaveExperience'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $experienceId = !empty($_SESSION[alias() . '_current_work_experience_id']) ? $_SESSION[alias() . '_current_work_experience_id'] : '';
  $from = sanitize($_POST['from']);
  $ispresent = isset($_POST['ispresent']);
  $to = $ispresent ? date('m/d/Y') : sanitize($_POST['to']);
  $position = sanitize($_POST['position']);
  $organization = sanitize($_POST['organization']);
  $salary = isset($_POST['salary']) ? $_POST['salary'] : 0;
  $sg = sanitize($_POST['sg']);
  $status = sanitize($_POST['status']);
  $isgovernment = sanitize($_POST['isgovernment']);

  if (empty($experienceId)) {
    createExperience($from, $to, $ispresent, $position, $organization, $salary, $sg, $status, $isgovernment, $employeeId);

    $message = 'Work Experience has been added successfully!';
  } else {
    updateExperience($from, $to, $ispresent, $position, $organization, $salary, $sg, $status, $isgovernment, $employeeId, $experienceId);

    $message = 'Work Experience has been updated successfully!';
  }

  if (affectedRows($con) === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_work_experience_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'work-experience';
}

if (isset($_POST['DeleteWorkExperience'])) {
  $employeeId = $_SESSION[alias() . '_current_employee_id'];
  $experienceId = $_SESSION[alias() . '_current_work_experience_id'];

  deleteExperience($employeeId, $experienceId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Work Experience has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_activeTab'] = 'work-experience';
}
?>