<?php
// modules/vacancies/delete-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/layout/components.php';

$vacancyId = $_GET['id'] ?? null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Vacancy?', 'delete-vacancy', $vacancyId);