<?php
# _includes_/database/database.php

$con = DBConnect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

function DBConnect($db_server, $db_user, $db_password, $db_name) {
  return mysqli_connect($db_server, $db_user, $db_password, $db_name);
}

function DBConnection() {
  global $con;
  return $con;
}

function DBAffectedRows() {
  return mysqli_affected_rows(DBConnection());
}

function DBQuery($sql_statement) {
  return mysqli_query(DBConnection(), $sql_statement);
}

function DBNonQuery($sql_statement) {
  mysqli_query(DBConnection(), $sql_statement);
}

function DBRealEscapeString($string) {
  return mysqli_real_escape_string(DBConnection(), $string);
}

function DBFetchAssoc($query_result) {
  return mysqli_fetch_assoc($query_result);
}

function DBFetchArray($query_result) {
  return mysqli_fetch_array($query_result);
}

function DBNumRows($query_result) {
  return mysqli_num_rows($query_result);
}
?>