<?php
// includes/database/psipop.php
// psipop
function psipop($id) {
  return query("SELECT `No` AS `no`, `Item_Number` AS `item`, `Step` AS `step`, `Job_status` AS `status`, `Original_Appointment` AS `original_appointment`, `Date_promoted` AS `date_promoted`, `Elegibility` AS `eligibility` FROM psipop WHERE `Emp_ID`='{$id}';");
}

function createPsipop($itemNo, $step, $status, $originalAppointment, $datePromoted, $eligibility, $id) {
  nonQuery("INSERT INTO psipop (`Item_Number`, `Step`, `Job_status`, `Original_Appointment`, `Date_promoted`, `Elegibility`, `Emp_ID`) VALUES ('{$itemNo}', '{$step}', '{$status}', '{$originalAppointment}', '{$datePromoted}', '{$eligibility}', '{$id}');");
}

function updatePsipop($itemNo, $step, $status, $originalAppointment, $datePromoted, $eligibility, $id) {
  nonQuery("UPDATE psipop SET `Item_Number`='{$itemNo}', `Step`='{$step}', `Job_status`='{$status}', `Original_Appointment`='{$originalAppointment}', `Date_promoted`='{$datePromoted}', `Elegibility`='{$eligibility}' WHERE `Emp_ID`='{$id}' LIMIT 1;");
}
?>