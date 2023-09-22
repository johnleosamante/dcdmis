<?php
// includes/database/psipop.php
// psipop
function psipop($id) {
  return query("SELECT `No` AS `no`, `Item_Number` AS `item`, `sg`, `Step` AS `step`, `Job_status` AS `status`, `Date_promoted` AS `date_promoted`, `Elegibility` AS `eligibility` FROM psipop WHERE `Emp_ID`='{$id}';");
}

function createPsipop($itemNo, $step, $status, $datePromoted, $eligibility, $id) {
  nonQuery("INSERT INTO psipop (`Item_Number`, `Step`, `Job_status`, `Date_promoted`, `Elegibility`, `Emp_ID`) VALUES ('{$itemNo}', '{$step}', '{$status}', '{$datePromoted}', '{$eligibility}', '{$id}');");
}

function updatePsipop($itemNo, $sg, $step, $status, $datePromoted, $eligibility, $id) {
  nonQuery("UPDATE psipop SET `Item_Number`='{$itemNo}', `sg`='{$sg}', `Step`='{$step}', `Job_status`='{$status}', `Date_promoted`='{$datePromoted}', `Elegibility`='{$eligibility}' WHERE `Emp_ID`='{$id}' LIMIT 1;");
}
?>