<?php
// include/database/database.php
// All custom made database related function goes here.

$con = connect(HOSTNAME, USER, PASSWORD, DATABASE, PORT);

function connect($hostname, $user, $password, $database, $port) {
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  return mysqli_connect($hostname, $user, $password, $database, $port);
}

function connection() {
  global $con;
  return $con;
}

function affected_rows() {
  return mysqli_affected_rows(connection());
}

function query($query) {
  return mysqli_query(connection(), $query);
}

function non_query($query) {
  mysqli_query(connection(), $query);
}

function fetch_all_assoc($result) {
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function fetch_assoc($result) {
  return mysqli_fetch_assoc($result);
}

function fetch_array($result) {
  return mysqli_fetch_array($result);
}

function num_rows($result) {
  return mysqli_num_rows($result);
}
?>