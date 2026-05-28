<?php
// modules/plantilla/delete-plantilla-item-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

modalConfirmDelete('This operation cannot be undone. Are you sure you want to permanently delete this plantilla item from the system?', 'Delete Plantilla Item?', 'delete-plantilla-item', $_GET['id'] ?? null);