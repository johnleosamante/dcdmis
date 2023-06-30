<?php
// dmis/app.php
restrictPublicAccess();

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
}

if (isset($_POST['reset-user'])) {
  $depedEmail = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $temporaryPassword = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  updateAccountPassword($depedEmail, hashPassword($temporaryPassword));

  if (affectedRows() === 1) {
    $showAlert = true;
    $message = 'User password has been reset successfully.';
    $success = true;
  }
}

if (isset($_POST['remove-user'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;

  deleteUserRoles($employeeId);

  if (affectedRows() === 1) {
    $showAlert = true;
    $message = 'User has been removed successfully.';
    $success = true;
  }
}
?>