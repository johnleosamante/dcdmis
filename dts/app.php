<?php
// dts/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'dts';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (!isset($portal) || empty($portal)) {
  redirect(uri() . '/pis');
}

$page = $appTitle = 'Document Tracking System';

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
    $section = section($code);

    if (numRows($section) > 0) {
      $headId = fetchAssoc($section)['head'];
    } else {
      $school = schoolById($code);
      $headId = numRows($school) > 0 ? fetchAssoc($school)['head'] : '';
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

  $showAlert = true;

  if (affectedRows()) {
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been ' . $status . ' successfully.';

    createSystemLog($stationId, $userId, $logMessage, $documentId, clientIp());
  } else {
    $message = $status === 'saved' ? 'No new document has been created.' : 'No document has been updated';
    $success = false;
  }
}

if (isset($_POST['receive-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;

  updateDocumentLogsDone($documentId);

  $showAlert = true;

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
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);

  updateDocumentLogsDone($documentId);

  $showAlert = true;

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
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Completed';

  updateDocumentLogsDone($documentId);

  $showAlert = true;

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);

    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';

    createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
  } else {
    $message = 'No document has been marked completed.';
    $success = false;
  }
}

if (isset($_POST['cancel-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Canceled';

  updateDocumentLogsDone($documentId);

  $showAlert = true;

  if (affectedRows()) {
    createDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);
    
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information">' . strtoupper($documentId) . '</a>] has been canceled successfully.';

    createSystemLog($stationId, $userId, $status . ' document', $documentId, clientIp());
  } else {
    $message = 'No document has been canceled.';
    $success = false;
  }
}
?>