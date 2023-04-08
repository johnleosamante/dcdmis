<?php
// includes/database/employee.php
function employee($id) {
  return query("SELECT Emp_LName AS lname, Emp_FName AS fname, Emp_MName AS mname, Emp_Extension AS ext, Picture AS picture FROM tbl_employee WHERE Emp_ID='{$id}' LIMIT 1;");
}
?>