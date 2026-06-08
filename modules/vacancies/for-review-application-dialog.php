<?php
// modules/vacancies/for-review-application-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$applicationId = $_GET['id'] ?? null;

modalConfirmDelete(
    'This action will mark the applicant application back to For Review status. Are you sure you want to continue?',
    'Mark Application For Review?',
    'for-review-application',
    $applicationId
);
