<?php
// includes/database/recognition.php

function recognitions($id) {
  return query("SELECT `No` AS `no`, Recognition AS `recognition`, Emp_ID AS id FROM tbl_recognition WHERE Emp_ID='{$id}' ORDER BY Recognition;");
}
?>