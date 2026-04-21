<?php
// dts/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'dts';
$page = $appTitle = 'Document Tracking System';

if (!isset($userId)) {
	redirect("$baseUri/login");
}

if (!isset($portal) || empty($portal)) {
	redirect("$baseUri/pis");
}

if (isset($_POST['primary-search-button'])) {
	$search = sanitize($_POST['primary-search-text']);

	$document = documentSearch($search, $station);

	if ($document) {
		redirect(customUri('dts', 'Document Search', $search));
	}
}

$allowedTypes = [
	'image/jpeg',
	'image/jpeg',
	'image/png',
	'image/gif',
	'application/pdf',
	'application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'application/vnd.ms-powerpoint',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	'application/vnd.ms-excel',
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (isset($_POST['save-document'])) {
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$type = sanitize($_POST['document-type']);
	$destination = $isSchoolPortal ? 'REC' : sanitize($_POST['destination']);
	$description = sanitize($_POST['description']);
	$section = section($code);

	$showAlert = true;
	$year = date('y');
	$documentId = !empty($documentId) ? $documentId : "{$code}-{$year}-" . sprintf("%05d", countDocumentsFrom($station, $year, $code) + 1);
	$message = 'No new document has been created.';

	if ($section) {
		$headId = $section['head_id'];
	} else {
		$school = schoolById($code);
		$headId = $school ? $school['head_id'] : '';
	}

	if (empty($description)) {
		$message .= ' Please provide a description for the document.';
		return;
	}

	beginTransaction();

	try {
		createDocument($documentId, $description, $type, $station, $purpose);

		$documentLogId = createDocumentLog($documentId, $userId, $station, $destination, $purpose, true, $details);
		$upload_response = '';

		if (!empty($_FILES['file-upload']['name'][0])) {
			$uploadDirectory = root() . '/uploads/attachments/' . cipher($documentId);

			if (!is_dir($uploadDirectory)) {
				mkdir($uploadDirectory, 0777, true);
			}

			foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmp_name) {
				$fileName = basename($_FILES['file-upload']['name'][$key]);
				$fileType = $_FILES['file-upload']['type'][$key];
				$fileSize = $_FILES['file-upload']['size'][$key];
				$targetFilePath = "$uploadDirectory/" . time() . "_$fileName";
				$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

				if (!in_array($fileType, $allowedTypes)) {
					$upload_response .= "<br>File type not allowed: $fileName";
					continue;
				}

				if ($fileSize > FILE_UPLOAD_SIZE_LIMIT) {
					$upload_response .= "<br>File too large (Max 20MB): $fileName";
					continue;
				}

				if (move_uploaded_file($tmp_name, $targetFilePath)) {
					$attachment = $targetFilePath;
					$upload_response .= "<br>File uploaded: $fileName";
					createDocumentLogAttachment($documentLogId, $attachment, ".$extension");
				} else {
					$upload_response .= "<br>Error uploading: $fileName";
				}
			}
		}

		createSystemLog($stationId, $userId, 'Created document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been saved successfully.' . $upload_response;
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['edit-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$type = sanitize($_POST['document-type']);
	$destination = $isSchoolPortal ? 'REC' : sanitize($_POST['destination']);
	$showAlert = true;

	if (document($documentId) === false) {
		$message = 'No document has been updated.';
		return;
	}

	$updateDescription = false;
	$description = null;

	if ($isDescriptionEditable) {
		$updateDescription = true;
		$description = sanitize($_POST['description'] ?? null);

		if (empty($description)) {
			$message = 'Please provide a description for the document.';
			return;
		}
	}

	beginTransaction();

	try {
		updateDocument($documentId, $description, $type, $updateDescription);
		$documentLog = updateDocumentLog($documentId, $userId, $station, $destination, $purpose, true, $details);

		$upload_response = '';

		if (!empty($_FILES['file-upload']['name'][0])) {
			$uploadDirectory = root() . '/uploads/attachments/' . cipher($documentId);

			if (!is_dir($uploadDirectory)) {
				mkdir($uploadDirectory, 0777, true);
			}

			$latestLog = documentLogs($documentId)[0] ?? null;
			$documentLogId = $latestLog ? $latestLog['id'] : null;

			foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmp_name) {
				$fileName = basename($_FILES['file-upload']['name'][$key]);
				$fileType = $_FILES['file-upload']['type'][$key];
				$fileSize = $_FILES['file-upload']['size'][$key];
				$targetFilePath = "$uploadDirectory/" . time() . "_$fileName";
				$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

				if (!in_array($fileType, $allowedTypes)) {
					$upload_response .= "<br>File type not allowed: $fileName";
					continue;
				}

				if ($fileSize > FILE_UPLOAD_SIZE_LIMIT) {
					$upload_response .= "<br>File too large (Max 20MB): $fileName";
					continue;
				}

				if (move_uploaded_file($tmp_name, $targetFilePath)) {
					$attachment = $targetFilePath;
					$upload_response .= "<br>File uploaded: $fileName";

					if ($documentLogId) {
						createDocumentLogAttachment($documentLogId, $attachment, ".$extension");
					}
				} else {
					$upload_response .= "<br>Error uploading: $fileName";
				}
			}
		}

		createSystemLog($stationId, $userId, 'Updated document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been updated successfully.' . $upload_response;
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['delete-attachment'])) {
	$attachmentId = sanitize(decipher($_POST['verifier'] ?? null));

	$showAlert = true;

	beginTransaction();

	try {
		$affectedAttachment = deleteDocumentLogAttachment($attachmentId);

		if ($affectedAttachment === false) {
			$message = 'No changes have been made to document attachments.';
			return;
		}

		createSystemLog($stationId, $userId, 'Deleted document attachment', '', clientIp());
		commit();

		$message = 'Document attachment has been deleted successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['receive-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocument = updateDocumentLogsDone($documentId);

		if ($updatedDocument === false) {
			$message = 'No document has been received.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, null, documentStatusId('Received'), true);
		createSystemLog($stationId, $userId, 'Received document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been received successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['forward-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$destination = sanitize($_POST['destination']);
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocuments = updateDocumentLogsDone($documentId);

		if ($updatedDocuments === false) {
			$message = 'No document has been forwarded.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, $destination, $purpose, true, $details);

		$upload_response = '';

		if (!empty($_FILES['file-upload']['name'][0])) {
			$uploadDirectory = root() . '/uploads/attachments/' . cipher($documentId);

			if (!is_dir($uploadDirectory)) {
				mkdir($uploadDirectory, 0777, true);
			}

			$latestLog = documentLogs($documentId)[0] ?? null;
			$documentLogId = $latestLog ? $latestLog['id'] : null;

			foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmp_name) {
				$fileName = basename($_FILES['file-upload']['name'][$key]);
				$fileType = $_FILES['file-upload']['type'][$key];
				$fileSize = $_FILES['file-upload']['size'][$key];
				$targetFilePath = "$uploadDirectory/" . time() . "_$fileName";
				$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

				if (!in_array($fileType, $allowedTypes)) {
					$upload_response .= "<br>File type not allowed: $fileName";
					continue;
				}

				if ($fileSize > FILE_UPLOAD_SIZE_LIMIT) {
					$upload_response .= "<br>File too large (Max 20MB): $fileName";
					continue;
				}

				if (move_uploaded_file($tmp_name, $targetFilePath)) {
					$attachment = $targetFilePath;
					$upload_response .= "<br>File uploaded: $fileName";

					if ($documentLogId) {
						createDocumentLogAttachment($documentLogId, $attachment, ".$extension");
					}
				} else {
					$upload_response .= "<br>Error uploading: $fileName";
				}
			}
		}

		createSystemLog($stationId, $userId, 'Forwarded document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been forwarded successfully.' . $upload_response;
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['complete-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$remarks = sanitize($_POST['remarks']);
	$status = documentStatusId('Completed');
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocument = updateDocumentLogsDone($documentId);

		if ($updatedDocument === false) {
			$message = 'No document has been marked completed.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, null, $status, true, $remarks);
		createSystemLog($stationId, $userId, "$status document", $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['incomplete-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$remarks = sanitize($_POST['remarks']);
	$status = documentStatusId('Received');
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocument = updateDocumentLogsDone($documentId);

		if ($updatedDocument === false) {
			$message = 'No document has been marked incomplete.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, null, $status, true, $remarks);
		createSystemLog($stationId, $userId, 'Marked incomplete document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been marked incomplete successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['restore-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$remarks = sanitize($_POST['remarks']);
	$status = documentStatusId($isSchoolPortal ? 'For submission' : 'Restored');
	$destination = $isSchoolPortal ? 'REC' : null;
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocument = updateDocumentLogsDone($documentId);

		if ($updatedDocument === false) {
			$message = 'No document has been restored.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, $destination, $status, true, $remarks);
		createSystemLog($stationId, $userId, 'Restored document', $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been restored successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

if (isset($_POST['cancel-document'])) {
	$documentId = sanitize(decipher($_POST['verifier'] ?? null));
	$remarks = sanitize($_POST['remarks']);
	$status = documentStatusId('Canceled');
	$showAlert = true;

	beginTransaction();

	try {
		$updatedDocument = updateDocumentLogsDone($documentId);

		if ($updatedDocument === false) {
			$message = 'No document has been canceled.';
			return;
		}

		createDocumentLog($documentId, $userId, $station, null, $status, true, $remarks);
		createSystemLog($stationId, $userId, "$status document", $documentId, clientIp());
		commit();

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been canceled successfully.';
		$success = true;
	} catch (Exception $e) {
		rollBack();
		$message = $e->getMessage();
	}
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
	$from = date('Y-m-d', strtotime($_POST['date-from']));
	$to = date('Y-m-d', strtotime($_POST['date-to']));
	redirect(customUri('dts', sanitize(decipher($_GET['v']))) . '&from=' . $from . '&to=' . $to);
}