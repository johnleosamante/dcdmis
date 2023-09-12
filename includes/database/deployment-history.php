<?php
// includes/database/deployment-history.php
// tbl_deployment_history
function createDeployment($date, $station, $position, $years, $step, $subject, $id) {
  nonQuery("INSERT INTO tbl_deployment_history (`Date_assignment`, `station_assign`, `position_assign`, `No_of_years`, `StepNo`, `SubjectArea`, `Emp_ID`) VALUES ('{$date}', '{$station}', '{$position}', '{$years}', '{$step}', '{$subject}', '{$id}');");
}
?>