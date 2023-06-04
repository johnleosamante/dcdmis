<?php
// includes/database/document.purpose.php
// tbl_document_purpose
function documentPurpose() {
  return query("SELECT `purpose` FROM tbl_document_purpose;");
}
?>