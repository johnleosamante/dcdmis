<?php
// modules/employees/delete/delete-special-skills-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = $_GET['e'] ?? null;
$skillId = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Special Skill / Hobby?', 'delete-special-skill', $employeeId, $skillId);