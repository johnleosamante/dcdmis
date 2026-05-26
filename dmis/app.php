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
	$link = '[<a href="' . customUri('dmis', 'School Information', $schoolId) . '" title="View ' . $schoolName . ' information">' . strtoupper($schoolName) . '</a>]';

	if (is_uploaded_file($_FILES['logo-upload']['tmp_name'])) {
		$temp = $_FILES['logo-upload']['tmp_name'];

		if ($_FILES['logo-upload']['size'] > $imageUploadSizeLimit) {
			$message = 'The chosen file exceeds the upload file limit (2.5 MB). No changes have been made to school information.';
			return;
		}

		$allowedFileTypes = ['image/png', 'image/jpeg', 'image/gif'];

		if (!validateFileMimeType($temp, $allowedFileTypes)) {
			$message = 'The chosen file is not an image file. No changes have been made to school information.';
			return;
		}

		if (!validateFileExtension($_FILES['logo-upload']['name'], ['png', 'jpg', 'jpeg', 'gif'])) {
			$message = 'The chosen file has an invalid extension. No changes have been made to school information.';
			return;
		}

		$sanitizedName = sanitizeFilename($_FILES['logo-upload']['name']);
		$ext = getFileExtension($sanitizedName);

		if (!empty($logo) && file_exists(root() . "/{$logo}")) {
			unlink(root() . "/{$logo}");
		}

		$uploadDirectory = root() . "/uploads/school_logo/{$schoolId}";

		if (!is_dir($uploadDirectory)) {
			mkdir($uploadDirectory, 0755, true);
		}

		$uploadDate = date('YmdHis');

		$logo = "uploads/school_logo/{$schoolId}/{$schoolId}{$uploadDate}.{$ext}";

		move_uploaded_file($temp, "../{$logo}");
	}

	beginTransaction();

	try {
		if (!schoolById($referenceSchoolId)) {
			if (createSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $telephone, $email, $website, $facebook, $logo) === false) {
				throw new Exception('Failed to create school');
			}
			$status = 'saved';
			$logMessage = 'Added school';
		} else {
			if (updateUsersStation($schoolId, $referenceSchoolId) === false) {
				throw new Exception('Failed to update user station');
			}

			if (updateStationID($schoolId, $referenceSchoolId) === false) {
				throw new Exception('Failed to update station ID');
			}

			if (updateTransactionLogFrom($alias, $referenceAlias) === false) {
				throw new Exception("Failed to update transaction logs from {$link}.");
			}

			if (updateTransactionLogTo($alias, $referenceAlias) === false) {
				throw new Exception("Failed to update transaction logs to {$link}.");
			}

			if (updateTransactionFrom($alias, $referenceAlias) === false) {
				throw new Exception("Failed to update transactions from {$link}.");
			}

			if (updateSchool($schoolId, $schoolName, $alias, $address, $districtCode, $category, $telephone, $email, $website, $facebook, $logo, $referenceSchoolId) === false) {
				throw new Exception('Failed to update school');
			}

			$status = 'updated';
			$logMessage = 'Updated school';
		}

		commit();
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
		return;
	}

	if ($success) {
		$message = "School {$link} has been {$status} successfully.";
		createSystemLog($stationId, $userId, $logMessage, $schoolId, clientIp());
	}
}

if (isset($_POST['delete-school'])) {
	$schoolId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$schools = schoolById($schoolId);
	$target = count($schools) === 1 ? $schools['name'] : $schoolId;
	$affectedSchool = deleteSchool($schoolId);

	if (!$affectedSchool) {
		$message = 'No changes have been made to school.';
		return;
	}

	$message = 'School has been deleted successfully.';
	$success = true;

	createSystemLog($stationId, $userId, 'Deleted school', $target, clientIp());
}

if (isset($_POST['save-section'])) {
	$referenceSectionId = sanitize(decipher($_POST['verifier'] ?? null));
	$alias = sanitize($_POST['alias']);
	$section = sanitize($_POST['section']);
	$division = sanitize($_POST['division']);
	$head = sanitize($_POST['head']);
	$showAlert = true;
	$link = '[<a href="' . customUri('dmis', 'Section Information', $alias) . '" title="View ' . $section . ' information">' . strtoupper($section) . '</a>]';

	beginTransaction();

	try {
		if (!section($referenceSectionId)) {
			if (createSection($alias, $head, $section, $division) === false) {
				throw new Exception('Failed to create section.');
			}

			$status = 'saved';
			$logMessage = 'Added section';
		} else {
			if (updateUsersStation($alias, $referenceSectionId, strtolower("{$alias}_portal")) === false) {
				throw new Exception('Failed to update user station');
			}

			if (updateTransactionLogFrom($alias, $referenceSectionId) === false) {
				throw new Exception("Failed to update transaction logs from {$link}.");
			}

			if (updateTransactionLogTo($alias, $referenceSectionId) === false) {
				throw new Exception("Failed to update transaction logs to {$link}.");
			}

			if (updateTransactionFrom($alias, $referenceSectionId) === false) {
				throw new Exception("Failed to update transactions from {$link}.");
			}

			if (updateSection($alias, $head, $section, $division, $referenceSectionId) === false) {
				throw new Exception('Failed to update section.');
			}

			$status = 'updated';
			$logMessage = 'Updated section';
		}

		commit();
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
		return;
	}

	$message = "Section {$link} has been {$status} successfully.";
	$success = true;

	createSystemLog($stationId, $userId, $logMessage, $alias, clientIp());
}

if (isset($_POST['save-district'])) {
	$referenceDistrictId = sanitize(decipher($_POST['verifier'] ?? null));
	$districtCode = sanitize($_POST['code']);
	$districtName = sanitize($_POST['district']);
	$districtHead = sanitize($_POST['head']);
	$showAlert = true;
	$link = '[<a href="' . customUri('dmis', 'District Information', $districtCode) . '" title="View ' . $districtName . ' information">' . strtoupper($districtName) . '</a>]';

	if (!district($referenceDistrictId)) {
		$affectedDistrict = createDistrict($districtCode, $districtName, $districtHead);
		$status = 'saved';
		$logMessage = 'Added district';
	} else {
		$affectedDistrict = updateDistrict($districtCode, $districtName, $districtHead, $referenceDistrictId);
		$status = 'updated';
		$logMessage = 'Updated district';
	}

	if (!$affectedDistrict) {
		$message = "No changes have been made to district {$link}.";
		return;
	}

	$message = "District {$link} has been {$status} successfully.";
	$success = true;

	createSystemLog($stationId, $userId, $logMessage, $districtCode, clientIp());
}

if (isset($_POST['delete-employee'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$employee = employee($employeeId);
	$target = count($employee) === 1 ? userName($employeeId) : $employeeId;

	if (!$employeeId || !isDuplicateEmployee($employeeId)) {
		$message = "Employee record not found of already deleted.";
		return;
	}

	beginTransaction();

	try {
		if (deleteFileAttachments($employeeId) === false) {
			throw new Exception('Failed to delete employee 201 file attachments.');
		}

		if (deleteAccount($employeeId) === false) {
			throw new Exception('Failed to delete employee user credentials.');
		}

		if (deleteUserRoles($employeeId) === false) {
			throw new Exception('Failed to delete employee user permissions.');
		}

		if (deleteEducations($employeeId) === false) {
			throw new Exception('Failed to delete employee educational backgrounds.');
		}

		if (deleteEligibilities($employeeId) === false) {
			throw new Exception('Failed to delete employee eligibilities.');
		}

		if (deleteExperiences($employeeId) === false) {
			throw new Exception('Failed to delete employee service records.');
		}

		if (deleteChildren($employeeId) === false) {
			throw new Exception('Failed to delete employee children.');
		}

		if (deleteFamily($employeeId) === false) {
			throw new Exception('Failed to delete employee family background.');
		}

		if (deleteParticipantTrainings($employeeId) === false) {
			throw new Exception('Failed to delete employee attended trainings.');
		}

		if (deleteMemberships($employeeId) === false) {
			throw new Exception('Failed to delete employee memberships.');
		}

		if (deleteOtherInformation($employeeId) === false) {
			throw new Exception('Failed to delete employee other information.');
		}

		if (deleteRecognitions($employeeId) === false) {
			throw new Exception('Failed to delete employee recognitions.');
		}

		if (deleteReferences($employeeId) === false) {
			throw new Exception('Failed to delete employee references.');
		}

		if (deleteSpecialSkills($employeeId) === false) {
			throw new Exception('Failed to delete employee special skills.');
		}

		if (deleteVoluntaryWorks($employeeId) === false) {
			throw new Exception('Failed to delete employee voluntary works.');
		}

		if (deleteStation($employeeId) === false) {
			throw new Exception('Failed to delete employee station.');
		}

		if (deleteEmployee($employeeId) === false) {
			throw new Exception('Failed to delete employee.');
		}
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
		return;
	}

	$message = 'Employee has been deleted successfully.';
	$success = true;

	createSystemLog($stationId, $userId, 'Deleted employee', $target, clientIp());
}

if (isset($_POST['delete-district'])) {
	$districtCode = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;

	$districts = district($districtCode);

	$target = count($districts) === 1 ? $districts['name'] : $districtCode;

	$affetctedDistrict = deleteDistrict($districtCode);

	if (!$affectedDistrict) {
		$message = 'No changes have been made to district.';
		return;
	}

	$message = 'District has been deleted successfully.';
	$success = true;

	createSystemLog($stationId, $userId, 'Deleted district', $target, clientIp());
}

if (isset($_POST['edit-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));

	if (!$employeeId)
		return;

	$dtsStation = sanitize($_POST['dts-verifier'] ?? null);
	$dtsPortal = section($dtsStation) ? strtolower("{$dtsStation}_portal") : 'sch_portal';

	$systems = [
		'HRMIS' => isset($_POST['hrmis']),
		'DMIS' => isset($_POST['dmis']),
		'HRTDMS' => isset($_POST['hrtdms'])
	];

	$showAlert = true;

	beginTransaction();

	try {
		if (isset($_POST['dts'])) {
			dtsUser($employeeId)
				? updateUserRole($employeeId, $dtsStation, $dtsPortal)
				: createUserRole($employeeId, $dtsStation, $dtsPortal);
		} else {
			deleteUserRole($employeeId, $dtsStation);
		}

		foreach ($systems as $systemCode => $isEnabled) {
			if ($isEnabled) {
				if (!isStationUser($employeeId, $systemCode)) {
					createUserRole($employeeId, $systemCode);
				}
			} else {
				deleteUserRole($employeeId, $systemCode);
			}
		}

		commit();
	} catch (Exception $e) {
		rollBack();
		$message = 'Failed to update user assignments: ' . $e->getMessage();
		return;
	}

	$employeeLink = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . "{$baseUri}/modules/users/user-info-dialog.php?id=" . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';
	$message = "Employee [{$employeeLink}] user assignment has been set successfully.";
	$success = true;

	createSystemLog($stationId, $userId, 'Assigned user privileges', $employeeId, clientIp());
}

if (isset($_POST['reset-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$temporaryPassword = sanitize(decipher($_POST['data-verifier'] ?? null));
	$emails = employee($employeeId);
	$userEmail = $emails ? $emails['email_address'] : '';
	$showAlert = true;
	$employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . "{$baseUri}/modules/users/user-info-dialog.php?id=" . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';

	$affectedAccountPassword = updateAccountPassword($employeeId, hashPassword($temporaryPassword), 'Default');

	if (!$affectedAccountPassword) {
		$message = "No changes have been made to employee [{$employee}]  password.";
		return;
	}

	$message = "Employee [{$employee}] password has been reset successfully.";

	createSystemLog($stationId, $userId, 'Reset user password', $employeeId, clientIp());

	$loginUrl = "$baseUri/login";

	$emailBody = "Good day!\n\n
                Your request for password reset has been approved!\n\n
                Your temporary password is: {$temporaryPassword}\n\n
                Please login to: {$loginUrl} to confirm.\n\n
                If you did not request this change please contact us for assistance. Thank you.";

	if (!sendMail($userEmail, 'Employee Password Reset', $emailBody)) {
		$message .= " Unfortunately, we encountered an error sending the email. Please try again later.";
		error_log("Failed to send reset email to: {$userEmail}");
		return;
	}

	$message .= " An email has been sent to [{$userEmail}].";
	$success = true;

	createSystemLog($stationId, $userId, 'Password reset code sent', $employeeId, clientIp());
}

if (isset($_POST['remove-user'])) {
	$employeeId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;
	$employee = '<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . "{$baseUri}/modules/users/user-info-dialog.php?id=" . cipher($employeeId) . '\')" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>';

	$affectedUserRoles = deleteUserRoles($employeeId);

	if (!$affectedUserRoles) {
		$message = "No changes have been made to employee [{$employee}] user privileges.";
		return;
	}

	$message = "Employee [{$employee}] user privileges have been removed successfully.";
	$success = true;

	createSystemLog($stationId, $userId, 'Removed user privileges', $employeeId, clientIp());
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
	$from = date('Y-m-d', strtotime($_POST['date-from']));
	$to = date('Y-m-d', strtotime($_POST['date-to']));
	redirect(customUri('dmis', sanitize(decipher($_GET['v']))) . '&from=' . $from . '&to=' . $to);
}

if (isset($_POST['bulk-process-documents'])) {
	$stationId = sanitize(decipher($_POST['verifier'] ?? null));
	$stationName = strtoupper(stationName($stationId));
	$previousYear = date('Y', strtotime('-1 year'));
	$from = sanitize($_POST['from-date'] ?? "$previousYear-01-01");
	$to = sanitize($_POST['to-date'] ?? "$previousYear-12-31");
	$userId = sanitize($_POST['user']);
	$failedCount = 0;
	$receivedCount = 0;
	$successCount = 0;
	$canceledCount = 0;
	$showAlert = true;
	$user = employee($userId);

	if ($user === false) {
		$message = "There is currently no assigned user in this station. Please assign a user to continue.";
		return;
	}

	$userId = $user['id'];
	$documents = incomingDocuments($stationId, $from, $to, 5000);

	if (empty($documents)) {
		$message = "No incoming documents found for [$stationName] from [$from] to [$to]. ";
	} else {
		foreach ($documents as $document) {
			$documentId = $document['id'];

			beginTransaction();

			try {
				$updatedDocument = updateDocumentLogsDone($documentId);

				if ($updatedDocument === false) {
					$failedCount++;
					rollBack();
					continue;
				}

				createDocumentLog($documentId, $userId, $stationId, null, documentStatusId('Received'), true);
				createSystemLog($stationId, null, 'Received Document (Bulk)', $documentId, clientIp());

				$receivedCount++;

				$updatedDocument = updateDocumentLogsDone($documentId);

				if ($updatedDocument === false) {
					$failedCount++;
					rollBack();
					continue;
				}

				createDocumentLog($documentId, $userId, $stationId, null, documentStatusId('Completed'), true);
				createSystemLog($stationId, $userId, 'Completed Document (Bulk)', $documentId, clientIp());

				$successCount++;

				commit();
			} catch (Exception $e) {
				rollBack();
				$failedCount++;
			}
		}
	}

	$documents = pendingDocuments($stationId, $from, $to, 5000);

	if (empty($documents)) {
		$message .= "No pending documents found for [$stationName] from [$from] to [$to]. ";
	} else {
		foreach ($documents as $document) {
			$documentId = $document['id'];

			beginTransaction();

			try {
				$updatedDocument = updateDocumentLogsDone($documentId);

				if ($updatedDocument === false) {
					$failedCount++;
					rollBack();
					continue;
				}

				createDocumentLog($documentId, $userId, $stationId, null, documentStatusId('Completed'), true);
				createSystemLog($stationId, $userId, 'Completed Document (Bulk)', $documentId, clientIp());
				commit();

				$successCount++;
			} catch (Exception $e) {
				rollBack();
				$failedCount++;
			}
		}
	}

	$documents = outgoingDocuments($stationId, $from, $to, 5000);

	if (empty($documents)) {
		$message .= "No outgoing documents for [$stationName] from [$from] to [$to]. ";
	} else {
		foreach ($documents as $document) {
			$documentId = $document['id'];

			beginTransaction();

			try {
				$updatedDocument = updateDocumentLogsDone($documentId);

				if ($updatedDocument === false) {
					$failedCount++;
					rollBack();
					continue;
				}

				createDocumentLog($documentId, $userId, $stationId, null, documentStatusId('Canceled'), true, 'Bulk processed: Cancelled as not received by destination.');
				createSystemLog($stationId, $userId, 'Canceled Document (Bulk)', $documentId, clientIp());
				commit();

				$canceledCount++;
			} catch (Exception $e) {
				rollBack();
				$failedCount++;
			}
		}
	}

	$success = $receivedCount > 0 || $successCount > 0 || $canceledCount > 0;
	$message = $success ? "Bulk processing for [$stationName] successfully completed. " : $message;

	if ($receivedCount > 0) {
		$message .= '<br>' . number_format($receivedCount) . " document" . ($receivedCount > 1 ? 's' : '') . " received.";
	}

	if ($successCount > 0) {
		$message .= '<br>' . number_format($successCount) . " document" . ($successCount > 1 ? 's' : '') . " completed.";
	}

	if ($canceledCount > 0) {
		$message .= '<br>' . number_format($canceledCount) . " document" . ($canceledCount > 1 ? 's' : '') . " canceled.";
	}

	if ($failedCount > 0) {
		$message .= "<br>Failed to process " . number_format($failedCount) . " document" . ($failedCount > 1 ? 's' : '') . ".";
	}
}