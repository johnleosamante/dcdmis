<?php
// dmis/app.php
if (isPublicDomain()) {
  redirect(uri() . '/oops?e=403');
}

restrictPublicAccess(hasHoliday());

$activeApp = $_SESSION[alias() . '_activeApp'] = 'dmis';
$page = $appTitle = 'Division Management Information System';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('dmis', 'Search', sanitize($_POST['primary-search-text'])));
}

// School Management
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
    updateTransactionFrom($schoolId, $alias, $referenceSchoolId, $referenceAlias);
    updateSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $referenceSchoolId);
    $status = 'updated';
    $logMessage = 'Updated school';
  }

  if (affectedRows()) {
    $message = 'School [<a href="' . customUri('dmis', 'School Information', $schoolId) . '" title="View ' . $schoolName . ' information">' . $schoolName . '</a>] has been ' . $status . ' successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $schoolId, clientIp());
  }
}

// User management
if (isset($_POST['edit-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $userEmail = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $userRole = 'Administrator';
  $isDtsUser = isset($_POST['dts']);
  $dtsStation = isset($_POST['dts-verifier']) ? sanitize($_POST['dts-verifier']) : null;
  $dtsPortal = numRows(section($dtsStation)) > 0 ? strtoupper($dtsStation . '_portal') : 'sch_portal';
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
      createUserRole($employeeId, $userEmail, $userRole, $dtsStation, $dtsPortal);
    }
  } else {
    deleteUserRole($employeeId, $dtsStation);
  }

  if ($isHrmisUser) {
    if (!isStationUser($employeeId, 'HRMIS')) {
      createUserRole($employeeId, $userEmail, $userRole, 'HRMIS');
    } 
  } else {
    deleteUserRole($employeeId, 'HRMIS');
  }

  if ($isDmisUser) {
    if (!isStationUser($employeeId, 'DMIS')) {
      createUserRole($employeeId, $userEmail, $userRole, 'DMIS');
    } 
  } else {
    deleteUserRole($employeeId, 'DMIS');
  }

  if ($isHrtdmsUser) {
    if (!isStationUser($employeeId, 'HRTDMS')) {
      createUserRole($employeeId, $userEmail, $userRole, 'HRTDMS');
    } 
  } else {
    deleteUserRole($employeeId, 'HRTDMS');
  }

  $showAlert = true;
  $message = 'User assignment has been set successfully.';
  $success = true;
  createSystemLog($stationId, $userId, 'Assigned user privileges', $employeeId, clientIp());
}

if (isset($_POST['reset-user'])) {
  $depedEmail = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $temporaryPassword = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  updateAccountPassword($depedEmail, hashPassword($temporaryPassword));

  if (affectedRows()) {
    $employeeId = fetchAssoc(account($depedEmail))['id'];
    $showAlert = true;
    $message = 'User password has been reset successfully.';
    $success = true;
    createSystemLog($stationId, $userId, 'Reset user password', $employeeId, clientIp());
  }
}

if (isset($_POST['remove-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;

  deleteUserRoles($employeeId);

  if (affectedRows()) {
    $showAlert = true;
    $message = 'User has been removed successfully.';
    $success = true;
    createSystemLog($stationId, $userId, 'Removed user privileges', $employeeId, clientIp());
  }
}
?>