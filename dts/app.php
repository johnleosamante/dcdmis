<?php
// dts/app.php
$_SESSION[alias() . '_active_app'] = 'dts';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

if (!isset($_SESSION[alias() . '_portal'])) {
  echo 'DTS Warning: Unauthorized access.';
  exit;
}

$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app_title = "Document Tracking System";

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('dts', 'Document Information', real_escape_string($_POST['primary_search_text'])));
  $_SESSION[alias() . '_search_term'] = real_escape_string($_POST['primary_search_text']);
} else {
  $_SESSION[alias() . '_search_term'] = null;
}

$user_id = $_SESSION[alias() . '_user_id'];
$station = $_SESSION[alias() . '_station'];
$portal = $_SESSION[alias() . '_portal'];

if (isset($_POST['save_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $station_code = $_SESSION[alias() . '_code'];
  $status = null;
  $purpose = real_escape_string($_POST['purpose']);
  $destination = $portal === 'school_portal' ? 'RECORD' :  real_escape_string($_POST['destination']);
  $details = real_escape_string($_POST['details']);

  if ($code === null) {
    $status = 'saved';
    $year = date('y');
    $description = real_escape_string($_POST['description']);
    $schoolid = $_SESSION[alias() . '_portal'] === 'school_portal' ? $station_code : null;

    $code = $station_code . '-' . $year . '-' . sprintf("%05d", count_documents_from($station, $year, $schoolid) + 1);
    
    insert_document($code, $description, $station, $purpose, $details);
    insert_document_log($code, $user_id, $station, $destination, $purpose, 'New', $details);
  } else {
    $status = 'updated';
    $update_description = false;
    $description = '';

    if (isset($_SESSION[alias() . '_editable_description']) && $_SESSION[alias() . '_editable_description']) {
      $update_description = true;
      $description = real_escape_string($_POST['description']);
    }

    update_document($code, $description, $station, $purpose, $details, $update_description);
    update_document_log($code, $user_id, $station, $destination, $purpose, 'New', $details);
  }

  if (affected_rows()) {
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been ' . $status . ' successfully!';
    $show_prompt = true;
  }
}

if (isset($_POST['receive_document'])) {
  $code = $_SESSION[alias() . '_No'];

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, '-', 'Received', 'New');

  if (affected_rows()) {
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been received successfully!';
    $show_prompt = true;
  }
}

if (isset($_POST['forward_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $purpose = real_escape_string($_POST['purpose']);
  $details = real_escape_string($_POST['details']);

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, real_escape_string($_POST['destination']), $purpose, 'New', $details);
  update_document_status($code, $purpose, 'Unread', $details);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been forwarded successfully!';
  }
}

if (isset($_POST['complete_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $remarks = real_escape_string($_POST['remarks']);
  $status = 'Completed';

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, '-', $status, 'Done', $remarks);
  update_document_status($code, $status, 'Read', $remarks);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been mark completed successfully.';
  }
}

if (isset($_POST['cancel_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $remarks = real_escape_string($_POST['remarks']);
  $status = 'Canceled';

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, '-', $status, 'Done', $remarks);
  update_document_status($code, $status, 'Read', $remarks);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been canceled successfully.';
  }
}
?>