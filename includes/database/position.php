<?php
// includes/database/position.php
// tbl_jobs
// tbl_station

function position($id) {
  return query("SELECT tbl_station.Emp_ID AS `user`, tbl_job.Job_description AS `position` FROM `tbl_station` INNER JOIN tbl_job ON tbl_job.Job_code = tbl_station.Emp_Position WHERE tbl_station.Emp_ID='{$id}' ORDER BY `position` DESC LIMIT 1;");
}
?>