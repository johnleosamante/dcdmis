<?php
// includes/database/section.php
// tbl_div_section
function sectionsExcept($id) {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section WHERE Section_Code <> '{$id}' ORDER BY Section_Office ASC;");
}

function sections() {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section ORDER BY Section_Office ASC;");
}

function section($id) {
  return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name` FROM tbl_div_section WHERE Section_Code='{$id}' LIMIT 1;");
}

function sectionEmployeeCount($id) {
  return query("SELECT SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS male, SUM(CASE WHEN tbl_employee.Emp_Sex='Female' THEN 1 ELSE 0 END) AS female, COUNT(*) AS `total` FROM tbl_employee INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode INNER JOIN tbl_div_section ON tbl_user.Station=tbl_div_section.Section_Code WHERE tbl_employee.Emp_Status='Active' AND tbl_user.Station='{$id}' GROUP BY tbl_div_section.Section_Office;");
}
?>