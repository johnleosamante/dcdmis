<?php
// modules/employee/save-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/school.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$vacancyId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$positionId = $itemNo = $stationId = '';
$datePosted = date('Y-m-d');
$isNewItem = true;

$modalTitle = 'Add Vacancy';

if (isset($vacancyId)) {
    $modalTitle = $vacancyId === $copiedId ? 'Copy Vacancy' : 'Edit Vacancy';
    $vacancy = vacancy($vacancyId);

    if ($vacancy) {
        $vacancyId = $vacancy['id'];
        $positionId = $vacancy['position_id'];
        $itemNo = $vacancy['item_number'];
        $stationId = $vacancy['station_id'];
        $datePosted = $vacancy['date_vacated'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="position" class="mb-0">Position <?php showAsterisk($isNewItem) ?></label>
                    <?php if ($isNewItem): ?>
                        <select id="position" name="position" class="form-control" title="Select vacancy position..."
                            required>
                            <option value="">Select position...</option>
                            <?php
                            $categories = positionCategories();
                            foreach ($categories as $category): ?>
                                <optgroup label="<?= $category['category'] ?>">
                                    <?php $jobPositions = positionsByCategory($category['category']);
                                    foreach ($jobPositions as $jobPosition): ?>
                                        <option value="<?= $jobPosition['id'] ?>" <?= setOptionSelected($jobPosition['id'], $positionId) ?>><?= $jobPosition['official_title'] ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            <?php endforeach ?>
                        </select>
                    <?php else: ?>
                        <input id="position" type="text" class="form-control"
                            value="<?= positions($positionId)['official_title'] ?>" readonly>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="item_number" class="mb-0">Item Number <?= showAsterisk($isNewItem) ?></label>
                    <input id="item_number" <?= $isNewItem ? 'name="item_number"' : '' ?> class="form-control"
                        type="text" placeholder="Enter item number..." value="<?= $itemNo ?>" <?= $isNewItem ? 'required' : 'readonly' ?>>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station</label>
                    <select id="station" name="station" class="form-control" title="Select employee station...">
                        <option value="">Select station...</option>
                        <?php
                        $districts = districts();
                        foreach ($districts as $district): ?>
                            <optgroup label="<?= $district['name'] ?>">
                                <?php
                                $schools = schoolsByDistrict($district['id']);
                                foreach ($schools as $school): ?>
                                    <option value="<?= $school['id'] ?>" <?= setOptionSelected($school['id'], $stationId) ?>>
                                        <?= $school['name'] ?>
                                    </option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_posted" class="mb-0">Date Posted</label>
                    <input id="date_posted" name="date_posted" type="date" class="form-control"
                        value="<?= $datePosted ?>">
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <?php $verifier = $vacancyId === $copiedId ? null : $vacancyId; ?>
                <input type="hidden" name="verifier" value="<?= $verifier ?>">
                <?php if (!$isNewItem): ?>
                    <input type="hidden" name="position" value="<?= $positionId ?>">
                <?php endif; ?>
                <button class="btn btn-primary" name="save-vacancy" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>