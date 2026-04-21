<?php
// modules/employees/delete/delete-child-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Child?', 'delete-child', $_GET['e'] ?? null, $_GET['id'] ?? null);