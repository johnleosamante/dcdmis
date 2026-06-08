<?php
// modules/vacancies/disqualify-application-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$applicationId = $_GET['id'] ?? null;

modalConfirmDelete(
    'This action will disqualify the applicant from this position. Are you sure you want to continue?',
    'Disqualify Application?',
    'disqualify-application',
    $applicationId
);