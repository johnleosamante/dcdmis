<?php
// includes/database/school.php
// tbl_school
function schools() {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, SchoolLogo AS logo FROM tbl_school ORDER BY SchoolName;");
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
  return query("SELECT Abraviate AS alias, SchoolName AS `name`, `Address` AS `address`, Incharg_ID AS `head`, District_code AS `district`, School_Category AS category, SchoolLogo AS `logo`, telephone, email, website, fb_page FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolEmployeeCount($id) {
  return query("SELECT SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) as male, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) as female, COUNT(*) as `total` FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_Status='Active' AND tbl_school.SchoolID='{$id}' GROUP BY tbl_school.SchoolName ORDER BY tbl_school.SchoolName;");
}
 
function createSchool($id, $name, $alias, $address, $district, $category, $logo) {
  nonQuery("INSERT INTO tbl_school (`SchoolID`, `SchoolName`, `Abraviate`, `Address`, `District_code`, `School_Category`, `SchoolLogo`) VALUES ('{$id}', '{$name}', '{$alias}', '{$address}', '{$district}', '{$category}', '{$logo}');");
}

function updateSchool($id, $name, $alias, $address, $district, $category, $referenceId) {
  nonQuery("UPDATE tbl_school SET `SchoolID`='{$id}', `SchoolName`='{$name}', `Abraviate`='{$alias}', `Address`='{$address}', `District_code`='{$district}', `School_Category`='{$category}' WHERE `SchoolID`='{$referenceId}' LIMIT 1;");
}
?>