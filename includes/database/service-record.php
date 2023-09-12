<?php
// tbl_service_records
function serviceRecords($id) {
  return query("SELECT `No` AS `no`, `date_from` AS `from`, `date_to` AS `to`, `position`, `work_status` AS `status`, `salary`, `station`, `Emp_ID` AS `id` FROM `tbl_service_records` WHERE `Emp_ID`='{$id}' ORDER BY `date_from` ASC;");
}
?>