<?php
// modules/positions/delete-position-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

modalConfirmDelete('This operation cannot be undone. Are you sure you want to permanently delete this position?', 'Delete Position?', 'delete-position', $_GET['id'] ?? null);