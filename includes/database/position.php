<?php
// includes/database/position.php
// tbl_jobs
// tbl_station

function position($id) {
  return query("SELECT tbl_station.Emp_ID AS `user`, tbl_job.Job_description AS `position` FROM `tbl_station` INNER JOIN tbl_job ON tbl_job.Job_code = tbl_station.Emp_Position WHERE tbl_station.Emp_ID='{$id}' ORDER BY `position` DESC LIMIT 1;");
}

function positions($id = null) {
  $filter = $id === null ? '' : "WHERE Job_code='{$id}'";
  return query("SELECT Job_code AS id, Job_description AS position, Job_Category AS category, Salary_Grade AS salary_grade FROM tbl_job {$filter} ORDER BY Job_description ASC;");
}
?>