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

if (numRows(userRole($userId, 'dmis')) === 0) {
	redirect(uri() . '/pis');
}

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
	$showAlert = true;
	$link = '[<a href="' . customUri('dmis', 'School Information', $schoolId) . '" title="View ' . $schoolName . ' information">' . strtoupper($schoolName) . '</a>]';

	if (numRows(schoolById($referenceSchoolId)) === 0) {
		createSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, '');
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
	$showAlert = true;
	$link = '[<a href="' . customUri('dmis', 'Section Information', $alias) . '" title="View ' . $section . ' information">' . strtoupper($section) . '</a>]';

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
	$showAlert = true;
	$link = '[<a href="' . customUri('dmis', 'District Information', $districtCode) . '" title="View ' . $districtName . ' information">' . strtoupper($districtName) . '</a>]';

	if (numRows(district($referenceDistrictId)) === 0) {
		createDistrict($districtCode, $districtName, $districtHead);
	} else {
		updateDistrict($districtCode, $districtName, $districtHead, $referenceDistrictId);

		$status = 'updated';
		$logMessage = 'Updated district';
	}

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
	$showAlert = true;
	$employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';
	$message = 'Employee [' . $employee . '] user assignment has been set successfully.';

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

	createSystemLog($stationId, $userId, 'Assigned user privileges', $employeeId, clientIp());
}

if (isset($_POST['reset-user'])) {
	$employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$temporaryPassword = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
	$emails = employee($employeeId);
	$userEmail = numRows($emails) > 0 ? fetchAssoc($emails)['email'] : '';
	$showAlert = true;
	$employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';

	updateAccountPassword($employeeId, hashPassword($temporaryPassword), 'Default');

	if (affectedRows()) {
		$message = 'Employee [' . $employee . '] password has been reset successfully. An email has been sent to [' . $userEmail . '].';

		createSystemLog($stationId, $userId, 'Reset user password', $employeeId, clientIp());

		$emailMessage = 'Good day! You request for password reset has been approved!' . PHP_EOL . PHP_EOL .
			'Your temporary password is: ' . $temporaryPassword . PHP_EOL . PHP_EOL .
			'Please login to: http://depeddipolog.net/login to confirm.' . PHP_EOL . PHP_EOL .
			'If you did not request this change please contact us for assistance. Thank you.' . PHP_EOL . PHP_EOL . PHP_EOL .
			'***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****';;

		if (sendMail($userEmail, 'Employee Password Reset', $emailMessage)) {
			createSystemLog($stationId, $userId, 'Password reset code sent', $employeeId, clientIp());
		}
	} else {
		$message = 'No changes have been made to employee [' . $employee . ']  password.';
		$success = false;
	}
}

if (isset($_POST['remove-user'])) {
	$employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$showAlert = true;
	$employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';

	deleteUserRoles($employeeId);

	if (affectedRows()) {
		$message = 'Employee [' . $employee . '] user privileges have been removed successfully.';

		createSystemLog($stationId, $userId, 'Removed user privileges', $employeeId, clientIp());
	} else {
		$message = 'No changes have been made to employee [' . $employee . '] user privileges.';
		$success = false;
	}
}
