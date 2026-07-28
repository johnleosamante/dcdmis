<?php
// modules/trainings/save-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employeeId = isset($_GET['p']) ? sanitize(decipher($_GET['p'])) : null;

$training = training($trainingId);
$modalTitle = 'Training not found';
$numberOfParticipants = 0;
$notFound = true;
$trainingParticipants = null;

if ($training) {
    $modalTitle = isset($employeeId) ? 'Email Participant' : 'Email All Participants';
    $trainingId = $training['id'];
    $notFound = false;
}
?>

<div class="modal-dialog <?= $notFound ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <div class="modal-body">
            <?php if (!$notFound) {
                $trainingParticipants = trainingParticipants($trainingId, $employeeId);
                $numberOfParticipants = count($trainingParticipants);
                if ($numberOfParticipants > 0) {
                    if ($numberOfParticipants === 1) {
                        echo 'Are you sure you want to continue to send email to this participant?';
                    } else {
                        echo "Are you sure you want to continue to send email to all {$numberOfParticipants} participants?";
                    } ?>

                    <div class="mt-2 p-2 text-light bg-secondary rounded">
                        <?php if ($numberOfParticipants > 1): ?>
                            <ol class="mb-0">
                                <?php foreach ($trainingParticipants as $participant): ?>
                                    <li><?= strtoupper(toName($participant['last_name'], $participant['first_name'], $participant['middle_name'], $participant['name_extension'])) ?>
                                    </li>
                                <?php endforeach ?>
                            </ol>
                        <?php else: ?>
                            <?php foreach ($trainingParticipants as $participant): ?>
                                <div class="m-0 pl-3">
                                    <?= strtoupper(toName($participant['last_name'], $participant['first_name'], $participant['middle_name'], $participant['name_extension'])) ?>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                <?php }
            } else {
                missingAlert($modalTitle);
            } ?>
        </div>

        <div class="modal-footer">
            <?php if (!$notFound): ?>
                <form action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                    <?php if (isset($_GET['p'])): ?>
                        <input type="hidden" name="data-verifier" value="<?= e($_GET['p']) ?>">
                    <?php endif ?>
                    <button class="btn btn-primary" name="email-participants" type="submit">Yes, Continue</button>
                <?php endif;
            cancelModalButton();
            if (!$notFound): ?>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>