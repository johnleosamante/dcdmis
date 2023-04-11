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

$code = $_SESSION[alias() . '_No'];
$user_id = $_SESSION[alias() . '_user_id'];
$station = $_SESSION[alias() . '_station'];
$portal = $_SESSION[alias() . '_portal'];
$station_code = $_SESSION[alias() . '_code'];

if (isset($_POST['save_document'])) {
  $status = null;
  $description = real_escape_string($_POST['description']);
  $purpose = real_escape_string($_POST['purpose']);
  $destination = $portal === 'school_portal' ? 'RECORD' :  real_escape_string($_POST['destination']);

  if ($code === null) {
    $status = 'saved';
    $year = date('y');
    $code = $station_code . '-' . $year . '-' . sprintf("%05d", count_documents_from($station, $year) + 1);
    
    insert_document($code, $description, $station, $purpose);
    insert_document_log($code, $user_id, $station, $destination, $purpose);
  } else {
    $status = 'updated';

    update_document($code, $description, $station, $purpose);
    update_document_log($code, $user_id, $station, $destination, $purpose);
  }

  if (affected_rows()) {
    $message = 'Document code [<a href="' . custom_uri('dts', 'Document Information', $code) . '" title="Document Information: ' . $code . '" target="_blank">' . strtoupper($code) . '</a>] has been ' . $status . ' successfully! You can now print the <a href="' . custom_uri('dts', 'Print Document Tracking Slip', $code) . '" title="Print Document Tracking Slip" target="_blank">document tracking slip</a>, or view your <a href="' . custom_uri('dts', 'Ongoing Documents') . '" target="_blank">ongoing documents</a>.';
    $show_prompt = true;
  }
}

if (isset($_POST['receive_document'])) {
  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, '-', 'Received', 'New');

  if (affected_rows()) {
    $message = 'Document code [' . strtoupper($code) . '] has been received successfully!';
    $show_prompt = true;
  }
}

if (isset($_POST['forward_document'])) {
  $purpose = real_escape_string($_POST['purpose']);

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, real_escape_string($_POST['destination']), $purpose, 'New');
  update_document_status($code, $purpose);

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [' . strtoupper($code) . '] has been forwarded successfully!';
  }
}

if (isset($_POST['complete_document'])) {
  $remarks = real_escape_string($_POST['remarks']);
  $status = strlen($remarks) > 0 ? "Completed - {$remarks}" : 'Completed';

  update_document_logs_done($code);
  insert_document_log($code, $user_id, $station, '-', 'Completed', 'Done');
  update_document_status($code, $status, 'Read');

  if (affected_rows()) {
    $show_prompt = true;
    $message = 'Document code [' . strtoupper($code) . '] has been mark completed successfully.';
  }
}

if (isset($_POST['cancel_document'])) {
}
?>