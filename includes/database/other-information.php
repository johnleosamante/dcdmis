<?php
// includes/database/other-information.php
// tbl_other_information
function otherInformation($id) {
  return query("SELECT * FROM tbl_other_information WHERE Emp_ID='{$id}' LIMIT 1;");
}
?>