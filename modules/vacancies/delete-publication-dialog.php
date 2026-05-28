<?php
// modules/vacancies/delete-publication-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Publication?', 'delete-publication', $_GET['id'] ?? null);