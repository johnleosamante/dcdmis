<?php
// dts/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'dts';
$page = $appTitle = "Document Tracking System";

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
  $destination = $isSchoolPortal ? 'RECORD' :  sanitize($_POST['destination']);

  if (numRows(document($documentId)) === 0) {
    $status = 'saved';
    $year = date('y');
    $description = sanitize($_POST['description']);
    $documentId = $code . '-' . $year . '-' . sprintf("%05d", countDocumentsFrom($station, $year, $code) + 1);

    insertDocument($documentId, $description, $station, $purpose, $details);
    insertDocumentLog($documentId, $userId, $station, $destination, $purpose, 'New', $details);
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
  }

  if (affectedRows()) {
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been ' . $status . ' successfully.';
    $showAlert = true;
  }
}

if (isset($_POST['receive-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    insertDocumentLog($documentId, $userId, $station, '-', 'Received', 'New');
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been received successfully.';
    $showAlert = true;
  }
}

if (isset($_POST['forward-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    insertDocumentLog($documentId, $userId, $station, sanitize($_POST['destination']), $purpose, 'New', $details);
    updateDocumentStatus($documentId, $purpose, 'Unread', $details);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been forwarded successfully!';
    $showAlert = true;
  }
}

if (isset($_POST['complete-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Completed';

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    insertDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been mark completed successfully.';
    $showAlert = true;
  }
}

if (isset($_POST['cancel-document'])) {
  $documentId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
  $remarks = sanitize($_POST['remarks']);
  $status = 'Canceled';

  updateDocumentLogsDone($documentId);

  if (affectedRows()) {
    insertDocumentLog($documentId, $userId, $station, '-', $status, 'Done', $remarks);
    updateDocumentStatus($documentId, $status, 'Read', $remarks);
    $message = 'Document code [<a href="' . customUri('dts', 'Document Information', $documentId) . '" title="View ' . $documentId . ' document information" target="_blank">' . strtoupper($documentId) . '</a>] has been canceled successfully.';
    $showAlert = true;
  }
}
?>