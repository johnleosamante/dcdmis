<?php
# _includes_/database/deployment-history.php

function InsertDeploymentHistory($assignmentDate, $station, $position, $years, $step, $subject, $employeeID) {
  DBQuery("INSERT INTO tbl_deployment_history VALUES (NULL, '$assignmentDate', '$station', '$position', '$years', '$step', '$subject', '$employeeID');");
}
?>