<?php
// includes/database/special-skill.php
// tbl_special_skills
function specialSkills($id) {
  return query("SELECT `No` AS `no`, Special_Skills AS skill, Emp_ID AS id FROM tbl_special_skills WHERE Emp_ID='{$id}' ORDER BY Special_Skills;");
}
?>