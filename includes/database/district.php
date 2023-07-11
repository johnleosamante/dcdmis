 <?php
// includes/database/district.php
// tbl_district
function district($id) {
  return query("SELECT District_code AS `id`, District_Name AS `name`, Emp_ID AS `psds` FROM tbl_district WHERE District_code='{$id}' LIMIT 1;");
}

function districts() {
  return query("SELECT District_code AS `id`, District_Name AS `name`, Emp_ID AS `psds` FROM tbl_district ORDER BY District_Name ASC;");
}

function districtSchoolCount($id) {
  return query("SELECT SUM(CASE WHEN tbl_school.School_Category='Elementary' THEN 1 ELSE 0 END) AS es, SUM(CASE WHEN tbl_school.School_Category='Secondary' THEN 1 ELSE 0 END) AS hs, SUM(CASE WHEN tbl_school.School_Category='Integrated' THEN 1 ELSE 0 END) AS `is`, COUNT(*) AS `total` FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_school.District_code='{$id}' LIMIT 1;");
}
?>