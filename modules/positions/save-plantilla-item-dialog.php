<?php
// modules/plantilla/save-plantilla-item-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/plantilla.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$plantillaId = sanitize(decipher($_GET['id'] ?? null));
$copiedId = sanitize(decipher($_GET['c'] ?? null));
$item_number = $employment_status = $position_id = $station_id = $is_dissolve = null;
$modalTitle = 'Add Plantilla Item';

if ($plantillaId) {
    $modalTitle = $plantillaId === $copiedId ? 'Copy Plantilla Item' : 'Edit Plantilla Item';
    $plantilla = plantillaItem($plantillaId);

    if ($plantilla) {
        $item_number = $plantilla['item_number'];
        $employment_status = $plantilla['employment_status'];
        $position_id = $plantilla['position_id'];
        $station_id = $plantilla['station_id'];
        $is_dissolve = $plantilla['is_dissolve'];
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
                    <label for="item-number" class="mb-0">Item Number <?php showAsterisk() ?></label>
                    <input type="text" id="item-number" name="item-number" class="form-control"
                        value="<?= e($item_number) ?>" placeholder="Enter item number" required>
                    <small class="form-text text-muted">Must be unique across the system</small>
                </div>

                <div class="form-group">
                    <label for="position" class="mb-0">Position <?php showAsterisk() ?></label>
                    <select id="position" name="position" class="form-control" title="Select employee position..."
                        required>
                        <option value="">Select position...</option>
                        <?php
                        $categories = positionCategories();
                        foreach ($categories as $category): ?>
                            <optgroup label="<?= e($category['category']) ?>">
                                <?php $jobPositions = positionsByCategory($category['category']);
                                foreach ($jobPositions as $jobPosition): ?>
                                    <option value="<?= e($jobPosition['id']) ?>" <?= setOptionSelected($jobPosition['id'], $position_id) ?>><?= e($jobPosition['official_title']) ?>
                                    </option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station <?php showAsterisk() ?></label>
                    <select id="station" name="station" class="form-control" title="Select employee station..."
                        required>
                        <option value="">Select station...</option>
                        <?php
                        $districts = districts();
                        foreach ($districts as $district): ?>
                            <optgroup label="<?= e($district['name']) ?>">
                                <?php
                                $schools = schoolsByDistrict($district['id']);
                                foreach ($schools as $school): ?>
                                    <option value="<?= e($school['id']) ?>" <?= setOptionSelected($school['id'], $station_id) ?>>
                                        <?= e($school['name']) ?>
                                    </option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label for="employment-status" class="mb-0">Employment Status <?php showAsterisk() ?></label>
                    <select id="employment-status" name="employment-status" class="form-control" required>
                        <option value="">Select employment status...</option>
                        <?php
                        $employmentStatuses = ['permanent', 'temporary', 'contractual', 'casual', 'coterminus'];
                        foreach ($employmentStatuses as $status): ?>
                            <option value="<?= e($status) ?>" <?= setOptionSelected($status, $employment_status) ?>>
                                <?= ucfirst(str_replace('_', ' ', $status)) ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is-dissolve" name="is-dissolve"
                            value="1" <?= $is_dissolve ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="is-dissolve">
                            Mark as Dissolved
                        </label>
                    </div>
                    <small class="form-text text-muted">Check if this position has been dissolved</small>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <?php
                $verifier = $_GET['id'] ?? null;
                $verifier = $plantillaId === $copiedId ? null : $verifier;
                ?>
                <input type="hidden" name="verifier" value="<?= e($verifier) ?>">
                <button type="submit" name="save-plantilla-item" class="btn btn-primary">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>