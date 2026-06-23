<?php
// modules/race/delete-schedule-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');

$id = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this schedule?', 'Delete Schedule?', 'delete-schedule', $id);
