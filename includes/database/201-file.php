<?php
// tbl_201_file
function fileAttachments($id) {
  return query("SELECT `No` AS `no`, `DateUpload` AS `datetime`, `description`, `filename` FROM tbl_201_file WHERE `Emp_ID`='{$id}' ORDER BY `datetime` ASC;");
}

function fileAttachment($id, $no) {
  return query("SELECT `No` AS `no`, `DateUpload` AS `datetime`, `description`, `filename` FROM tbl_201_file WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createFileAttachment($description, $filename, $id) {
  nonQuery("INSERT INTO tbl_201_file (`DateUpload`, `description`, `filename`, `Emp_ID`) VALUES (NOW(), '{$description}', '{$filename}', '{$id}');");
}

function updateFileAttachment($description, $filename, $id, $no) {
  nonQuery("UPDATE tbl_201_file SET `DateUpload`=NOW(), `description`='{$description}', `filename`='{$filename}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteFileAttachment($id, $no) {
  nonQuery("DELETE FROM tbl_201_file WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>