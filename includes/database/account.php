<?php
// includes/database/account.php
// tbl_employee
// tbl_teacher_account

function account($email, $password=null) {
  $sql = "SELECT `tbl_employee`.`Emp_ID` AS `id`, `tbl_teacher_account`.`Teacher_TIN` AS `email`, `tbl_employee`.`Emp_Status` AS `status` FROM `tbl_teacher_account` JOIN `tbl_employee` ON `tbl_teacher_account`.`Teacher_TIN` = `tbl_employee`.`Emp_Email` WHERE `tbl_teacher_account`.`Teacher_TIN`='{$email}'";

  if ($password === null) {
    $sql .= " LIMIT 1;";
  } else {
    $sql .= " AND `tbl_teacher_account`.`Teacher_Password`='{$password}' LIMIT 1;";
  }

  return query($sql);
}
?>