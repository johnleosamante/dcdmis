<?php
// modules/employees/delete/delete-learning-development.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = isset($_GET['e']) ? $_GET['e'] : null;
$learningId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('Are you sure you want to continue and delete this entry?', 'Delete Learning &amp; Development?', 'delete-learning-development', $employeeId, $learningId);
?>