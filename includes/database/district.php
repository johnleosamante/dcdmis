<?php
// includes/database/district.php
// tbl_district
function district($id) {
  return query("SELECT District_Name AS `name`, Emp_ID AS `psds` FROM tbl_district WHERE District_code='{$id}' LIMIT 1;");
}
?>