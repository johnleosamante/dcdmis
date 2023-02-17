<?php
include_once('_includes_/config.php');
include_once('_includes_/database/database.php');

$stations = mysqli_query($con, "SELECT `No`, Emp_ID FROM tbl_station;");
$no = 0;

while ($station = mysqli_fetch_array($stations)) {
    $employee = mysqli_query($con, "SELECT Emp_ID FROM tbl_employee WHERE Emp_ID='" . $station['Emp_ID'] . "' LIMIT 1;");

    if (mysqli_num_rows($employee) === 0) {
        mysqli_query($con, "DELETE FROM tbl_station WHERE Emp_ID='" . $station['Emp_ID'] . "' LIMIT 1;");

        if (mysqli_affected_rows($con) === 1) {
            $no++;
            echo 'DELETED: ' . $no . ' : ' . $station['No'] . '<br>';
        }
    }
}
?>