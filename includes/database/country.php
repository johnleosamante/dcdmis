<?php
// includes/database/country.php
// tbl_country

function countries() {
  return query("SELECT id, country AS `name` FROM tbl_country ORDER BY country;");
}

function country($id) {
  return query("SELECT id, country AS `name` FROM tbl_country WHERE id='{$id}';");
}
?>