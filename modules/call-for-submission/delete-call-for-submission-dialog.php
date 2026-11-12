<?php
// modules/call-for-submission/delete-call-for-submission-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/call-for-submission.php');
require_once(root() . '/includes/layout/components.php');

$cfsId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$cfs = $cfsId ? callForSubmission((int) $cfsId) : null;

if (!$cfs) {
    modalConfirmDelete('Record not found.');
    return;
}

$subCount = countProgramSubmissions((int) $cfs['id']);

modalConfirmDelete(
    'This action will permanently delete this call for application: ' . strtoupper(e($cfs['title'])) . '.'
    . ($subCount > 0
        ? " This will also delete all submissions and attached files."
        : '') . ' Are you sure you want to continue?',
    'Delete Call for Submission',
    'delete-call-for-submission',
    cipher($cfs['id'])
);