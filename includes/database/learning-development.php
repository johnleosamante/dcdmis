<?php
// includes/database/learning-development.php
// learning_and_development
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
?>