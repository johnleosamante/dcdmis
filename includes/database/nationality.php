<?php
// includes/database/nationality.php
// tbl_nationality

function nationalities() {
  return query("SELECT id, nationality AS `name` FROM tbl_nationality ORDER BY nationality;");
}

function nationality($id) {
  return query("SELECT id, nationality AS `name` FROM tbl_nationality WHERE id='{$id}';");
}
?>