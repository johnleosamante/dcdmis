<?php
// includes/database/experience.php

function experiences($id) {
  return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `Position_Title` AS `position`, Organization AS organization, Monthly_Salary AS salary, Salary_Grade AS sg, Job_Status AS `status`, Goverment AS isgovernment, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}
?>