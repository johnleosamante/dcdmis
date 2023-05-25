<?php
// includes/database/education.php

function education($id) {
  return query("SELECT `No` AS `no`, `Level` AS `level`, Name_of_School AS school, Course AS course, `From` AS `from`, `To` AS `to`, ispresent, Highest_Level AS highest, Year_Graduated AS year_graduated, Honor_Recieved AS scholarship, Emp_ID AS id FROM educational_background WHERE Emp_ID='{$id}' ORDER BY `From` ASC, `To` ASC;");
}

function educational_background($id, $no) {
  return query("SELECT `No` AS `no`, `Level` AS `level`, Name_of_School AS school, Course AS course, `From` AS `from`, `To` AS `to`, ispresent, Highest_Level AS highest, Year_Graduated AS year_graduated, Honor_Recieved AS scholarship, Emp_ID AS id FROM educational_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function create_education($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $id) {
  non_query("INSERT INTO educational_background (`Level`, `Name_of_School`, `Course`, `From`, `To`, `ispresent`, Highest_Level, Year_Graduated, Honor_Recieved, Emp_ID) VaLUES ('{$level}', '{$school}', '{$course}', '{$from}', '{$to}', '{$ispresent}', '{$highest}', '{$year}', '{$scholarship}', '{$id}');");
}

function update_education($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $id, $no) {
  non_query("UPDATE educational_background SET `Level`='{$level}', Name_of_School='{$school}', Course='{$course}', `From`='{$from}', `To`='{$to}', `ispresent`='{$ispresent}'Highest_Level='{$highest}', Year_Graduated='{$year}', Honor_Recieved='{$scholarship}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function delete_education($id, $no) {
  non_query("DELETE FROM educational_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>