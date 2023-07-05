<?php
// includes/database/learning-development.php
// learning_and_development
// tbl_seminar
// tbl_seminar_participant
function learningAndDevelopments($id) {
  return query("SELECT `No` AS `no`, Title_of_Training AS `title`, `From` AS `from`, `To` AS `to`, `Number_of_Hours` AS `hours`, `Managerial` AS `type`, `Conducted` AS `sponsor`, Emp_ID AS `id` FROM learning_and_development WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function learningAndDevelopment($id, $no) {
  return query("SELECT `No` AS `no`, Title_of_Training AS `title`, `From` AS `from`, `To` AS `to`, `Number_of_Hours` AS `hours`, `Managerial` AS `type`, `Conducted` AS `sponsor`, Emp_ID AS `id` FROM learning_and_development WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createlearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $id) {
  nonQuery("INSERT INTO learning_and_development (`Title_of_Training`, `From`, `To`, `Number_of_Hours`, `Managerial`, `Conducted`, Emp_ID) VALUES ('{$title}', '{$from}', '{$to}', '{$hours}', '{$type}', '{$sponsor}', '{$id}');");
}

function updateLearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $id, $no) {
  nonQuery("UPDATE learning_and_development SET `Title_of_Training`='{$title}', `From`='{$from}', `To`='{$to}', `Number_of_Hours`='{$hours}', `Managerial`='{$type}', `Conducted`='{$sponsor}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteLearningAndDevelopment($id, $no) {
  nonQuery("DELETE FROM learning_and_development WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function trainings() {
  return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `Category` AS `type`, `conducted_by` AS `sponsor`, `TVenue` AS `venue` FROM tbl_seminar ORDER BY `From` DESC, `To` DESC;");
}

function training($id) {
  return query("SELECT `Training_code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `Category` AS `type`, `conducted_by` AS `sponsor`, `TVenue` AS `venue` FROM tbl_seminar WHERE `Training_code`='{$id}' LIMIT 1;");
}

function countTrainings($year) {
  return numRows(query("SELECT `Training_code` AS `no` FROM tbl_seminar WHERE `Training_code` LIKE '%-{$year}-%';"));
}

function createTraining($no, $title, $from, $to, $type, $sponsor, $venue) {
  return nonQuery("INSERT INTO tbl_seminar (`Training_Code`, `Title_of_training`, `covered_from`, `covered_to`, `Category`, `conducted_by`, `TVenue`) VALUES ('{$no}', '{$title}', '{$from}', '{$to}', '{$type}', '{$sponsor}', '{$venue}');");
}

function updateTraining($no, $title, $from, $to, $type, $sponsor, $venue) {
  return nonQuery("UPDATE tbl_seminar SET Title_of_training='{$title}', covered_from='{$from}', covered_to='{$to}', Category='{$type}', conducted_by='{$sponsor}', TVenue='{$venue}' WHERE Training_Code='{$no}' LIMIT 1;");
}

function scheduledTrainings() {
  return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `Category` AS `type`, `conducted_by` AS `sponsor`, `TVenue` AS `venue` FROM tbl_seminar WHERE `covered_to` > NOW() ORDER BY `From` DESC, `To` DESC;");
}

function conductedTrainings() {
  return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `Category` AS `type`, `conducted_by` AS `sponsor`, `TVenue` AS `venue` FROM tbl_seminar WHERE `covered_to` < NOW() ORDER BY `From` DESC, `To` DESC;");
}

function trainingParticipants($no) {
  return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS status FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_seminar_participant ON tbl_employee.Emp_ID = tbl_seminar_participant.Emp_ID WHERE Training_Code='{$no}' ORDER BY tbl_employee.Emp_LName;");
}

function createTrainingParticipant($no, $id) {
  nonQuery("INSERT INTO tbl_seminar_participant (`Training_Code`, `Emp_ID`) VALUES ('{$no}', '{$id}');");
}

function deleteTrainingParticipant($no, $id) {
  nonQuery("DELETE FROM tbl_seminar_participant WHERE `Training_Code`='{$no}' AND `Emp_ID`='{$id};");
}

function isConductedTraining($no) {
  return numRows(query("SELECT `Training_Code` AS `no` FROM tbl_seminar WHERE `Training_Code`='{$no}' AND `covered_to` < NOW() LIMIT 1;")) > 0;
}

function isTrainingParticipant($no, $id) {
  return numRows(query("SELECT `Training_Code` AS `no`, `Emp_ID` AS `id` FROM tbl_seminar_participant WHERE `Training_Code`='{$no}' AND `Emp_ID`='{$id}' LIMIT 1;")) > 0;
}
?>