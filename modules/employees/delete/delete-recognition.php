<?php
// modules/employees/delete/delete-recognition.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/layout/components.php');

$employeeId = isset($_GET['e']) ? $_GET['e'] : null;
$recognitionId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('Are you sure you want to continue and delete this entry?', 'Delete Recognition?', 'delete-recognition', $employeeId, $recognitionId);
