<?php
// modules/call-for-submission/save-call-for-submission-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/call-for-submission.php');
require_once(root() . '/includes/layout/components.php');

$callSubmissionId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$callSubmission = callForSubmission($callSubmissionId);
$title = $description = $school_year = null;
$due_date = date('Y-m-d');
$modalTitle = 'New Call for Submission';

if ($callSubmission) {
    $modalTitle = $callSubmissionId === $copiedId ? 'Copy Call for Submission' : 'Edit Call for Submission';
    $title = $callSubmission['title'];
    $description = $callSubmission['description'];
    $school_year = $callSubmission['school_year'];
    $due_date = toDate($callSubmission['due_date'], 'Y-m-d');
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="type" class="mb-0">Title <?php showAsterisk() ?></label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= e($title) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description" class="mb-0">Description</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="3"><?= e($description) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="school_year" class="mb-0">School Year <?php showAsterisk() ?></label>
                            <input type="text" name="school_year" id="school_year" class="form-control"
                                value="<?= e($school_year) ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="due_date" class="mb-0">Date Due <?php showAsterisk() ?></label>
                            <input type="date" name="due_date" id="due_date" class="form-control"
                                value="<?= e($due_date) ?>" required>
                        </div>
                    </div>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <button class="btn btn-primary" name="save-call-for-submission" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>