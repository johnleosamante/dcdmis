<?php
// includes/database/references.php

function references($id) {
  return query("SELECT `No` AS `no`, `Name` AS `name`, `Address` AS `address`, Tel_No AS `telephone`, `Emp_ID` AS `id` FROM reference WHERE Emp_ID='{$id}' ORDER BY `Name`;");
}
?>