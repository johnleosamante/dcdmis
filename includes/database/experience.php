<?php
// includes/database/experience.php

function experiences($id) {
  return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, Organization AS organization, Monthly_Salary AS salary, Salary_Grade AS sg, Job_Status AS `status`, Goverment AS isgovernment, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function experience($id, $no) {
  return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, Organization AS organization, Monthly_Salary AS salary, Salary_Grade AS sg, Job_Status AS `status`, Goverment AS isgovernment, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function create_experience($from, $to, $ispresent, $position, $organization, $salary, $sg, $status, $isgovernment, $id) {
  non_query("INSERT INTO work_experience (`From`, `To`, ispresent, `Position_Title`, `Organization`, Monthly_Salary, Salary_Grade, Job_Status, Goverment, Emp_ID) VALUES ('{$from}', '{$to}', '{$ispresent}', '{$position}', '{$organization}', '{$salary}', '{$sg}', '{$status}', '{$isgovernment}', '{$id}');");
}

function update_experience($from, $to, $ispresent, $position, $organization, $salary, $sg, $status, $isgovernment, $id, $no) {
  non_query("UPDATE work_experience SET `From`='{$from}', `To`='{$to}', ispresent='{$ispresent}', `Position_Title`='{$position}', `Organization`='{$organization}', Monthly_Salary='{$salary}', Salary_Grade='{$sg}', Job_Status='{$status}', Goverment='{$isgovernment}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function delete_experience($id, $no) {
  non_query("DELETE FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>