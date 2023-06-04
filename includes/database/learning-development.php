<?php
// includes/database/learning-development.php
// learning_and_development
function learningAndDevelopment($id) {
  return query("SELECT `No` AS `no`, Title_of_Training AS `title`, `From` AS `from`, `To` AS `to`, `Number_of_Hours` AS `hours`, `Managerial` AS `type`, `Conducted` AS `sponsor`, Emp_ID AS `id` FROM learning_and_development WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}
?>