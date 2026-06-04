<?php
// dmis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'dmis';
$page = $appTitle = 'Division Management Information System';

if (!isset($userId)) {
	redirect("$baseUri/login");
}

if (!userRole($userId, 'dmis')) {
	redirect("$baseUri/pis");
}

if (isset($_POST['save-school'])) {
	$referenceSchoolId = sanitize(decipher($_POST['verifier'] ?? null));
	$referenceAlias = sanitize(decipher($_POST['data-verifier'] ?? null));
	$schoolId = sanitize($_POST['school-id']);
	$schoolName = sanitize($_POST['school-name']);
	$alias = sanitize($_POST['alias']);
	$address = sanitize($_POST['address']);
	$districtCode = sanitize($_POST['district']);
	$category = sanitize($_POST['category']);
	$telephone = sanitize($_POST['telephone']);
	$email = sanitize($_POST['email']);
	$website = sanitize($_POST['website']);
	$facebook = sanitize($_POST['facebook']);
	$logo = sanitize(decipher($_POST['image-verifier'] ?? null));
	$showAlert = true;
	$success = false;
	$stagedFile = null;
	$link = '[<a href="' . customUri('dmis', 'School Information', $schoolId) . '" title="View ' . $schoolName . ' information">' . strtoupper($schoolName) . '</a>]';

	try {
		if (is_uploaded_file($_FILES['logo-upload']['tmp_name'])) {
			$stagedFile = stageUploadedFile(
				$_FILES['logo-upload'],
				['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif'],
				root() . "/uploads/school_logo/{$schoolId}",
				"LOGO"
			);
		}

		$finalLogoPath = $stagedFile ? "uploads/school_logo/{$schoolId}/{$stagedFile['secure_name']}" : $logo;

		beginTransaction();

		if (!schoolById($referenceSchoolId)) {
			if (createSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $telephone, $email, $website, $facebook, $finalLogoPath) === false) {
				throw new Exception('Failed to create new school data record entity.');
			}

			$status = 'saved';
			$logMessage = 'Added school';
		} else {
			if (updateSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $telephone, $email, $website, $facebook, $finalLogoPath, $referenceSchoolId) === false) {
				throw new Exception('Failed to execute parent data updates.');
			}

			if (updateUsersStation($schoolId, $referenceSchoolId) === false) {
				throw new Exception('User association update rejected.');
			}

			if (updateStationID($schoolId, $referenceSchoolId) === false) {
				throw new Exception('Station reference key update failed.');
			}

			if (updateTransactionLogFrom($alias, $referenceAlias) === false) {
				throw new Exception("Source tracking parameters rejected.");
			}

			if (updateTransactionLogTo($alias, $referenceAlias) === false) {
				throw new Exception("Destination verification update failure.");
			}

			if (updateTransactionFrom($alias, $referenceAlias) === false) {
				throw new Exception("Transaction state sync failed.");
			}

			$status = 'updated';
			$logMessage = 'Updated school';
		}

		if ($stagedFile) {
			commitStagedFile($stagedFile);
		}

		commit();

		$success = true;
		$message = "School {$link} has been {$status} successfully.";

		createSystemLog($stationId, $userId, $logMessage, $schoolId, clientIp());

		if ($stagedFile && !empty($logo) && file_exists(root() . "/{$logo}")) {
			unlink(root() . "/{$logo}");
		}
	} catch (Exception $e) {
		rollBack();

		if ($stagedFile && file_exists($stagedFile['full_path'])) {
			unlink($stagedFile['full_path']);
		}

		$message = $e->getMessage();
	}
}

/** TODO: Add to UI for implementation */
if (isset($_POST['delete-school'])) {
	$schoolId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$success = false;

	if (empty($schoolId)) {
		$message = "Invalid school identification parameters provided.";

		return;
	}

	$schoolRow = schoolById($schoolId);

	if (!$schoolRow || !isset($schoolRow['name'])) {
		$message = "Target school record could not be found or has already been removed.";

		return;
	}

	$schoolName = $schoolRow['name'];

	if (countActiveEmployees($schoolId) > 0) {
		$message = "Cannot delete [{$schoolName}]. You must reassign or remove its personnel records first.";

		return;
	}

	beginTransaction();

	try {
		$affectedRows = deleteSchool($schoolId);

		if ($affectedRows === false) {
			rollBack();

			$message = "A system error occurred. No changes have been made to the school record.";

			return;
		}

		commit();

		$success = true;
		$message = "School [{$schoolName}] has been deleted successfully.";
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, 'Deleted school', $schoolName, clientIp());
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Failed to complete deletion due to a structural constraint: " . $e->getMessage();
	}
}

if (isset($_POST['save-section'])) {
	$referenceSectionId = sanitize(decipher($_POST['verifier'] ?? null));
	$alias = sanitize($_POST['alias']);
	$section = sanitize($_POST['section']);
	$division = sanitize($_POST['division']);
	$head = sanitize($_POST['head']);
	$showAlert = true;
	$success = false;

	if (empty($alias) || empty($section)) {
		$message = "Section alias and name are required.";
		return;
	}

	$existingSectionData = !empty($referenceSectionId) ? section($referenceSectionId) : null;
	$sectionExists = !empty($existingSectionData);

	beginTransaction();

	try {
		if (!$sectionExists) {
			if (createSection($alias, $head, $section, $division) === false) {
				throw new Exception('Failed to create the new section record.');
			}

			$status = 'saved';
			$logMessage = 'Added section';
			$rowsMutated = 1;
		} else {
			if (updateUsersStation($alias, $referenceSectionId, strtolower("{$alias}_portal")) === false) {
				throw new Exception('System failed to update user station assignments.');
			}

			if (updateTransactionLogFrom($alias, $referenceSectionId) === false) {
				throw new Exception("System failed to update outward historical transaction logs.");
			}

			if (updateTransactionLogTo($alias, $referenceSectionId) === false) {
				throw new Exception("System failed to update inward historical transaction logs.");
			}

			if (updateTransactionFrom($alias, $referenceSectionId) === false) {
				throw new Exception("System failed to update parent transfer transaction logs.");
			}

			$affectedResult = updateSection($alias, $head, $section, $division, $referenceSectionId);

			if ($affectedResult === false) {
				throw new Exception('Failed to execute main section record update.');
			}

			$status = 'updated';
			$logMessage = 'Updated section';
			$rowsMutated = $affectedResult;
		}

		commit();
		$success = true;
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Transaction aborted: " . $e->getMessage();

		return;
	}

	$activeTrackingAlias = ($status === 'updated' && $rowsMutated === 0 && isset($existingSectionData['alias']))
		? $existingSectionData['alias']
		: $alias;
	$link = sprintf(
		'[<a href="%s" title="View %s information">%s</a>]',
		customUri('dmis', 'Section Information', $activeTrackingAlias),
		$section,
		strtoupper($section)
	);

	if ($status === 'updated' && $rowsMutated === 0) {
		$message = "Section {$link} changes matched historical parameters. No database rows were modified.";
	} else {
		$message = "Section {$link} has been {$status} successfully.";
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, $logMessage, $activeTrackingAlias, clientIp());
	}
}

/** TODO: Add delete-section and add to UI for implementation */

if (isset($_POST['save-district'])) {
	$referenceDistrictId = sanitize(decipher($_POST['verifier'] ?? null));
	$districtCode = sanitize($_POST['code']);
	$districtName = sanitize($_POST['district']);
	$districtHead = sanitize($_POST['head']);
	$showAlert = true;
	$success = false;

	if (empty($districtCode) || empty($districtName)) {
		$message = "District code and name are required fields.";

		return;
	}

	$existingDistrictData = !empty($referenceDistrictId) ? district($referenceDistrictId) : null;
	$districtExists = !empty($existingDistrictData);

	beginTransaction();

	try {
		if (!$districtExists) {
			$affectedResult = createDistrict($districtCode, $districtName, $districtHead);
			$status = 'saved';
			$logMessage = 'Added district';

			if ($affectedResult === false) {
				throw new Exception("Database rejected the new record insertion.");
			}
		} else {
			$affectedResult = updateDistrict($districtCode, $districtName, $districtHead, $referenceDistrictId);
			$status = 'updated';
			$logMessage = 'Updated district';

			if ($affectedResult === false) {
				throw new Exception("Database failed to update existing record target.");
			}
		}

		commit();

		$success = true;
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "System error processing district request: " . $e->getMessage();

		return;
	}

	$activeTrackingCode = ($status === 'updated' && $affectedResult === 0 && isset($existingDistrictData['code']))
		? $existingDistrictData['code']
		: $districtCode;

	$link = sprintf(
		'[<a href="%s" title="View %s information">%s</a>]',
		customUri('dmis', 'District Information', $activeTrackingCode),
		$districtName,
		strtoupper($districtName)
	);

	if ($status === 'updated' && $affectedResult === 0) {
		$message = "District {$link} details matched current records. No database modifications were needed.";
	} else {
		$message = "District {$link} has been {$status} successfully.";
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, $logMessage, $activeTrackingCode, clientIp());
	}
}

/** TODO: Add to UI for implementation */
if (isset($_POST['delete-district'])) {
	$districtCode = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$success = false;

	if (empty($districtCode)) {
		$message = "Invalid district identification provided.";
		return;
	}

	$districtRow = district($districtCode);

	if (!$districtRow || !isset($districtRow['name'])) {
		$message = "Target district could not be found or has already been removed.";
		return;
	}

	$districtName = $districtRow['name'];

	if (schoolsByDistrict($districtCode)) {
		$message = "Cannot delete [{$districtName}]. You must reassign or remove its schools first.";
		return;
	}

	beginTransaction();

	try {
		$affectedRows = deleteDistrict($districtCode);

		if ($affectedRows === false) {
			rollBack();
			$message = "A database error occurred. No changes have been made to the district.";
			return;
		}

		commit();

		$success = true;
		$message = "District [{$districtName}] has been deleted successfully.";
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, 'Deleted district', $districtName, clientIp());
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Failed to complete deletion due to a system restriction: " . $e->getMessage();
	}
}

if (isset($_POST['delete-employee'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$success = false;

	if (empty($employeeId)) {
		$message = "Invalid employee identifier provided.";
		return;
	}

	$employeeRow = employee($employeeId);

	if (!$employeeRow) {
		$message = "Employee record not found or has already been deleted.";
		return;
	}

	$targetName = userName($employeeId) ?: "Employee ID: {$employeeId}";

	beginTransaction();

	try {
		$cleanupTasks = [
			'attachments' => deleteFileAttachments($employeeId),
			'identification' => deleteIdentification($employeeId),
			'account' => deleteAccount($employeeId),
			'roles' => deleteUserRoles($employeeId),
			'education' => deleteEducations($employeeId),
			'eligibility' => deleteEligibilities($employeeId),
			'experience' => deleteExperiences($employeeId),
			'children' => deleteChildren($employeeId),
			'family' => deleteFamily($employeeId),
			'trainings' => deleteParticipantTrainings($employeeId),
			'memberships' => deleteMemberships($employeeId),
			'other_info' => deleteOtherInformation($employeeId),
			'recognitions' => deleteRecognitions($employeeId),
			'references' => deleteReferences($employeeId),
			'skills' => deleteSpecialSkills($employeeId),
			'voluntary' => deleteVoluntaryWorks($employeeId),
			'station' => deleteStation($employeeId)
		];

		foreach ($cleanupTasks as $taskName => $result) {
			if ($result === false) {
				throw new Exception("Failed to delete employee profile data component: [{$taskName}].");
			}
		}

		if (deleteEmployee($employeeId) === false) {
			throw new Exception('Failed to complete final employee record deletion.');
		}

		commit();

		$message = "Employee [{$targetName}] has been deleted successfully.";
		$success = true;
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, 'Deleted employee', $targetName, clientIp());
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Deletion process aborted: " . $e->getMessage();
	}
}

if (isset($_POST['edit-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));

	if (!$employeeId) {
		return;
	}

	$dtsStation = sanitize($_POST['dts-verifier'] ?? null);
	$dtsPortal = section($dtsStation) ? strtolower("{$dtsStation}_portal") : 'sch_portal';
	$systems = [
		'HRMIS' => isset($_POST['hrmis']),
		'DMIS' => isset($_POST['dmis']),
		'HRTDMS' => isset($_POST['hrtdms'])
	];

	$showAlert = true;
	$success = false;
	$hasChanges = false;

	beginTransaction();

	try {
		if (isset($_POST['dts'])) {
			if (!empty($dtsStation)) {
				$dtsUserExists = dtsUser($employeeId);
				$res = $dtsUserExists
					? updateUserRole($employeeId, $dtsStation, $dtsPortal)
					: createUserRole($employeeId, $dtsStation, $dtsPortal);

				if ($res === false) {
					throw new Exception('Failed to save Document Tracking System role registration attributes.');
				}

				if ($res > 0) {
					$hasChanges = true;
				}
			}
		} else {
			if (!empty($dtsStation)) {
				$res = deleteUserRole($employeeId, $dtsStation);

				if ($res === false) {
					throw new Exception('Failed to revoke Document Tracking System user permissions.');
				}

				if ($res > 0) {
					$hasChanges = true;
				}
			}
		}

		foreach ($systems as $systemCode => $isEnabled) {
			$userCurrentlyHasSystem = isStationUser($employeeId, $systemCode);

			if ($isEnabled) {
				if (!$userCurrentlyHasSystem) {
					$res = createUserRole($employeeId, $systemCode);

					if ($res === false) {
						throw new Exception("Failed to grant platform module access context privileges for: {$systemCode}.");
					}

					$hasChanges = true;
				}
			} else {
				if ($userCurrentlyHasSystem) {
					$res = deleteUserRole($employeeId, $systemCode);

					if ($res === false) {
						throw new Exception("Failed to revoke platform module access context privileges for: {$systemCode}.");
					}

					if ($res > 0) {
						$hasChanges = true;
					}
				}
			}
		}

		commit();

		$success = true;
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = 'Failed to update user assignments due to a system error: ' . $e->getMessage();
	}

	if ($success) {
		$rawUserName = userName($employeeId);
		$formattedUserName = userName($employeeId, true);
		$employeeLink = sprintf(
			'<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'%s/modules/users/user-info-dialog.php?id=%s\')" title="View %s employee information">%s</a>',
			$baseUri,
			cipher($employeeId),
			$rawUserName,
			$formattedUserName
		);

		if ($hasChanges) {
			$message = "Employee [{$employeeLink}] user assignments have been updated successfully.";

			createSystemLog($stationId, $userId, "Updated permissions metrics for employee ID: {$employeeId}", $employeeId, clientIp());
		} else {
			$message = "No modifications were made to employee [{$employeeLink}] privileges (the assignments matched their current state).";
		}
	}
}

if (isset($_POST['reset-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$temporaryPassword = sanitize(decipher($_POST['data-verifier'] ?? null));
	$showAlert = true;
	$success = false;
	$emails = employee($employeeId);
	$userEmail = $emails ? $emails['email_address'] : '';
	$rawUserName = userName($employeeId);
	$formattedUserName = userName($employeeId, true);
	$employeeLink = sprintf(
		'<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'%s/modules/users/user-info-dialog.php?id=%s\')" title="View %s employee information">%s</a>',
		$baseUri,
		cipher($employeeId),
		$rawUserName,
		$formattedUserName
	);
	$hashedPassword = hashPassword($temporaryPassword);

	beginTransaction();

	try {
		$affectedRows = updateAccountPassword($employeeId, $hashedPassword, 'Default');

		if ($affectedRows === false) {
			rollBack();

			$message = "An error occurred. No changes have been made to employee [{$employeeLink}] password.";

			return;
		}

		commit();

		$message = "Employee [{$employeeLink}] password has been reset successfully.";
		$success = true;
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;
		$ipAddress = clientIp();

		createSystemLog($currentStation, $currentOperator, 'Reset user password', $employeeId, $ipAddress);
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Failed to reset password due to a database system error.";

		return;
	}

	if (!empty($userEmail)) {
		$loginUrl = "$baseUri/login";
		$emailBody = <<<EOT
			A password reset request for your account ({$userEmail}) has been processed.

			Temporary Password: {$temporaryPassword}

			Please log in here to update your credentials: {$loginUrl}

			Security Note: If you did not request this change, please contact system administration immediately.

			Best regards,
			ICT Support Team
			EOT;

		if (sendMail($userEmail, 'Employee Password Reset', $emailBody)) {
			$message .= " An email has been sent to [{$userEmail}].";

			createSystemLog($currentStation, $currentOperator, 'Password reset code sent', $employeeId, $ipAddress);
		} else {
			$message .= " Unfortunately, we encountered a network error sending the notification email. Please manually coordinate the password change.";

			error_log("Failed to send reset email to: {$userEmail}");
		}
	} else {
		$message .= " Warning: No email address associated with this profile; notification could not be sent.";
	}
}

if (isset($_POST['remove-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$success = false;
	$rawUserName = userName($employeeId);
	$formattedUserName = userName($employeeId, true);
	$employeeLink = sprintf(
		'<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'%s/modules/users/user-info-dialog.php?id=%s\')" title="View %s employee information">%s</a>',
		$baseUri,
		cipher($employeeId),
		$rawUserName,
		$formattedUserName
	);

	beginTransaction();

	try {
		$affectedRows = deleteUserRoles($employeeId);

		if ($affectedRows === false) {
			rollBack();
			$message = "An error occurred. No changes have been made to employee [{$employeeLink}] user privileges.";
			return;
		}

		$message = "Employee [{$employeeLink}] user privileges have been removed successfully.";
		$success = true;
		$currentStation = $stationId ?? null;
		$currentOperator = $userId ?? null;

		createSystemLog($currentStation, $currentOperator, 'Removed user privileges', $employeeId, clientIp());

		commit();
	} catch (Exception $e) {
		rollBack();

		$success = false;
		$message = "Failed to remove user privileges due to a system error.";
	}
}