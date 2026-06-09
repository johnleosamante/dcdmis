<?php
// modules/vacancies/disqualify-application-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$applicationId = $_GET['id'] ?? null;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Disqualify Application?') ?>

        <form action="" method="POST" role="form">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <p>This action will disqualify the applicant from this position. Are you sure you want to continue?</p>
                <div class="form-group mb-2">
                    <label for="remarks" class="mb-0">Remarks
                        <?php showAsterisk() ?>
                    </label>
                    <textarea id="remarks" name="remarks" class="form-control mt-1" rows="3" required autofocus
                        placeholder="Type remarks..." title="Type disqualification remarks..."></textarea>
                </div>
                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($applicationId) ?>">
                <button class="btn btn-danger" name="disqualify-application" type="submit">Yes, Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>