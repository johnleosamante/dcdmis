<?php
// modules/call-for-submission/close-call-for-submission-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/call-for-submission.php');
require_once(root() . '/includes/layout/components.php');

$callSubmissionId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$callSubmission = callForSubmission($callSubmissionId);
$title = 'Reopen Call for Submission';
$message = 'Reopening this call for submission will enable uploading or updating of submitted data. Are you sure you want to continue?';

if (!$callSubmission) {
    $title = 'Call for Submission Not Found';
    $message = 'Sorry we can not find the call for submission you selected. Please refresh the page and try again.';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($title); ?>
        <div class="modal-body">
            <?= $message ?>
        </div>

        <div class="modal-footer">
            <form action="" method="POST">
                <?= csrf_field();
                if ($callSubmission): ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?? null ?>">
                    <button class="btn btn-primary" name="reopen-call-for-submission" type="submit">Yes, Continue</button>
                <?php endif;
                cancelModalButton() ?>
            </form>
        </div>
    </div>
</div>