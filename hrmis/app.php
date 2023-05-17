<?php
// hrmis/app.php
$_SESSION[alias() . '_active_app'] = 'hrmis';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

$user_id = $_SESSION[alias() . '_user_id'];
$success = true;
$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app_title = "Human Resource Management Information System";

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('hrmis', 'Employee Search', real_escape_string($_POST['primary_search_text'])));
}

/* PERSONAL INFORMATION */
if (isset($_POST['UpdatePersonalInformation'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $employee_photo = $_SESSION[alias() . '_current_employee_photo'];

  if ($_FILES['imageUpload']['size'] > 0 && $_FILES['imageUpload']['error'] == 0) {
    $myfile = $_FILES['imageUpload']['name'];
    $temp = $_FILES['imageUpload']['tmp_name'];
    $type = $_FILES['imageUpload']['type'];
    $ext = pathinfo($myfile, PATHINFO_EXTENSION);
    $employee_photo = 'uploads/images/' . $employee_id . '/' . $employee_id . '.' . $ext;

    move_uploaded_file($temp, '../' . $employee_photo);
  }

  $dob = !empty($_POST['dob']) ? strtotime($_POST['dob']) : strtotime(date('Y-m-d'));
  $byear = date("Y", $dob);
  $bmonth = date("m", $dob);
  $bday = date("d", $dob);

  update_employee(
    !empty($_POST['lname']) ? sanitize($_POST['lname']) : '',
    !empty($_POST['fname']) ? sanitize($_POST['fname']) : '',
    !empty($_POST['mname']) ? sanitize($_POST['mname']) : '',
    !empty($_POST['ext']) ? sanitize($_POST['ext']) : '', 
    $bmonth, $bday, $byear,
    !empty($_POST['pob']) ? sanitize($_POST['pob']) : '',
    !empty($_POST['sex']) ? sanitize($_POST['sex']) : '',
    !empty($_POST['civil_status']) ? sanitize($_POST['civil_status']) : '',
    !empty($_POST['civil_status_others']) ? sanitize($_POST['civil_status_others']) : '',
    !empty($_POST['citizenship']) ? sanitize($_POST['citizenship']) : '',
    !empty($_POST['dual_citizenship']) ? sanitize($_POST['dual_citizenship']) : '',
    !empty($_POST['citizenship_country']) ? sanitize($_POST['citizenship_country']) : '',
    !empty($_POST['rlot']) ? sanitize($_POST['rlot']) : '',
    !empty($_POST['rstreet']) ? sanitize($_POST['rstreet']) : '',
    !empty($_POST['rsubdivision']) ? sanitize($_POST['rsubdivision']) : '',
    !empty($_POST['rbarangay']) ? sanitize($_POST['rbarangay']) : '',
    !empty($_POST['rcity']) ? sanitize($_POST['rcity']) : '',
    !empty($_POST['rprovince']) ? sanitize($_POST['rprovince']) : '',
    !empty($_POST['rzip']) ? sanitize($_POST['rzip']) : '',
    !empty($_POST['plot']) ? sanitize($_POST['plot']) : '',
    !empty($_POST['pstreet']) ? sanitize($_POST['pstreet']) : '',
    !empty($_POST['psubdivision']) ? sanitize($_POST['psubdivision']) : '',
    !empty($_POST['pbarangay']) ? sanitize($_POST['pbarangay']) : '',
    !empty($_POST['pcity']) ? sanitize($_POST['pcity']) : '',
    !empty($_POST['pprovince']) ? sanitize($_POST['pprovince']) : '',
    !empty($_POST['pzip']) ? sanitize($_POST['pzip']) : '',
    !empty($_POST['height']) ? sanitize($_POST['height']) : '',
    !empty($_POST['weight']) ? sanitize($_POST['weight']) : '',
    !empty($_POST['blood_type']) ? sanitize($_POST['blood_type']) : '',
    !empty($_POST['gsis']) ? sanitize($_POST['gsis']) : '',
    !empty($_POST['pagibig']) ? sanitize($_POST['pagibig']) : '',
    !empty($_POST['philhealth']) ? sanitize($_POST['philhealth']) : '',
    !empty($_POST['sss']) ? sanitize($_POST['sss']) : '',
    !empty($_POST['telephone']) ? sanitize($_POST['telephone']) : '',
    !empty($_POST['mobile']) ? sanitize($_POST['mobile']) : '',
    !empty($_POST['email']) ? sanitize($_POST['email']) : '',
    !empty($_POST['tin']) ? sanitize($_POST['tin']) : '',
    !empty($_POST['agency_id']) ? sanitize($_POST['agency_id']) : '', 
    $employee_photo, $employee_id);

  if (affected_rows() === 1) {
    $success = true;
    $message = 'Personal Information has been updated successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_pds_tab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['UpdateFamilyBackground'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $slast = !empty($_POST['slast']) ? sanitize($_POST['slast']) : '';
  $sfirst = !empty($_POST['sfirst']) ? sanitize($_POST['sfirst']) : '';
  $sext = !empty($_POST['sext']) ? sanitize($_POST['sext']) : '';
  $smiddle = !empty($_POST['smiddle']) ? sanitize($_POST['smiddle']) : '';
  $swork = !empty($_POST['swork']) ? sanitize($_POST['swork']) : '';
  $sbusiness = !empty($_POST['sbusiness']) ? sanitize($_POST['sbusiness']) : '';
  $sbusiness_address = !empty($_POST['sbusiness_address']) ? sanitize($_POST['sbusiness_address']) : '';
  $stelephone = !empty($_POST['stelephone']) ? sanitize($_POST['stelephone']) : '';
  $flast = !empty($_POST['flast']) ? sanitize($_POST['flast']) : '';
  $ffirst = !empty($_POST['ffirst']) ? sanitize($_POST['ffirst']) : '';
  $fext = !empty($_POST['fext']) ? sanitize($_POST['fext']) : '';
  $fmiddle = !empty($_POST['fmiddle']) ? sanitize($_POST['fmiddle']) : '';
  $mlast = !empty($_POST['mlast']) ? sanitize($_POST['mlast']) : '';
  $mfirst = !empty($_POST['mfirst']) ? sanitize($_POST['mfirst']) : '';
  $mmiddle = !empty($_POST['mmiddle']) ? sanitize($_POST['mmiddle']) : '';

  if (num_rows(family($employee_id)) === 0) {
    create_family($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employee_id);
  } else {
    update_family($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusiness_address, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employee_id);
  }

  if (affected_rows() === 1) {
    $success = true;
    $message = 'Family Background has been updated successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_pds_tab'] = 'family-background';
}

/* CHILDREN */
if (isset($_POST['SaveChild'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $child_id = !empty($_SESSION[alias() . '_current_child_id']) ? $_SESSION[alias() . '_current_child_id'] : '';
  $clast = !empty($_POST['clast']) ? sanitize($_POST['clast']) : '';
  $cfirst = !empty($_POST['cfirst']) ? sanitize($_POST['cfirst']) : '';
  $cext = !empty($_POST['cext']) ? sanitize($_POST['cext']) : '';
  $cmiddle = !empty($_POST['cmiddle']) ? sanitize($_POST['cmiddle']) : '';
  $cdob = !empty($_POST['cdob']) ? sanitize($_POST['cdob']) : '';

  if (strlen($child_id) === 0) {
    create_child($clast, $cfirst, $cext, $cmiddle, $cdob, $employee_id);

    $message = 'Child has been added successfully!';
  } else {
    update_child($clast, $cfirst, $cext, $cmiddle, $cdob, $employee_id, $child_id);

    $message = 'Child has been updated successfully!';
  }

  if (affected_rows() === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_child_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'children';
}

if (isset($_POST['DeleteChild'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $child_id = $_SESSION[alias() . '_current_child_id'];

  delete_child($employee_id, $child_id);

  if (affected_rows() === 1) {
    $success = true;
    $message = 'Child has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_child_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'children';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['SaveEducation'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $education_id = !empty($_SESSION[alias() . '_current_education_id']) ? $_SESSION[alias() . '_current_education_id'] : '';
  $level = !empty($_POST['level']) ? sanitize($_POST['level']) : '';
  $school = !empty($_POST['school']) ? sanitize($_POST['school']) : '';
  $course = !empty($_POST['course']) ? sanitize($_POST['course']) : '';
  $from = !empty($_POST['from']) ? sanitize($_POST['from']) : '';
  $to = !empty($_POST['to']) ? sanitize($_POST['to']) : '';
  $highest = !empty($_POST['highest']) ? sanitize($_POST['highest']) : '';
  $year = !empty($_POST['year']) ? sanitize($_POST['year']) : '';
  $scholarship = !empty($_POST['scholarship']) ? sanitize($_POST['scholarship']) : '';

  if (strlen($education_id) === 0) {
    create_education($level, $school, $course, $from, $to, $highest, $year, $scholarship, $employee_id);

    $message = 'Educational Background has been added successfully!';
  } else {
    update_education($level, $school, $course, $from, $to, $highest, $year, $scholarship, $employee_id, $education_id);

    $message = 'Educational Background has been updated successfully!';
  }

  if (mysqli_affected_rows($con) === 1) {
    $success = true;
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_education_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'educational-background';
}

if (isset($_POST['DeleteEducation'])) {
  $employee_id = $_SESSION[alias() . '_current_employee_id'];
  $education_id = $_SESSION[alias() . '_current_education_id'];

  delete_education($employee_id, $education_id);

  if (affected_rows() === 1) {
    $success = true;
    $message = 'Educational background has been deleted successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_education_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'educational-background';
}
?>