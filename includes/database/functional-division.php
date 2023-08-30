<?php
// includes/database/functional-division.php
// tbl_functional_division
function functionalDivisions() {
  return query("SELECT Div_Code AS id, Division_Name AS `name` FROM tbl_division ORDER BY `name` ASC;");
}

function functionalDivision($id) {
  return query("SELECT Div_Code AS id, Division_Name AS `name` FROM tbl_division WHERE Div_Code='{$id}' LIMIT 1;");
}
?>