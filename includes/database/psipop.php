<?php
// includes/database/psipop.php
// psipop
// tbl_step_increment
// tbl_loyalty_award
function psipop($id) {
  return query("SELECT `No` AS `no`, `Item_Number` AS `item`, `Step` AS `step`, `Job_status` AS `status`, `Original_Appointment` AS `original_appointment`, `Date_promoted` AS `date_promoted`, `Elegibility` AS `eligibility` FROM psipop WHERE `Emp_ID`='{$id}';");
}

function createPsipop($itemNo, $step, $status, $originalAppointment, $datePromoted, $eligibility, $id) {
  nonQuery("INSERT INTO psipop (`Item_Number`, `Step`, `Job_status`, `Original_Appointment`, `Date_promoted`, `Elegibility`, `Emp_ID`) VALUES ('{$itemNo}', '{$step}', '{$status}', '{$originalAppointment}', '{$datePromoted}', '{$eligibility}', '{$id}');");
}

function updatePsipop($itemNo, $step, $status, $originalAppointment, $datePromoted, $eligibility, $id) {
  nonQuery("UPDATE psipop SET `Item_Number`='{$itemNo}', `Step`='{$step}', `Job_status`='{$status}', `Original_Appointment`='{$originalAppointment}', `Date_promoted`='{$datePromoted}', `Elegibility`='{$eligibility}' WHERE `Emp_ID`='{$id}' LIMIT 1;");
}

function createStepIncrement($dateLastStep, $stepNo, $sg, $id) {
  nonQuery("INSERT INTO tbl_step_increment (`Date_last_step`, `Step_No`, `No_of_year`, `Emp_ID`) VALUES ('{$dateLastStep}', '{$stepNo}', '{$sg}', '{$id}');");
}

function loyaltyAward($id) {
  return query("SELECT * FROM (SELECT psipop.Emp_ID AS id, TIMESTAMPDIFF(YEAR, psipop.Original_Appointment, NOW()) AS years_active, TIMESTAMPDIFF(YEAR, tbl_loyalty_award.awarded_on, NOW()) AS last_awarded FROM psipop INNER JOIN tbl_loyalty_award ON psipop.Emp_ID=tbl_loyalty_award.employee_id) AS service_years WHERE years_active >= 10 AND last_awarded >= 5 AND id='{$id}';");
}

function stepIncrement($id) {
  return query("SELECT * FROM (SELECT Emp_ID AS id, Date_last_step AS last_step_date, Step_No AS step, TIMESTAMPDIFF(YEAR, Date_last_step, NOW()) AS years_active FROM tbl_step_increment ORDER BY Date_last_step) AS service_years WHERE years_active >= 3 AND step < 8 AND id='{$id}';");
}
?>