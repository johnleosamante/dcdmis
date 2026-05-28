<?php
// modules/employees/delete/delete-recognition-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = $_GET['e'] ?? null;
$recognitionId = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Recognition?', 'delete-recognition', $employeeId, $recognitionId);