<?php
// hrmis/app.php
$_SESSION[alias() . '_active_app'] = 'hrmis';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

$user_id = $_SESSION[alias() . '_user_id'];

if (num_rows(user_role($user_id, 'HRMO')) === 0) {
  if (isset($_SESSION[alias() . '_active_app'])) {
    redirect(uri() . '/' . $_SESSION[alias() . '_active_app']);
  } else {
    redirect(uri() . '/pis');
  }
}

$success = true;
$show_prompt = false;
$message = null;
$page = $app_title = "Human Resource Management Information System";

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('hrmis', 'Employee Search', sanitize($_POST['primary_search_text'])));
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

  update_employee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil_status']), sanitize($_POST['civil_status_others']), sanitize($_POST['citizenship']), sanitize($_POST['dual_citizenship']), sanitize($_POST['citizenship_country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood_type']), sanitize($_POST['gsis']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), sanitize($_POST['email']), sanitize($_POST['tin']), sanitize($_POST['agency_id']), $employee_photo, $employee_id);

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
  $slast = sanitize($_POST['slast']);
  $sfirst = sanitize($_POST['sfirst']);
  $sext = sanitize($_POST['sext']);
  $smiddle = sanitize($_POST['smiddle']);
  $swork = sanitize($_POST['swork']);
  $sbusiness = sanitize($_POST['sbusiness']);
  $sbusiness_address = sanitize($_POST['sbusiness_address']);
  $stelephone = sanitize($_POST['stelephone']);
  $flast = sanitize($_POST['flast']);
  $ffirst = sanitize($_POST['ffirst']);
  $fext = sanitize($_POST['fext']);
  $fmiddle = sanitize($_POST['fmiddle']);
  $mlast = sanitize($_POST['mlast']);
  $mfirst = sanitize($_POST['mfirst']);
  $mmiddle = sanitize($_POST['mmiddle']);

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
  $clast = sanitize($_POST['clast']);
  $cfirst = sanitize($_POST['cfirst']);
  $cext = sanitize($_POST['cext']);
  $cmiddle = sanitize($_POST['cmiddle']);
  $cdob = sanitize($_POST['cdob']);

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
  $level = sanitize($_POST['level']);
  $school = sanitize($_POST['school']);
  $course = sanitize($_POST['course']);
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $highest = sanitize($_POST['highest']);
  $year = sanitize($_POST['year']);
  $scholarship = sanitize($_POST['scholarship']);

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