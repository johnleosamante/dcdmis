<?php
// includes/database/other-information.php

function other_information($id) {
  return query("SELECT * FROM tbl_other_information WHERE Emp_ID='{$id}' LIMIT 1;");
}
?>