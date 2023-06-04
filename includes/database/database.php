<?php
// include/database/database.php
$con = connect(HOSTNAME, USER, PASSWORD, DATABASE, PORT);

function connect($hostname, $user, $password, $database, $port) {
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  return mysqli_connect($hostname, $user, $password, $database, $port);
}

function connection() {
  global $con;
  return $con;
}

function affectedRows() {
  return mysqli_affected_rows(connection());
}

function query($query) {
  return mysqli_query(connection(), $query);
}

function nonQuery($query) {
  mysqli_query(connection(), $query);
}

function fetchAllAssoc($result) {
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function fetchAssoc($result) {
  return mysqli_fetch_assoc($result);
}

function fetchArray($result) {
  return mysqli_fetch_array($result);
}

function numRows($result) {
  return mysqli_num_rows($result);
}
?>