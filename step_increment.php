<?php
include_once('_includes_/config.php');
include_once('_includes_/database/database.php');

mysqli_query($con, "UPDATE tbl_step_increment SET Date_last_step='1', Step_No='1', No_of_year='0';");
?>