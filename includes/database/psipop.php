<?php
// includes/database/psipop.php
// psipop
function createPsipop($itemNo, $step, $status, $datePromoted, $eligibility, $id) {
  nonQuery("INSERT INTO psipop (`Item_Number`, `Step`, `Job_status`, `Date_promoted`, `Elegibility`, `Emp_ID`) VALUES ('$itemNo', '$step', '$status', '$datePromoted', '$eligibility', '$id');");
}
?>