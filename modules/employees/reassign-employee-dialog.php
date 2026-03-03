<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employee = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;

if ($employee) {
    $employeeId = $employee['id'];
    $employeeName = toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'], true);
    $sex = $employee['sex'];
    $positions = position($employeeId);
    $doa = $positions['assignment_date'];
    $stationId = $positions['station_id'];
    $station = $positions['station'];
    $positionId = $positions['position_id'];
    $position = $positions['official_title'];
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? "{$baseUri}/" . $employee['profile_picture'] : "{$baseUri}/assets/img/user.png";
    $modalTitle = 'Reassign Employee';
    $hasEmployee = true;
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <div class="modal-body">
                <?php if ($hasEmployee) { ?>
                    <div class="image-container">
                        <span
                            class="d-flex justify-content-center align-middle employee-photo photo-4x rounded-circle overflow-hidden">
                            <img height="100%" src="<?= $picture ?>" alt="<?= $employeeName ?>">
                        </span>
                        <div class="sex-sign"><?php sex($sex) ?></div>
                    </div>

                    <div class="text-center text-uppercase my-1 h4"><?= $employeeName ?></div>
                    <div class="text-center text-uppercase my-1 h5"><?= $position ?></div>
                    <div class="text-center text-uppercase my-1 h6"><?= $station ?></div>

                    <hr>

                    <div class="form-group">
                        <label for="assignment" class="mb-0">Place of Assignment <?php showAsterisk() ?></label>
                        <select id="assignment" name="assignment" class="form-control"
                            title="Select employee place of assignment..." required>
                            <option value="">Select place of assignment...</option>
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
                        <label for="assignment-date" class="mb-0">Date of Assignment <?php showAsterisk() ?></label>
                        <input class="form-control" type="date" id="assignment-date" name="assignment-date"
                            value="<?= toDate($doa, 'Y-m-d', date('Y-m-d')) ?>" title="Set date of assignment..." required>
                    </div>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee): ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?>">
                    <button class="btn btn-primary" name="reassign-employee" type="submit">Continue</button>
                <?php endif;
                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>