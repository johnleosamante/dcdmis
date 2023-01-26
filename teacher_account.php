<?php
include_once('_includes_/config.php');
include_once('_includes_/database/database.php');

$emails = mysqli_query($con, "SELECT Emp_Email FROM tbl_employee ORDER BY Emp_Email;");
$no = 0;

while ($email = mysqli_fetch_array($emails)) {
  $teacher_email = mysqli_query($con, "SELECT Teacher_TIN FROM tbl_teacher_account WHERE  Teacher_TIN='" . $email['Emp_Email'] . "' LIMIT 1;");

  if (mysqli_num_rows($teacher_email) === 0) {
    mysqli_query($con, "INSERT INTO tbl_teacher_account (Teacher_TIN, Teacher_Password, Teacher_status, Pass_status, Last_login) VALUES ('" . $email['Emp_Email'] . "', 'bcd054ee8eee7daecf0225ac909db59e', 'Offline', 'Default', '2023-01-26 12:00:00');");

    if (mysqli_affected_rows($con)) {
      $no++;
      echo $no . ' - ' . $email['Emp_Email'] . '<br>';
    }
  }
}
?>