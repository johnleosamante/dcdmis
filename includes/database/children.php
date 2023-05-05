<?php
// includes/database/children.php

function children($id) {
  return query("SELECT `No` AS `no`, Family_Name AS `last`, First_Name AS `first`, Name_Extension AS ext, Middle_Name AS middle, Birthdate AS dob, Emp_ID AS id FROM family_background WHERE Emp_ID='{$id}' ORDER BY Birthdate ASC;");
}
?>