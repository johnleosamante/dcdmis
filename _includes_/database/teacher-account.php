<?php
# _includes_/database/teacher-account.php

function GetTeacherAccount($email, $password='') {
  if (empty($password)) {
    $sql = "SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='$email' LIMIT 1;";
  } else {
    $sql =
    "SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='$email' AND Teacher_Password='$password' LIMIT 1;";
  }

  return DBQuery($sql);
}

function UpdateTeacherAccountPassword($email, $password) {
  DBNonQuery("UPDATE tbl_teacher_account SET Teacher_Password='$password' WHERE Teacher_TIN='$email' LIMIT 1;");
}

function InsertTeacherAccount($email, $password, $activity, $status, $lastLoginDateTime) {
  DBNonQuery("INSERT INTO tbl_teacher_account VALUES (NULL, '$email', '$password', '$activity', '$status', '$lastLoginDateTime');");
}
?>