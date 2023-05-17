<?php
// includes/database/children.php

function children($id) {
  return query("SELECT `No` AS `no`, Family_Name AS `last`, First_Name AS `first`, Name_Extension AS ext, Middle_Name AS middle, Birthdate AS dob, Emp_ID AS id FROM family_background WHERE Emp_ID='{$id}' ORDER BY Birthdate ASC;");
}

function child($id, $no) {
  return query("SELECT `No` AS `no`, Family_Name AS `last`, First_Name AS `first`, Name_Extension AS ext, Middle_Name AS middle, Birthdate AS dob, Emp_ID AS id FROM family_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function create_child($lname, $fname, $ext, $mname, $dob, $id) {
  non_query("INSERT INTO family_background (Family_Name, First_Name, Name_Extension, Middle_Name, Birthdate, Emp_ID) VALUES ('{$lname}', '{$fname}', '{$ext}', '{$mname}', '{$dob}', '{$id}');");
}

function update_child($lname, $fname, $ext, $mname, $dob, $id, $no) {
  non_query("UPDATE family_background SET Family_Name='{$lname}', First_Name='{$fname}', Name_Extension='{$ext}', Middle_Name='{$mname}', Birthdate='{$dob}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function delete_child($id, $no) {
  non_query("DELETE FROM family_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>