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

function schoolDetails($id=null) {
  $schoolId = empty($id) ? ' ' : " AND tbl_school.SchoolID='{$id}' ";
  return query("SELECT tbl_school.SchoolLogo AS `logo`, tbl_school.Abraviate AS alias, tbl_school.SchoolID AS `id`, tbl_school.SchoolName AS school, tbl_school.Address AS address, tbl_district.District_Name AS district, tbl_school.Incharg_ID AS `head`, tbl_school.telephone, tbl_school.email, tbl_school.website, tbl_school.fb_page, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) as male, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) as female, COUNT(*) as `total` FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_employee.Emp_Status='Active'" . $schoolId . "GROUP BY tbl_school.SchoolName ORDER BY tbl_school.SchoolName;");
}
?>