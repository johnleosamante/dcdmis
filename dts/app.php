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

function station_name($id) {
  $section = section($id, true);

  if (num_rows($section) > 0) {
    return fetch_assoc($section)['name'];
  } else {
    $school = school_by_alias($id);
    return num_rows($school) > 0 ? fetch_assoc($school)['name'] : $id;
  }
}

function user_name($id) {
  $user = fetch_assoc(employee($id));

  return to_name($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
}

$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app_title = "Document Tracking System";

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('dts', 'Document Information', real_escape_string($_POST['primary_search_text'])));
}

if (isset($_POST['receive_document'])) {
  $code = $_SESSION[alias() . '_No'];

  update_document_log($code);
  insert_document_log($code, $_SESSION[alias() . '_user_id'], $_SESSION[alias() . '_station'], '-', 'Received', 'New', $_SESSION[alias() . '_station_is_school']);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [' . strtoupper($code) . '] has been received successfully!';
  }
}

if (isset($_POST['forward_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $purpose = real_escape_string($_POST['purpose']);

  update_document_log($code);
  insert_document_log($code, $_SESSION[alias() . '_user_id'], $_SESSION[alias() . '_station'], real_escape_string($_POST['destination']), $purpose, 'New', $_SESSION[alias() . '_station_is_school']);
  update_document_status($code, $purpose);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [' . strtoupper($code) . '] has been forwarded successfully!';
  }
}

if (isset($_POST['complete_document'])) {
  $code = $_SESSION[alias() . '_No'];
  $remarks = real_escape_string($_POST['remarks']);

  $status = strlen($remarks) > 0 ? "Completed - {$remarks}" : 'Completed';

  update_document_log($code);
  insert_document_log($code, $_SESSION[alias() . '_user_id'], $_SESSION[alias() . '_station'], '-', 'Completed', 'Done', $_SESSION[alias() . '_station_is_school']);
  update_document_status($code, $status, 'Read');

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [' . strtoupper($code) . '] has been mark completed successfully.';
  }
}

if (isset($_POST['cancel_document'])) {
  $code = $_SESSION[alias() . '_No'];
}
?>