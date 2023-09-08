<?php
// includes/database/account.php
// tbl_employee
// tbl_teacher_account
// tbl_user
function account($email) {
  return query("SELECT `Emp_ID` AS `id`, `Emp_Email` AS `email` FROM `tbl_employee` WHERE `Emp_Status`='Active' AND `Emp_Email`='{$email}' LIMIT 1;");
}

function accountPassword($id, $password) {
  return query("SELECT `Teacher_TIN` AS `id` FROM tbl_teacher_account WHERE `Teacher_TIN`='{$id}' AND Teacher_Password='{$password}';");
}

function createAccount($id, $password) {
  nonQuery("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`) VALUES ('$id', '$password');");
}

function updateAccountPassword($id, $password) {
  nonQuery("UPDATE tbl_teacher_account SET Teacher_Password='{$password}' WHERE Teacher_TIN='{$id}' LIMIT 1;");
}
?>