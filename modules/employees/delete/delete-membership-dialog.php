<?php
// modules/employees/delete/delete-membership-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = $_GET['e'] ?? null;
$membershipId = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Membership?', 'delete-membership', $employeeId, $membershipId);