<?php
// includes/database/section.php
// tbl_div_section

function section($id, $include_id = false) {
  $sql = "SELECT Section_Code AS id, Section_Office AS `name` FROM tbl_div_section";
  if (!$include_id) {
    $sql .= " WHERE Section_Code <> '{$id}' ORDER BY Section_Office ASC;";
  } else {
    $sql .= " WHERE Section_Code='{$id}' LIMIT 1;"; 
  }

  return query($sql);
}
?>