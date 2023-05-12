<?php
// includes/database/employee.php
function employee($id) {
  return query("SELECT Emp_ID AS id, Emp_LName AS lname, Emp_FName AS fname, Emp_MName AS mname, Emp_Extension AS ext, Emp_Month AS `month`, Emp_Day AS `day`, Emp_Year AS `year`, Emp_place_of_birth AS `pob`, Emp_Sex AS sex, Emp_Res_Lot AS rlot, Emp_Res_Street AS rstreet, Emp_Res_Subdivision AS rsubdivision, Emp_Res_Barangay AS rbarangay, Emp_Res_City AS rcity, Emp_Address AS rprovince, Emp_Res_ZIP AS rzip, Emp_Per_Lot AS plot, Emp_Per_Street AS pstreet, Emp_Per_Subdivision AS psubdivision, Emp_Per_Barangay AS pbarangay, Emp_Per_City AS pcity, Emp_Per_Province AS pprovince, Emp_Per_ZIP AS pzip, Emp_Telephone AS telephone, Emp_CS AS civil_status, Emp_CS_Others AS civil_status_specify, Emp_Citizen AS citizenship, Emp_Dual_Citizenship AS dual_citizenship, Emp_Country AS country, Emp_Height AS height, Emp_Weight AS `weight`, Emp_Blood_type AS blood_type, Emp_GSIS AS gsis, Emp_PAGIBIG AS pagibig, Emp_PHILHEALTH AS philhealth, Emp_SSS AS sss, Emp_Cell_No AS mobile, Emp_Email AS email, Picture AS picture, Emp_TIN AS tin, Emp_Status AS `status`, EmpNo AS agency_id FROM tbl_employee WHERE Emp_ID='{$id}' LIMIT 1;");
}

function active_employees($station=null) {
  $filter = $station === null ? '' : " AND tbl_station.Emp_Station='{$station}'";
  return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS month, tbl_employee.Emp_Day AS day, tbl_employee.Emp_Year AS year, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' {$filter} ORDER BY tbl_employee.Emp_LName ASC;");
}

function retirable_employees($station=null) {
  $filter = $station === null ? '' : " AND station='{$station}'";
  return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS month, tbl_employee.Emp_Day AS day, tbl_employee.Emp_Year AS year, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active') AS employee WHERE year_age >= 60 {$filter} ORDER BY lname ASC;");
}

function archived_employees() {
  return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS month, tbl_employee.Emp_Day AS day, tbl_employee.Emp_Year AS year, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS `status`  FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE (tbl_employee.Emp_Status NOT LIKE 'Active' AND tbl_employee.Emp_Status NOT LIKE 'Registered') ORDER BY tbl_employee.Emp_LName ASC;");
}

function employee_search($text) {
  return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS month, tbl_employee.Emp_Day AS day, tbl_employee.Emp_Year AS year, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS `status`  FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_LName LIKE '%{$text}%' OR tbl_employee.Emp_FName LIKE '%{$text}%' OR tbl_employee.Emp_MName LIKE '%{$text}%' OR tbl_employee.Emp_GSIS='{$text}' OR tbl_employee.Emp_PAGIBIG='{$text}' OR tbl_employee.Emp_PHILHEALTH='{$text}' OR tbl_employee.Emp_SSS='{$text}' OR tbl_employee.Emp_TIN='{$text}' OR tbl_employee.EmpNo='{$text}' ORDER BY tbl_employee.Emp_LName ASC;");
}

function employee_gender() {
  return query("SELECT Emp_Sex AS `name`, COUNT(*) AS `count` FROM tbl_employee WHERE Emp_Status='Active' GROUP BY Emp_Sex ORDER BY Emp_Sex DESC;");
}

function employee_station() {
  return query("SELECT tbl_school.SchoolName AS `name`, COUNT(*) AS `count` FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_school.SchoolName ORDER BY tbl_district.District_Name, tbl_school.SchoolName;");
}

function employee_position() {
  return query("SELECT tbl_job.Job_description AS `name`, COUNT(*) AS `count` FROM tbl_station INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_description ORDER BY tbl_job.Salary_Grade DESC, tbl_job.Job_description ASC;");
}

function district_employee() {
  return query("SELECT tbl_district.District_Name AS name, COUNT(*) AS count FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_district.District_Name ORDER BY tbl_district.District_Name;");
}

function employee_category() {
  return query("SELECT tbl_job.Job_Category AS name, COUNT(*) AS count FROM tbl_job INNER JOIN tbl_station ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_Category ORDER BY tbl_job.Job_Category;");
}

function employee_gender_category() {
  return query("SELECT tbl_job.Job_Category AS `name`, COUNT(CASE WHEN tbl_employee.Emp_Sex='Male' THEN 1 END) AS male, COUNT(CASE WHEN tbl_employee.Emp_Sex='Female' THEN 1 END) AS female FROM tbl_job INNER JOIN tbl_station ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_Category ORDER BY tbl_job.Job_Category;");
}

function celebrant_employees($month, $station=null) {
  $filter = $station === null ? '' : " AND station_code='{$station}'";
  return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_station.Emp_Station AS station_code, tbl_employee.Picture AS picture FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active') AS employee WHERE `month`='{$month}' {$filter} ORDER BY `day` ASC;");
}
?>