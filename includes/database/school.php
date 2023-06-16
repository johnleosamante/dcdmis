<?php
// includes/database/school.php
// tbl_school
function schools() {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias FROM tbl_school ORDER BY SchoolName;");
}

function schoolsExcept($id) {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias FROM tbl_school WHERE SchoolName <> '{$id}' ORDER BY SchoolName;");
}

function schoolByAlias($alias) {
  return query("SELECT SchoolID AS id, SchoolName AS `name` FROM tbl_school WHERE Abraviate='{$alias}' LIMIT 1;");
}

function schoolById($id) {
  return query("SELECT Abraviate AS alias, SchoolName AS `name` FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolDetailsById($id) {
  return query("SELECT Abraviate AS alias, SchoolName AS `name`, `Address` AS `address`, Incharg_ID AS `head`, District_code AS `district`, SchoolLogo AS `logo`, telephone, email, website, fb_page FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}
?>