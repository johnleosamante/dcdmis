<?php
// includes/database/document.php
// tbl_transactions
// tbl_transactions_log

function document($id) {
  return query("SELECT TransCode AS id, Title AS `description`, Date_time AS `datetime`, Trans_from AS `from`, Trans_Stats AS `status` FROM tbl_transactions WHERE TransCode='{$id}' LIMIT 1;");
}

function is_document($id, $status) {
  return num_rows(query("SELECT TransCode AS id FROM tbl_transactions WHERE TransCode='{$id}' AND Trans_Stats LIKE '%{$status}%';")) > 0;
}

function count_documents_from($station, $year) {
  return num_rows(query("SELECT TransCode AS id FROM tbl_transactions WHERE Trans_from='{$station}' AND TransCode LIKE '%{$station}-{$year}-%';"));
}

function document_from($id, $station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions.Date_time AS `datetime`, tbl_transactions.Trans_from AS `from`, tbl_transactions.Trans_Stats AS `status` FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE (tbl_transactions_log.From_office='{$station}' OR tbl_transactions_log.Forwarded_to='{$station}') AND tbl_transactions_log.Transaction_code='{$id}';");
}

function document_origin($id) {
  return query("SELECT tbl_transactions.TransCode AS `id`, tbl_transactions.Title AS `description`, tbl_transactions.Date_time AS `datetime`, tbl_transactions_log.Recieved_by AS `user`, tbl_transactions_log.From_office AS `from` FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' ORDER BY tbl_transactions_log.Date_recieved ASC LIMIT 1;");
}

function is_document_from($id, $station, $status='New') {
  return num_rows(query("SELECT Transaction_code AS id FROM tbl_transactions_log WHERE From_office='{$station}' AND `Status`='{$status}' AND Transaction_code='{$id}';"));
}

function insert_document($id, $description, $station, $purpose) {
  non_query("INSERT INTO tbl_transactions (TransCode, Title, Date_time, Trans_from, Trans_Stats) VALUES ('{$id}', '{$description}', NOW(), '{$station}', '{$purpose}');");
}

function update_document($id, $description, $station, $purpose) {
  non_query("UPDATE tbl_transactions SET Title='{$description}', Date_time=NOW(), Trans_Stats='{$purpose}' WHERE TransCode='{$id}' AND Trans_from='{$station}' LIMIT 1;");
}

function incoming_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.From_office AS `from`, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_Stats AS purpose, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions_log.Forwarded_to='{$station}' AND  tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_incoming_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.Forwarded_to='{$station}' AND  tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function pending_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Recieved_by AS user, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_pending_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function outgoing_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Forwarded_to AS `to`, tbl_transactions_log.Recieved_by AS user, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to <> '' AND tbl_transactions_log.Forwarded_to <> '-' AND tbl_transactions_log.Status='new' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_outgoing_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to <> '' AND tbl_transactions_log.Forwarded_to <> '-' AND tbl_transactions_log.Status='new' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function ongoing_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Forwarded_to AS `to`, tbl_transactions.Date_time AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions_log.Trans_status NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions_log.Trans_status NOT LIKE '%Cancel%' GROUP BY tbl_transactions.TransCode ORDER BY tbl_transactions_log. Date_recieved DESC;");
}

function is_ongoing_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions_log.Trans_status NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions_log.Trans_status NOT LIKE '%Cancel%' GROUP BY tbl_transactions.TransCode ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function completed_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions.Date_time AS `postedon`, tbl_transactions_log.Date_recieved AS completedon, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Complete%' AND tbl_transactions_log.Trans_status LIKE '%Complete%' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_completed_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Complete%' AND tbl_transactions_log.Trans_status LIKE '%Complete%' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function received_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from <> '{$station}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND (tbl_transactions_log.Trans_status LIKE '%Received%' OR tbl_transactions_log.Trans_status LIKE '%On Process%') AND tbl_transactions_log.Status='Done' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_received_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from <> '{$station}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND (tbl_transactions_log.Trans_status LIKE '%Received%' OR tbl_transactions_log.Trans_status LIKE '%On Process%') AND tbl_transactions_log.Status='Done' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function canceled_documents($station) {
  return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions.Date_time AS `postedon`, tbl_transactions_log.Date_recieved AS `canceledon`, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Cancel%' AND tbl_transactions_log.Trans_status LIKE '%Cancel%' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function is_canceled_document($id, $station) {
  return num_rows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Cancel%' AND tbl_transactions_log.Trans_status LIKE '%Cancel%' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function document_log($id) {
  return query("SELECT `tbl_transactions`.`TransCode` AS `id`, `tbl_transactions`.`Title` AS `description`, `tbl_transactions`.`Trans_from` AS `from`, `tbl_transactions_log`.`Date_recieved` AS `datetime`, `tbl_transactions_log`.`Forwarded_To` AS `destination`, `tbl_transactions_log`.`Trans_status` AS `purpose` FROM `tbl_transactions` INNER JOIN `tbl_transactions_log` ON `tbl_transactions`.`TransCode` = `tbl_transactions_log`.`Transaction_code` WHERE `tbl_transactions`.`TransCode`='{$id}' ORDER BY `datetime` DESC LIMIT 1;");
}

function document_logs($id) {
  return query("SELECT Date_recieved AS `datetime`, Recieved_by AS `user`, From_office AS `from`, Forwarded_to AS `to`, Trans_status AS `status` FROM tbl_transactions_log WHERE Transaction_code='{$id}' ORDER BY Date_recieved DESC;");
}

function insert_document_log($id, $user, $station, $destination, $purpose, $status='New') {
  non_query("INSERT INTO tbl_transactions_log VALUES (null, NOW(), '{$user}', '{$station}', '{$destination}', '{$purpose}', '{$id}', '{$status}');");
}

function update_document_log($id, $user, $station, $destination, $purpose, $status='New', $change_date=true) {
  $date = $change_date ? "Date_Recieved=NOW(), " : '';
  non_query("UPDATE tbl_transactions_log SET " . $date . " Recieved_by='{$user}', From_office='{$station}', Forwarded_to='{$destination}', Trans_status='{$purpose}', `Status`='{$status}' WHERE Transaction_code='{$id}' ORDER BY Date_Recieved DESC LIMIT 1;");
}

function update_document_logs_done($id) {
  non_query("UPDATE tbl_transactions_log SET `Status`='Done' WHERE Transaction_code='{$id}';");
}

function update_document_status($id, $purpose, $status='Unread') {
  non_query("UPDATE tbl_transactions SET Trans_Stats='{$purpose}',`Status`='{$status}' WHERE TransCode='{$id}' LIMIT 1;");
}
?>