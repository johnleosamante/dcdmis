<?php
// includes/database/deployment-history.php
// tbl_deployment_history
function createDeployment($date, $station, $position, $id)
{
    nonQuery("INSERT INTO tbl_deployment_history (`Date_assignment`, `station_assign`, `position_assign`, `Emp_ID`) VALUES ('{$date}', '{$station}', '{$position}', '{$id}');");
}
