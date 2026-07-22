<?php
// modules/race/save-award-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$awardId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$modalTitle = 'Add New Recognition Award';
$category_id = '';
$award_name = '';
$has_level = 0;
$buttonName = 'save-recognition-award';
$buttonLabel = 'Save Award';

if ($awardId) {
    $modalTitle = 'Edit Recognition Award';
    $award = recognitionAward($awardId);
    if ($award) {
        $category_id = $award['category_id'];
        $award_name = $award['name'];
        $has_level = (int)$award['has_level'];
    }
    $buttonName = 'edit-recognition-award';
    $buttonLabel = 'Update Award';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($scheduleId): ?>
                    <input type="hidden" name="schedule_id" value="<?= e($scheduleId) ?>">
                <?php endif; ?>
                <?php if ($awardId): ?>
                    <input type="hidden" name="verifier" value="<?= e($_GET['id']) ?>">
                <?php endif; ?>
                <div class="form-group mb-3">
                    <label for="category_id" class="mb-1 text-dark small font-weight-bold text-uppercase">Award Category <?php showAsterisk() ?></label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category...</option>
                        <?php
                        $categories = recognitionCategories();
                        foreach ($categories as $cat): ?>
                            <option value="<?= e($cat['id']) ?>" <?= setOptionSelected($cat['id'], $category_id) ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="award_name" class="mb-1 text-dark small font-weight-bold text-uppercase">Award Name <?php showAsterisk() ?></label>
                    <input type="text" id="award_name" name="award_name" class="form-control" placeholder="Enter award name..." value="<?= e($award_name) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="has_level" name="has_level" value="1" <?= $has_level ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="has_level">Has Level (Elementary / Secondary / Integrated)</label>
                    </div>
                </div>

                <?php requiredLegend() ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="<?= e($buttonName) ?>" type="submit"><?= e($buttonLabel) ?></button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
