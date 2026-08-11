<?php
// modules/applicants/delete-applicant-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$applicantId = $_GET['id'] ?? null;

modalConfirmDelete('This action will permanently remove this external applicant record. Are you sure you want to continue?', 'Delete External Applicant?', 'delete-applicant', $applicantId);
