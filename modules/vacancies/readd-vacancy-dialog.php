<?php
// modules/vacancies/readd-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$pubId = $_GET['pub_id'] ?? null;
$vacancyId = $_GET['vacancy_id'] ?? null;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Re-add Position to Vacancies?') ?>

        <div class="modal-body">
            This action will add this vacant plantilla item position back to the pool of vacant positions for future
            Call for Applications without removing it from this closed call for application. Are you sure you want to
            continue?
        </div>

        <div class="modal-footer">
            <form action="" method="POST" role="form">
                <?= csrf_field(); ?>
                <input type="hidden" name="verifier" value="<?= e($pubId) ?>">
                <input type="hidden" name="data-verifier" value="<?= e($vacancyId) ?>">
                <button type="submit" class="btn btn-primary" name="readd-vacancy">Yes, Continue</button>
                <?php cancelModalButton() ?>
            </form>
        </div>
    </div>
</div>