<?php
// includes/database/country.php
// tbl_country

function countries() {
  return query("SELECT country AS `name` FROM tbl_country ORDER BY country;");
}
?>