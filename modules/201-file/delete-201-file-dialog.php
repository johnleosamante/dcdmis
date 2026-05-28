<?php
// modules/201-file/delete-201-file-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = $_GET['e'] ?? null;
$fileId = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete 201 File?', 'delete-201-file', $employeeId, $fileId);
