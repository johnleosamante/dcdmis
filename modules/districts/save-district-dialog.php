<?php
// modules/districts/save-district-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/layout/components.php');

$districtCode = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$district = district($districtCode);
$districtName = $districtHead = null;
$modalTitle = 'Add District';
$notFound = true;

if ($district) {
    $districtName = $district['name'];
    $districtHead = $district['supervisor_id'];
    $modalTitle = 'Edit District';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="code" class="mb-0">Alias <?php showAsterisk() ?></label>
                    <input type="text" id="code" name="code" class="form-control" placeholder="Type alias..."
                        title="Type district alias.." minlength="3" maxlength="5" value="<?= e($districtCode) ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="district" class="mb-0">Name <?php showAsterisk() ?></label>
                    <input type="text" id="district" name="district" class="form-control" placeholder="Type name..."
                        title="Type district name..." value="<?= e($districtName) ?>" required>
                </div>

                <div class="form-group">
                    <label for="head" class="mb-0">District Supervisor <?php showAsterisk() ?></label>
                    <select id="head" name="head" class="form-control" title="Select district supervisor..." required>
                        <option value="">Select district supervisor...</option>

                        <?php $employees = districtSupervisors();
                        foreach ($employees as $employee): ?>
                            <option value="<?= e($employee['id']) ?>"
                                title="<?= position($employee['id'])['official_title'] ?>"
                                <?= setOptionSelected($employee['id'], $districtHead) ?>>
                                <?= userName($employee['id'], true) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <button class="btn btn-primary" name="save-district" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>