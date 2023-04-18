<?php
// includes/database/section.php
// tbl_div_section

function sections_except($id) {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section WHERE Section_Code <> '{$id}' ORDER BY Section_Office ASC;");
}

function sections() {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section ORDER BY Section_Office ASC;");
}

function section($id) {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section WHERE Section_Code='{$id}' LIMIT 1;");
}
?>