<?php
// modules/vacancies/qualify-application-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$applicationId = $_GET['id'] ?? null;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Qualify Application?') ?>

        <div class="modal-body">
            This action will qualify the applicant for this position. Are you sure you want to continue?
        </div>

        <div class="modal-footer">
            <form action="" method="POST" role="form">
                <?= csrf_field(); ?>
                <input type="hidden" name="verifier" value="<?= e($applicationId) ?>">
                <button type="submit" class="btn btn-primary" name="qualify-application">Yes, Continue</button>
                <?php cancelModalButton() ?>
            </form>
        </div>
    </div>
</div>