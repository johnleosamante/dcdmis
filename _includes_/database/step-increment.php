<?php
# _includes_/database/step-increment.php

function InsertStepIncrement($dateLastStep, $step, $years, $employeeID) {
  DBNonQuery("INSERT INTO tbl_step_increment VALUES (NULL, '$dateLastStep', '$step', '$years', '$employeeID');");
}
?>