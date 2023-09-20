<?php
// includes/database/experience.php
// work_experience
// tbl_service_records
function experiences($id) {
  return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, Organization AS organization, Monthly_Salary AS salary, Salary_Grade AS sg, Job_Status AS `status`, Goverment AS isgovernment, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function experience($id, $no) {
  return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, Organization AS organization, Monthly_Salary AS salary, Salary_Grade AS sg, Job_Status AS `status`, Goverment AS isgovernment, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $id) {
  nonQuery("INSERT INTO work_experience (`From`, `To`, ispresent, `Position_Title`, `Organization`, Monthly_Salary, Salary_Grade, Job_Status, Goverment, Emp_ID) VALUES ('{$from}', '{$to}', '{$isPresent}', '{$position}', '{$organization}', '{$salary}', '{$sg}', '{$status}', '{$isGovernment}', '{$id}');");
}

function updateExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $id, $no) {
  nonQuery("UPDATE work_experience SET `From`='{$from}', `To`='{$to}', ispresent='{$isPresent}', `Position_Title`='{$position}', `Organization`='{$organization}', Monthly_Salary='{$salary}', Salary_Grade='{$sg}', Job_Status='{$status}', Goverment='{$isGovernment}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteExperience($id, $no) {
  nonQuery("DELETE FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function serviceRecords($id) {
  return query("SELECT `No` AS `no`, `date_from` AS `from`, `date_to` AS `to`, `ispresent`, `position`, `station`, `grade`, `step`, `salary`, `work_status` AS `status`, `isgovernment`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, `Emp_ID` AS `id` FROM `tbl_service_records` WHERE `Emp_ID`='{$id}' ORDER BY `date_from` DESC;");
}

function serviceRecord($id, $no) {
  return query("SELECT `No` AS `no`, `date_from` AS `from`, `date_to` AS `to`, `ispresent`, `position`, `station`, `grade`, `step`, `salary`, `work_status` AS `status`, `isgovernment`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, `Emp_ID` AS `id` FROM `tbl_service_records` WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createServiceRecord($from, $to, $isPresent, $position, $station, $grade, $step, $salary, $status, $isGovernment, $leaveDates, $isSeparation, $separationDate, $separationCause, $id) {
  nonQuery("INSERT INTO tbl_service_records (`date_from`, `date_to`, `ispresent`, `position`, `station`, `grade`, `step`, `salary`, `work_status`, `isgovernment`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, `Emp_ID`) VALUES ('{$from}', '{$to}', '{$isPresent}', '{$position}', '{$station}', '{$grade}', '{$step}', '{$salary}', '{$status}', '{$isGovernment}', '{$leaveDates}', '{$isSeparation}', '{$separationDate}', '{$separationCause}', '{$id}');");
}

function updateServiceRecord($from, $to, $isPresent, $position, $station, $grade, $step, $salary, $status, $isGovernment, $leaveDates, $isSeparation, $separationDate, $separationCause, $id, $no) {
  nonQuery("UPDATE tbl_service_records SET `date_from`='{$from}', `date_to`='{$to}', `ispresent`='{$isPresent}', `position`='{$position}', `station`='{$station}', `grade`='{$grade}', `step`='{$step}', `salary`='{$salary}', `work_status`='{$status}', `isgovernment`='{$isGovernment}', `leave_dates`='{$leaveDates}', `isseparation`='{$isSeparation}', `separation_date`='{$separationDate}', `separation_cause`='{$separationCause}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteServiceRecord($id, $no) {
  nonQuery("DELETE FROM tbl_service_records WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>