<?php
// modules/vacancies/readd-all-vacancies-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$pubId = $_GET['id'] ?? null;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Re-add All Unfilled Positions to Vacancies?') ?>

        <div class="modal-body">
            This action will re-add all vacant plantilla item positions in this closed Call for Application that have no
            qualified applicants back into the pool of vacant positions for future Call for Applications. Are you sure
            you want to proceed?
        </div>

        <div class="modal-footer">
            <form action="" method="POST" role="form">
                <?= csrf_field(); ?>
                <input type="hidden" name="verifier" value="<?= e($pubId) ?>">
                <button type="submit" class="btn btn-primary" name="readd-all-vacancies"><i
                        class="fas fa-plus-circle mr-1"></i> Yes, Continue</button>
                <?php cancelModalButton() ?>
            </form>
        </div>
    </div>
</div>