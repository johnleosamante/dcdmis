<?php
// modules/race/save-category-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Add New Award Category'); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="category_name" class="mb-1 text-dark small font-weight-bold text-uppercase">Category Name <?php showAsterisk() ?></label>
                    <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Enter category name..." required>
                </div>
                <?php requiredLegend() ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="save-recognition-category" type="submit">Save Category</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
