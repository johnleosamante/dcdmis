<?php
// dts/app.php
if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

if (!isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/pis');
}

$_SESSION[alias() . '_active_app'] = 'dts';

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('dts', 'Document Information', sanitize($_POST['primary_search_text'])));
}

$show_prompt = false;
$message = null;
$page = $app_title = "Document Tracking System";
$user_id = $_SESSION[alias() . '_user_id'];
$code = $_SESSION[alias() . '_code'];
$station_id = $_SESSION[alias() . '_station_id'];
$station = $_SESSION[alias() . '_station'];
$portal = $_SESSION[alias() . '_portal'];

if (isset($_POST['save_document'])) {
  $document_id = $_SESSION[alias() . '_document_id'];
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);
  $destination = $portal === 'school_portal' ? 'RECORD' :  sanitize($_POST['destination']);
  $status = null;

  if (empty($document_id)) {
    $status = 'saved';
    $year = date('y');
    $description = sanitize($_POST['description']);
    $document_id = $code . '-' . $year . '-' . sprintf("%05d", count_documents_from($code, $year, $code) + 1);
    
    insert_document($document_id, $description, $code, $purpose, $details);
    insert_document_log($document_id, $user_id, $code, $destination, $purpose, 'New', $details);
  } else {
    $status = 'updated';
    $update_description = false;
    $description = '';

    if (isset($_SESSION[alias() . '_editable_description']) && $_SESSION[alias() . '_editable_description']) {
      $update_description = true;
      $description = sanitize($_POST['description']);
    }

    update_document($document_id, $description, $code, $purpose, $details, $update_description);
    update_document_log($document_id, $user_id, $code, $destination, $purpose, 'New', $details);
  }

  if (affected_rows()) {
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $document_id) . '" title="Document Information: ' . $document_id . '" target="_blank">' . strtoupper($document_id) . '</a>] has been ' . $status . ' successfully!';
    $show_prompt = true;
  }
}

if (isset($_POST['receive_document'])) {
  $document_id = $_SESSION[alias() . '_document_id'];

  update_document_logs_done($document_id);
  insert_document_log($document_id, $user_id, $code, '-', 'Received', 'New');

  if (affected_rows()) {
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $document_id) . '" title="Document Information: ' . $document_id . '" target="_blank">' . strtoupper($document_id) . '</a>] has been received successfully!';
    $show_prompt = true;
  }
}

if (isset($_POST['forward_document'])) {
  $document_id = $_SESSION[alias() . '_document_id'];
  $purpose = sanitize($_POST['purpose']);
  $details = sanitize($_POST['details']);

  update_document_logs_done($document_id);
  insert_document_log($document_id, $user_id, $code, sanitize($_POST['destination']), $purpose, 'New', $details);
  update_document_status($document_id, $purpose, 'Unread', $details);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $document_id) . '" title="Document Information: ' . $document_id . '" target="_blank">' . strtoupper($document_id) . '</a>] has been forwarded successfully!';
  }
}

if (isset($_POST['complete_document'])) {
  $document_id = $_SESSION[alias() . '_document_id'];
  $remarks = sanitize($_POST['remarks']);
  $status = 'Completed';

  update_document_logs_done($document_id);
  insert_document_log($document_id, $user_id, $code, '-', $status, 'Done', $remarks);
  update_document_status($document_id, $status, 'Read', $remarks);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $document_id) . '" title="Document Information: ' . $document_id . '" target="_blank">' . strtoupper($document_id) . '</a>] has been mark completed successfully.';
  }
}

if (isset($_POST['cancel_document'])) {
  $document_id = $_SESSION[alias() . '_document_id'];
  $remarks = sanitize($_POST['remarks']);
  $status = 'Canceled';

  update_document_logs_done($document_id);
  insert_document_log($document_id, $user_id, $code, '-', $status, 'Done', $remarks);
  update_document_status($document_id, $status, 'Read', $remarks);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $document_id) . '" title="Document Information: ' . $document_id . '" target="_blank">' . strtoupper($document_id) . '</a>] has been canceled successfully.';
  }
}
?>