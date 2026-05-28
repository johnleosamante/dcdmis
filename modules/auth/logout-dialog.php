<?php
// logout/logout-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$modalTitle = 'Logout';
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
        </div>

        <div class="modal-footer">
            <form action="<?= "{$baseUri}/modules/auth" ?>">
                <?= csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Continue</button>
            </form>
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>