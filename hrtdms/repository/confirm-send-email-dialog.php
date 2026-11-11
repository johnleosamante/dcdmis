<?php
// hrtdms/repository/confirm-send-email-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['tid']) ? sanitize(decipher($_GET['tid'])) : null;
$participantId = isset($_GET['pid']) ? sanitize(decipher($_GET['pid'])) : null;
$title = 'Email Participant Certificate';
$message = 'Are you sure you want to continue and email certificate to this training participant?';

$training = trainingParticipants($trainingId, $participantId);

if (!$training) {
    $title = 'Training Participant Not Found';
    $message = 'Sorry we can not find the participant you selected. Please refresh the page and try again.';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($title) ?>
        <div class="modal-body">
            <?= $message ?>
        </div>
        <div class="modal-footer">
            <form action="" method="POST">
                <?= csrf_field();
                if ($training): ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['tid'] ?? null ?>">
                    <input type="hidden" name="data-verifier" value="<?= $_GET['pid'] ?>">
                    <button type="submit" class="btn btn-primary" name="confirm-email-participant">Yes, Continue</button>
                <?php endif;
                cancelModalButton() ?>
            </form>
        </div>
    </div>
</div>