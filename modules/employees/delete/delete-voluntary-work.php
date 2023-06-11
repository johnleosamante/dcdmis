<?php
// modules/employees/delete/delete-voluntary-work.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = isset($_GET['e']) ? $_GET['e'] : null;
$voluntaryId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('Are you sure you want to continue and delete this entry?', 'Delete Voluntary Work?', 'delete-voluntary-work', $employeeId, $voluntaryId);
?>