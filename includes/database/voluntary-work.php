<?php
// includes/database/voluntary_work.php

function voluntary_works($id) {
  return query("SELECT `No` AS `no`, Name_of_Organization AS organization, `From` AS `from`, `To` AS `to`, Number_of_Hour AS `hours`, Position AS `position`, Emp_ID AS id FROM voluntary_work WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}
?>