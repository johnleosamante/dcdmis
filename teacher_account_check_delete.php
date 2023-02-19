<?php
include_once('_includes_/config.php');
include_once('_includes_/database/database.php');

$stations = mysqli_query($con, "SELECT Teacher_TIN FROM tbl_teacher_account;");
$no = 0;

while ($station = mysqli_fetch_array($stations)) {
    $employee = mysqli_query($con, "SELECT Emp_Email FROM tbl_employee WHERE Emp_Email='" . $station['Teacher_TIN'] . "' LIMIT 1;");

    if (mysqli_num_rows($employee) === 0) {
        mysqli_query($con, "DELETE FROM tbl_teacher_account WHERE Teacher_TIN='" . $station['Teacher_TIN'] . "' LIMIT 1;");

        if (mysqli_affected_rows($con) === 1) {
            $no++;
            echo 'DELETED: ' . $no . ' : ' . $station['Teacher_TIN'] . '<br>';
        }
    }
}
?>