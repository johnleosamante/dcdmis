<?php
// modules/race/save-award-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$modalTitle = 'Add New Recognition Award';
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="category_id" class="mb-1 text-dark small font-weight-bold text-uppercase">Award Category <?php showAsterisk() ?></label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category...</option>
                        <?php
                        $categories = recognitionCategories();
                        foreach ($categories as $cat): ?>
                            <option value="<?= e($cat['id']) ?>">
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="award_name" class="mb-1 text-dark small font-weight-bold text-uppercase">Award Name <?php showAsterisk() ?></label>
                    <input type="text" id="award_name" name="award_name" class="form-control" placeholder="Enter award name..." required>
                </div>

                <?php requiredLegend() ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="save-recognition-award" type="submit">Save Award</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
