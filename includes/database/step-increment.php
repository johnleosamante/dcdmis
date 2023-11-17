<?php
// includes/database/step-increment.php
// tbl_step_increment
function createStepIncrement($dateLastStep, $stepNo, $sg, $id) {
  nonQuery("INSERT INTO tbl_step_increment (`Date_last_step`, `Step_No`, `No_of_year`, `Emp_ID`) VALUES ('{$dateLastStep}', '{$stepNo}', '{$sg}', '{$id}');");
}
?>