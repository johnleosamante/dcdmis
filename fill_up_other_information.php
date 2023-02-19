<?php
include_once('_includes_/config.php');
include_once('_includes_/database/database.php');

$employees = mysqli_query($con, "SELECT Emp_ID FROM tbl_employee;");
$no = 0;

while ($employee = mysqli_fetch_array($employees)) {
    mysqli_query($con, "INSERT INTO tbl_other_information (id, Emp_ID) VALUES (NULL, '" . $employee['Emp_ID'] . "');");

    if (mysqli_affected_rows($con)) {
      $no++;
      echo $no . ' - ' . $employee['Emp_ID'] . '<br>';
    }
}
