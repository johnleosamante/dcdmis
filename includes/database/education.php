<?php
// includes/database/education.php

function education($id) {
  return query("SELECT `No` AS `no`, `Level` AS `level`, Name_of_School AS school, Course AS course, `From` AS `from`, `To` AS `to`, Highest_Level AS highest, Year_Graduated AS year_graduated, Honor_Recieved AS scholarship, Emp_ID AS id FROM educational_background WHERE Emp_ID='{$id}' ORDER BY `From` ASC, `To` ASC;");
}
?>