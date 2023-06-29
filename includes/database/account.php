<?php
// includes/database/account.php
// tbl_employee
// tbl_teacher_account
// tbl_user
function account($email, $password=null) {
  $sql = "SELECT `tbl_employee`.`Emp_ID` AS `id`, `tbl_teacher_account`.`Teacher_TIN` AS `email`, `tbl_employee`.`Emp_Status` AS `status` FROM `tbl_teacher_account` JOIN `tbl_employee` ON `tbl_teacher_account`.`Teacher_TIN` = `tbl_employee`.`Emp_Email` WHERE `tbl_employee`.`Emp_Status`='Active' AND `tbl_teacher_account`.`Teacher_TIN`='{$email}'";

  if ($password === null) {
    $sql .= " LIMIT 1;";
  } else {
    $sql .= " AND `tbl_teacher_account`.`Teacher_Password`='{$password}' LIMIT 1;";
  }

  return query($sql);
}

function createAccount($email, $password) {
  nonQuery("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`) VALUES ('$email', '$password');");
}

function updateAccountPassword($email, $password) {
  nonQuery("UPDATE tbl_teacher_account SET Teacher_Password='{$password}' WHERE Teacher_TIN='{$email}' LIMIT 1;");
}

function updateAccountEmail($newEmail, $oldEmail) {
  nonQuery("UPDATE tbl_teacher_account SET Teacher_TIN='{$newEmail}' WHERE Teacher_TIN='{$oldEmail}' LIMIT 1;");
}

function updateUserRoleEmail($email, $id) {
  nonQuery("UPDATE tbl_user SET username='{$email}' WHERE usercode='{$id}';");
}
?>