<?php
// includes/database/employee.php
function employee($id) {
  return query("SELECT Emp_LName AS lname, Emp_FName AS fname, Emp_MName AS mname, Emp_Extension AS ext, Picture AS picture FROM tbl_employee WHERE Emp_ID='{$id}' LIMIT 1;");
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
?>