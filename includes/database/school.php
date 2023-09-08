<?php
// includes/database/school.php
// tbl_school
function schools() {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, School_Category AS category, SchoolLogo AS logo FROM tbl_school ORDER BY SchoolName;");
}

function districtSchools($id) {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, School_Category AS category, SchoolLogo AS logo FROM tbl_school WHERE District_code='{$id}' ORDER BY SchoolName;");
}

function schoolsExcept($id) {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias FROM tbl_school WHERE SchoolName <> '{$id}' ORDER BY SchoolName;");
}

function schoolByAlias($alias) {
  return query("SELECT SchoolID AS id, SchoolName AS `name`, Incharg_ID AS `head` FROM tbl_school WHERE Abraviate='{$alias}' LIMIT 1;");
}

function schoolById($id) {
  return query("SELECT Abraviate AS alias, SchoolName AS `name`, Incharg_ID AS `head` FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolDetailsById($id) {
  return query("SELECT Abraviate AS alias, SchoolName AS `name`, `Address` AS `address`, Incharg_ID AS `head`, District_code AS `district`, School_Category AS category, SchoolLogo AS `logo`, telephone, email, website, fb_page FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolsByDistrict($district) {
  return query("SELECT SchoolID AS `id`, SchoolName AS `name` FROM tbl_school WHERE District_code='{$district}' ORDER BY SchoolName;");
}

function updateSchoolHead($schoolId, $headId) {
  nonQuery("UPDATE tbl_school SET `Incharg_ID`='{$headId}' WHERE `SchoolID`='{$schoolId}';");
}

function schoolEmployeeCount($id=null) {
  $filter = isset($id) ? " AND tbl_school.SchoolID='{$id}'" : '';
  return query("SELECT tbl_school.SchoolID AS id, tbl_school.SchoolName AS name, tbl_school.Address AS address, tbl_school.Abraviate AS alias, tbl_district.District_code AS districtId, tbl_district.District_Name AS district, tbl_school.School_Category AS category, tbl_school.Incharg_ID AS head, tbl_school.SchoolLogo AS logo, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS tmale, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching-Related' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS trmale, SUM(CASE WHEN tbl_job.Job_Category = 'Non-Teaching' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS ntmale, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS male, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS tfemale, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching-Related' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS trfemale, SUM(CASE WHEN tbl_job.Job_Category = 'Non-Teaching' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS ntfemale, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS female, COUNT(*) AS total FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status='Active' {$filter} GROUP BY tbl_school.SchoolName ORDER BY tbl_district.District_Name, tbl_school.School_Category, tbl_school.SchoolName;");
}
 
function createSchool($id, $name, $alias, $address, $district, $category, $logo) {
  nonQuery("INSERT INTO tbl_school (`SchoolID`, `SchoolName`, `Abraviate`, `Address`, `District_code`, `School_Category`, `SchoolLogo`) VALUES ('{$id}', '{$name}', '{$alias}', '{$address}', '{$district}', '{$category}', '{$logo}');");
}

function updateSchool($id, $name, $alias, $address, $district, $category, $referenceId) {
  nonQuery("UPDATE tbl_school SET `SchoolID`='{$id}', `SchoolName`='{$name}', `Abraviate`='{$alias}', `Address`='{$address}', `District_code`='{$district}', `School_Category`='{$category}' WHERE `SchoolID`='{$referenceId}' LIMIT 1;");
}
?>