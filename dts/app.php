<?php
// dts/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'dts';
$page = $appTitle = 'Document Tracking System';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (!isset($portal)) {
  redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('dts', 'Document Information', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);
  $destination = $isSchoolPortal ? 'REC' :  sanitize($_POST['destination']);
  $logMessage = '';

  if (numRows(document($documentId)) === 0) {
    $status = 'saved';
    $year = date('y');
    $description = sanitize($_POST['description']);
    $documentId = $code . '-' . $year . '-' . sprintf("%05d", countDocumentsFrom($station, $year, $code) + 1);

    createDocument($documentId, $description, $station, $purpose, $details);
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
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been ' . $status . ' successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $documentId, clientIp());
  }
}

if (isset($_POST['receive-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, '-', 'Received', 'New');
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been received successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Received document', $documentId, clientIp());
  }
}

if (isset($_POST['forward-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, sanitize($_POST['destination']), $purpose, 'New', $details);
    updateDocumentStatus($documentId, $purpose, 'Unread', $details);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been forwarded successfully!';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Forwarded document', $documentId, clientIp());
  }
}

if (isset($_POST['complete-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Completed';

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
  }
}

if (isset($_POST['cancel-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Canceled';

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been canceled successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
  }
}
?>