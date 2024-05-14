<?php
// dts/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'dts';
$page = $appTitle = 'Document Tracking System';

if (!isset($userId)) {
	redirect(uri() . '/login');
}

if (!isset($portal) || empty($portal)) {
	redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
	redirect(customUri('dts', 'Document Information', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$destination = $isSchoolPortal ? 'REC' :  sanitize($_POST['destination']);
	$logMessage = '';
	$showAlert = true;

	if (numRows(document($documentId)) === 0) {
		$status = 'saved';
		$year = date('y');
		$description = sanitize($_POST['description']);
		$documentId = $code . '-' . $year . '-' . sprintf("%05d", countDocumentsFrom($station, $year, $code) + 1);
		$section = section($code);

		if (numRows($section) > 0) {
			$headId = fetchAssoc($section)['head'];
		} else {
			$school = schoolById($code);
			$headId = numRows($school) > 0 ? fetchAssoc($school)['head'] : '';
		}

		if (empty($description)) {
			$message = 'No new document has been created. Please provide a description for the document.';
			$success = false;
			return;
		}

		createDocument($documentId, $description, $station, $purpose, $headId, $details);
		createDocumentLog($documentId, $userId, $station, $destination, $purpose, 'New', $details);

		$logMessage = 'Created document';
	} else {
		$status = 'updated';
		$updateDescription = false;
		$description = '';

		if ($isDescriptionEditable) {
			$updateDescription = true;
			$description = isset($_POST['description']) ? sanitize($_POST['description']) : null;
		}

		updateDocument($documentId, $description, $purpose, $details, $updateDescription);
		updateDocumentLog($documentId, $userId, $station, $destination, $purpose, 'New', $details);

		$logMessage = 'Updated document';
	}

	if (affectedRows()) {
		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been ' . $status . ' successfully.';

		createSystemLog($stationId, $userId, $logMessage, $documentId, clientIp());
	} else {
		$message = $status === 'saved' ? 'No new document has been created.' : 'No document has been updated';
		$success = false;
	}
}

if (isset($_POST['receive-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', 'Received', 'New');

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been received successfully.';

		createSystemLog($stationId, $userId, 'Received document', $documentId, clientIp());
	} else {
		$message = 'No document has been received.';
		$success = false;
	}
}

if (isset($_POST['forward-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$purpose = sanitize($_POST['purpose']);
	$details = sanitize($_POST['details']);
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, sanitize($_POST['destination']), $purpose, 'New', $details);
		updateDocumentStatus($documentId, $purpose, 'Unread', $details);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been forwarded successfully!';

		createSystemLog($stationId, $userId, 'Forwarded document', $documentId, clientIp());
	} else {
		$message = 'No document has been forwarded.';
		$success = false;
	}
}

if (isset($_POST['complete-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = 'Completed';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';

		createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
	} else {
		$message = 'No document has been marked completed.';
		$success = false;
	}
}

if (isset($_POST['cancel-document'])) {
	$documentId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
	$remarks = sanitize($_POST['remarks']);
	$status = 'Canceled';
	$showAlert = true;

	updateDocumentLogsDone($documentId);

	if (affectedRows()) {
		createDocumentLog($documentId, $userId, $station, '-', $status, 'New', $remarks);
		updateDocumentStatus($documentId, $status, 'Unread', $remarks);

		$message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been canceled successfully.';

		createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
	} else {
		$message = 'No document has been canceled.';
		$success = false;
	}
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
	$from = date('Y-m-d', strtotime($_POST['date-from']));
	$to = date('Y-m-d', strtotime($_POST['date-to']));
	redirect(customUri('dts', sanitize(decipher($_GET['v']))) . '&from=' . $from . '&to=' . $to);
}
