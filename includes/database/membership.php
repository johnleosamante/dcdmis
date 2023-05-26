<?php
// includes/database/membership.php

function memberships($id) {
  return query("SELECT `No` AS `no`, Organization AS `organization`, Emp_ID AS id FROM tbl_membership WHERE Emp_ID='{$id}' ORDER BY Organization;");
}
?>