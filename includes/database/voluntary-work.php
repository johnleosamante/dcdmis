<?php
// includes/database/voluntary_work.php

function voluntary_works($id) {
  return query("SELECT `No` AS `no`, Name_of_Organization AS organization, `From` AS `from`, `To` AS `to`, ispresent, Number_of_Hour AS `hours`, Position AS `position`, Emp_ID AS id FROM voluntary_work WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function voluntary_work($id, $no) {
  return query("SELECT `No` AS `no`, Name_of_Organization AS organization, `From` AS `from`, `To` AS `to`, ispresent, Number_of_Hour AS `hours`, Position AS `position`, Emp_ID AS id FROM voluntary_work WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function create_voluntary_work($organization, $from, $to, $ispresent, $hours, $position, $id) {
  non_query("INSERT INTO voluntary_work (Name_of_Organization, `From`, `To`, ispresent, Number_of_Hour, Position, Emp_ID) VALUES ('{$organization}', '{$from}', '{$to}', '{$ispresent}', '{$hours}', '{$position}', '{$id}');");
}

function update_voluntary_work($organization, $from, $to, $ispresent, $hours, $position, $id, $no) {
  non_query("UPDATE voluntary_work SET Name_of_Organization='{$organization}', `From`='{$from}', `To`='{$to}', ispresent='{$ispresent}', Number_of_Hour='{$hours}', Position='{$position}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function delete_voluntary_work($id, $no) {
  non_query("DELETE FROM voluntary_work WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>