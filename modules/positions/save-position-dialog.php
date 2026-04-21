<?php
// modules/positions/save-position-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/layout/components.php';
require_once root() . '/includes/string.php';

$positionId = sanitize(decipher($_GET['id'] ?? null));
$copiedId = sanitize(decipher($_GET['c'] ?? null));
$official_title = $salary_grade = $category = null;
$modalTitle = 'Add Position';

if ($positionId) {
    $modalTitle = $positionId === $copiedId ? 'Copy Position' : 'Edit Position';
    $position = positions($positionId);

    if ($position) {
        $positionId = $position['id'];
        $official_title = $position['official_title'];
        $salary_grade = $position['salary_grade'];
        $category = $position['category'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="position-id" class="mb-0">Code <?php showAsterisk() ?>
                    </label>
                    <input type="text" id="position-id" name="position-id" class="form-control"
                        value="<?= e($positionId) ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="official-title" class="mb-0">Official Title <?php showAsterisk() ?></label>
                    <input type="text" id="official-title" name="official-title" class="form-control"
                        value="<?= e($official_title) ?>" required>
                </div>

                <div class="form-group">
                    <label for="salary-grade" class="mb-0">Salary Grade <?php showAsterisk() ?>
                    </label>
                    <input type="number" id="salary-grade" name="salary-grade" class="form-control"
                        value="<?= e($salary_grade) ?>" min="1" max="33" required>
                </div>

                <div class="form-group">
                    <label for="category" class="mb-0">Category <?php showAsterisk() ?></label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">Select category...</option>
                        <option value="Teaching" <?= setOptionSelected('Teaching', $category) ?>>Teaching
                        </option>
                        <option value="Teaching-Related" <?= setOptionSelected('Teaching-Related', $category) ?>>
                            Teaching-Related</option>
                        <option value="Non-Teaching" <?= setOptionSelected('Non-Teaching', $category) ?>>
                            Non-Teaching</option>
                    </select>
                </div>

                <?php requiredLegend(0) ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['id'] ?? null ?>">
                <button class="btn btn-primary" name="save-position" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>