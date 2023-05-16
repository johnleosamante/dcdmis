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

  if (num_rows(employee($employee_id)) === 0) {
    return;
  }

  if ($_FILES['imageUpload']['size'] > 0 && $_FILES['imageUpload']['error'] == 0) {
    $myfile = $_FILES['imageUpload']['name'];
    $temp = $_FILES['imageUpload']['tmp_name'];
    $type = $_FILES['imageUpload']['type'];
    $ext = pathinfo($myfile, PATHINFO_EXTENSION);
    $employee_photo = 'uploads/images/' . $employee_id . '/' . $employee_id . '.' . $ext;

    move_uploaded_file($temp, '../' . $employee_photo);
  }

  $dob = strtotime($_POST['dob']);
  $byear = date("Y", $dob);
  $bmonth = date("m", $dob);
  $bday = date("d", $dob);

  update_employee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil_status']), sanitize($_POST['civil_status_others']), sanitize($_POST['citizenship']), sanitize($_POST['dual_citizenship']), sanitize($_POST['dual_citizenship_country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood_type']), sanitize($_POST['gsis']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), sanitize($_POST['email']), sanitize($_POST['tin']), sanitize($_POST['agency_id']), $employee_photo, $employee_id);

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

  if (num_rows(employee($employee_id)) === 0) {
    return;
  }

  if (num_rows(family($employee_id)) === 0) {
    create_family(sanitize($_POST['slast']), sanitize($_POST['sfirst']), sanitize($_POST['sext']), sanitize($_POST['smiddle']), sanitize($_POST['swork']), sanitize($_POST['sbusiness']), sanitize($_POST['sbusiness_address']), sanitize($_POST['stelephone']), sanitize($_POST['flast']), sanitize($_POST['ffirst']), sanitize($_POST['fext']), sanitize($_POST['fmiddle']), sanitize($_POST['mlast']), sanitize($_POST['mfirst']), sanitize($_POST['mmiddle']), $employee_id);
  } else {
    update_family(sanitize($_POST['slast']), sanitize($_POST['sfirst']), sanitize($_POST['sext']), sanitize($_POST['smiddle']), sanitize($_POST['swork']), sanitize($_POST['sbusiness']), sanitize($_POST['sbusiness_address']), sanitize($_POST['stelephone']), sanitize($_POST['flast']), sanitize($_POST['ffirst']), sanitize($_POST['fext']), sanitize($_POST['fmiddle']), sanitize($_POST['mlast']), sanitize($_POST['mfirst']), sanitize($_POST['mmiddle']), $employee_id);
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
  $child_id = $_SESSION[alias() . '_current_child_id'];

  if (num_rows(child($child_id)) === 0) {
    create_child(sanitize($_POST['clast']), sanitize($_POST['cfirst']), sanitize($_POST['cext']), sanitize($_POST['cmiddle']), sanitize($_POST['cdob']), $employee_id);

    $message = 'Child has been added successfully!';
  } else {
    update_child(sanitize($_POST['clast']), sanitize($_POST['cfirst']), sanitize($_POST['cext']), sanitize($_POST['cmiddle']), sanitize($_POST['cdob']), $employee_id, $child_id);

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
    $message = 'Child has been removed successfully!';
    $show_prompt = true;
  }

  $_SESSION[alias() . '_current_child_id'] = '';
  $_SESSION[alias() . '_pds_tab'] = 'children';
}
?>