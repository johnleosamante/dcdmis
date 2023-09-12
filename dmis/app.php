<?php
// dmis/app.php
if (isPublicDomain()) {
  redirect(uri() . '/oops?e=403');
}

restrictPublicAccess(hasHoliday());

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, 'dmis')) === 0) {
  redirect(uri() . '/pis');
}

$activeApp = $_SESSION[alias() . '_activeApp'] = 'dmis';
$page = $appTitle = 'Division Management Information System';

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('dmis', 'Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-school'])) {
  $referenceSchoolId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $referenceAlias = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $schoolId = sanitize($_POST['school-id']);
  $schoolName = sanitize($_POST['school-name']);
  $alias = sanitize($_POST['alias']);
  $address = sanitize($_POST['address']);
  $districtCode = sanitize($_POST['district']);
  $category = sanitize($_POST['category']);
  $status = 'saved';
  $logMessage = 'Added school';
  $logo = 'assets/img/division.png';

  if (numRows(schoolById($referenceSchoolId)) === 0) {
    createSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $logo);
  } else {
    updateUsersStation($schoolId, $referenceSchoolId);
    updateStationID($schoolId, $referenceSchoolId);
    updateTransactionLogFrom($alias, $referenceAlias);
    updateTransactionLogTo($alias, $referenceAlias);
    updateTransactionFrom($alias, $referenceAlias);
    updateSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $referenceSchoolId);

    $status = 'updated';
    $logMessage = 'Updated school';
  }

  $showAlert = true;
  $link = '[<a href="' . customUri('dmis', 'School Information', $schoolId) . '" title="View ' . $schoolName . ' information">' . strtoupper($schoolName) . '</a>]';

  if (affectedRows()) {
    $message = 'School ' . $link . ' has been ' . $status . ' successfully.';

    createSystemLog($stationId, $userId, $logMessage, $schoolId, clientIp());
  } else {
    $message = 'No changes have been made to school ' . $link . '.';
    $success = false;
  }
}

if (isset($_POST['save-section'])) {
  $referenceSectionId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $alias = sanitize($_POST['alias']);
  $section = sanitize($_POST['section']);
  $division = sanitize($_POST['division']);
  $head = sanitize($_POST['head']);
  $status = 'saved';
  $logMessage = 'Added section';

  if (numRows(section($referenceSectionId)) === 0) {
    createSection($alias, $head, $section, $division);
  } else {
    updateUsersStation($alias, $referenceSectionId, strtolower($alias . '_portal'));
    updateTransactionLogFrom($alias, $referenceSectionId);
    updateTransactionLogTo($alias, $referenceSectionId);
    updateTransactionFrom($alias, $referenceSectionId);
    updateSection($alias, $head, $section, $division, $referenceSectionId);

    $status = 'updated';
    $logMessage = 'Updated section';
  }

  $showAlert = true;
  $link = '[<a href="' . customUri('dmis', 'Section Information', $alias) . '" title="View ' . $section . ' information">' . strtoupper($section) . '</a>]';

  if (affectedRows()) {
    $message = 'Section ' . $link . ' has been ' . $status . ' successfully.';

    createSystemLog($stationId, $userId, $logMessage, $alias, clientIp());
  } else {
    $message = 'No changes have been made to section ' . $link . '.';
    $success = false;
  }
}

if (isset($_POST['save-district'])) {
  $referenceDistrictId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $districtCode = sanitize($_POST['code']);
  $districtName = sanitize($_POST['district']);
  $districtHead = sanitize($_POST['head']);
  $status = 'saved';
  $logMessage = 'Added district';

  if (numRows(district($referenceDistrictId)) === 0) {
    createDistrict($districtCode, $districtName, $districtHead);
  } else {
    updateDistrict($districtCode, $districtName, $districtHead, $referenceDistrictId);

    $status = 'updated';
    $logMessage = 'Updated district';
  }

  $showAlert = true;
  $link = '[<a href="' . customUri('dmis', 'District Information', $districtCode) . '" title="View ' . $districtName . ' information">' . strtoupper($districtName) . '</a>]';

  if (affectedRows()) {
    $message = 'District ' . $link . ' has been ' . $status . ' successfully.';

    createSystemLog($stationId, $userId, $logMessage, $districtCode, clientIp());
  } else {
    $message = 'No changes have been made to district ' . $link . '.';
    $success = false;
  }
}

if (isset($_POST['edit-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $userEmail = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $userRole = 'Administrator';
  $isDtsUser = isset($_POST['dts']);
  $dtsStation = isset($_POST['dts-verifier']) ? sanitize($_POST['dts-verifier']) : null;
  $dtsPortal = numRows(section($dtsStation)) > 0 ? strtolower($dtsStation . '_portal') : 'sch_portal';
  $isHrmisUser = isset($_POST['hrmis']);
  $isDmisUser = isset($_POST['dmis']);
  $isHrtdmsUser = isset($_POST['hrtdms']);

  if (empty($employeeId)) {
    return;
  }

  if ($isDtsUser) {
    if (numRows(dtsUser($employeeId)) > 0) {
      updateUserRole($employeeId, $dtsStation, $dtsPortal);
    } else {
      createUserRole($employeeId, $userRole, $dtsStation, $dtsPortal);
    }
  } else {
    deleteUserRole($employeeId, $dtsStation);
  }

  if ($isHrmisUser) {
    if (!isStationUser($employeeId, 'HRMIS')) {
      createUserRole($employeeId, $userRole, 'HRMIS');
    } 
  } else {
    deleteUserRole($employeeId, 'HRMIS');
  }

  if ($isDmisUser) {
    if (!isStationUser($employeeId, 'DMIS')) {
      createUserRole($employeeId, $userRole, 'DMIS');
    } 
  } else {
    deleteUserRole($employeeId, 'DMIS');
  }

  if ($isHrtdmsUser) {
    if (!isStationUser($employeeId, 'HRTDMS')) {
      createUserRole($employeeId, $userRole, 'HRTDMS');
    } 
  } else {
    deleteUserRole($employeeId, 'HRTDMS');
  }

  $showAlert = true;
  $employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'https://localhost/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')">' . userName($employeeId, true) . '</a>';
  $message = 'Employee [' . $employee . '] user assignment has been set successfully.';

  createSystemLog($stationId, $userId, 'Assigned user privileges', $employeeId, clientIp());
}

if (isset($_POST['reset-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $temporaryPassword = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  updateAccountPassword($employeeId, hashPassword($temporaryPassword));

  $showAlert = true;
  $employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'https://localhost/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')">' . userName($employeeId, true) . '</a>';

  if (affectedRows()) {
    $message = 'Employee [' . $employee . '] password has been reset successfully.';
    
    createSystemLog($stationId, $userId, 'Reset user password', $employeeId, clientIp());
  } else {
    $message = 'No changes have been made to employee [' . $employee . ']  password.';
    $success = false;
  }
}

if (isset($_POST['remove-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;

  deleteUserRoles($employeeId);

  $showAlert = true;
  $employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'https://localhost/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')">' . userName($employeeId, true) . '</a>';

  if (affectedRows()) {
    $message = 'Employee [' . $employee . '] user privileges have been removed successfully.';
    
    createSystemLog($stationId, $userId, 'Removed user privileges', $employeeId, clientIp());
  } else {
    $message = 'No changes have been made to employee [' . $employee . '] user privileges.';
    $success = false;
  }
}
?>