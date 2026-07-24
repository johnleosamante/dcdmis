<?php
// modules/employee/save-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/vacancy.php';
// require_once root() . '/includes/database/plantilla.php';
require_once root() . '/includes/layout/components.php';

$datePosted = date('Y-m-d');
$modalTitle = 'Add Vacancy';
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="item_number" class="mb-0">Item Number <?= showAsterisk() ?></label>
                    <select id="item_number" name="item_number" class="form-control" title="Select item number..."
                        required>
                        <option value="">Select item number...</option>
                        <?php
                        $items = vacantPlantillaItems();
                        $groupedByPosition = [];
                        foreach ($items as $item) {
                            $posKey = $item['official_title'] . ' (' . $item['salary_grade'] . ')';
                            if (!isset($groupedByPosition[$posKey])) {
                                $groupedByPosition[$posKey] = [];
                            }
                            $groupedByPosition[$posKey][] = $item;
                        }
                        foreach ($groupedByPosition as $position => $items): ?>
                            <optgroup label="<?= e($position) ?>">
                                <?php foreach ($items as $item):
                                    $itemId = e($item['id']) ?>
                                    <option value="<?= $itemId ?>">
                                        <?= e($item['item_number']) ?>
                                    </option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_posted" class="mb-0">Date Posted <?= showAsterisk() ?></label>
                    <input id="date_posted" name="date_posted" type="date" class="form-control"
                        value="<?= e($datePosted) ?>" required>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <button class="btn btn-primary" name="save-vacancy" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>