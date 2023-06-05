<?php
// modules/employees/delete/delete-child.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? $_GET['e'] : null;
$childId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('Are you sure you want to continue and delete this entry?', 'Delete Child?', 'delete-child', $employeeId, $childId);
?>