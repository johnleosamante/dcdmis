<?php
// includes/database/eligibility.php

function eligibility($id) {
  return query("SELECT `No` AS `no`, Carrer_Service AS eligibility, Rating AS rating, Date_of_Examination AS `date`, Place_of_Examination AS `place`, Number_of_Hour AS `license`, Date_of_Validity AS `validity`, Emp_ID AS `id` FROM civil_service WHERE Emp_ID='{$id}' ORDER BY Date_of_Examination ASC;");
}
?>