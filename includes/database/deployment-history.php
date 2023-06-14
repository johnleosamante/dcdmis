<?php
// includes/database/deployment-history.php
// tbl_job
// tbl_school
// tbl_deployment_history
function deploymentHistory($id) {
  return query("SELECT tbl_deployment_history.Emp_ID AS id, tbl_deployment_history.Date_assignment AS `date`, tbl_deployment_history.station_assign AS station_id, tbl_school.SchoolName AS station, tbl_deployment_history.position_assign AS position_id, tbl_job.Job_description AS position, tbl_deployment_history.StepNo AS step FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_job.Job_code=tbl_deployment_history.position_assign WHERE tbl_deployment_history.Emp_ID='{$id}' ORDER BY tbl_deployment_history.Date_assignment DESC;");
}

function deployment($id) {
  return query("SELECT tbl_deployment_history.Emp_ID AS id, tbl_deployment_history.Date_assignment AS `date`, tbl_deployment_history.station_assign AS station_id, tbl_school.SchoolName AS station, tbl_deployment_history.position_assign AS position_id, tbl_job.Job_description AS position, tbl_deployment_history.StepNo AS step FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_job.Job_code=tbl_deployment_history.position_assign WHERE tbl_deployment_history.Emp_ID='{$id}' ORDER BY tbl_deployment_history.Date_assignment DESC LIMIT 1;");
}

function validateDeployment($stationId, $positionId, $id) {
  return query("SELECT station_assign AS station_id, position_assign AS position_id, Emp_ID AS id FROM tbl_deployment_history WHERE station_assign='{$stationId}' AND position_assign='{$positionId}' AND Emp_ID='{$id}' ORDER BY Date_assignment DESC LIMIT 1;");
}

function createDeployment($date, $stationId, $positionId, $id) {
  nonQuery("INSERT INTO tbl_deployment_history (`Date_assignment`, `station_assign`, `position_assign`, Emp_ID) VALUES ('{$date}', '{$stationId}', '{$positionId}', '{$id}');");
}
?>