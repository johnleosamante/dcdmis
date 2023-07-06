<?php
// includes/database/nationality.php
// tbl_nationality

function nationalities() {
  return query("SELECT nationality AS `name` FROM tbl_nationality ORDER BY nationality;");
}
?>