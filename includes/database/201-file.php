<?php
// tbl_201_file
function fileAttachments($id) {
  return query("SELECT `No` AS `no`, `DateUpload` AS `datetime`, `Emp_ID` AS `id`, `description`, `filename` FROM tbl_201_file WHERE `Emp_ID`='{$id}' ORDER BY `datetime` ASC;");
}
?>