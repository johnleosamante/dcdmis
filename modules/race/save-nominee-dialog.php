<?php
// modules/race/save-nominee-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$awardIdDecrypted = isset($_GET['award_id']) ? sanitize(decipher($_GET['award_id'])) : null;

$categoryId = null;
$awardId = null;
$awardName = '';
$categoryName = '';

if ($awardIdDecrypted) {
    $award = recognitionAward($awardIdDecrypted);
    if ($award) {
        $awardId = $award['id'];
        $categoryId = $award['category_id'];
        $awardName = $award['name'];

        $category = recognitionCategory($categoryId);
        if ($category) {
            $categoryName = $category['name'];
        }
    }
}

$modalTitle = 'Add Nominee';
if ($awardName) {
    $modalTitle = 'Add Nominee for ' . $awardName;
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="category" value="<?= e($categoryId) ?>">
                <input type="hidden" name="award" value="<?= e($awardId) ?>">

                <div class="form-group mb-3">
                    <label class="mb-0 text-gray-800">Award Details</label>
                    <div class="font-weight-bold text-uppercase text-xs mt-1">
                        <span class="text-primary"><?= e($categoryName) ?></span> &raquo; <span class="text-danger"><?= e($awardName) ?></span>
                    </div>
                </div>

                <?php
                $isSchoolAward = false;
                $lowerAwardName = strtolower($awardName);
                if (strpos($lowerAwardName, 'medium school') !== false ||
                    strpos($lowerAwardName, 'small school') !== false ||
                    strpos($lowerAwardName, 'large school') !== false) {
                    $isSchoolAward = true;
                }
                if ($isSchoolAward):
                    $isPrincipalSchool = isPrincipal($userId);
                ?>
                    <div class="form-group" id="school-group">
                        <label for="employee-id" class="mb-0">School <?php showAsterisk() ?></label>
                        <?php if ($isPrincipalSchool): ?>
                            <small class="text-info d-block mb-1"><i class="fas fa-info-circle"></i> You can only nominate your own school.</small>
                        <?php endif; ?>
                        <select id="employee-id" name="employee-id" class="form-control" title="Select school..." required>
                            <option value="">Select School...</option>
                            <?php
                            if ($isPrincipalSchool):
                                $mySchool = schoolById($stationId);
                                if ($mySchool): ?>
                                    <option value="<?= e($mySchool['id']) ?>" selected>
                                        <?= e($mySchool['name']) ?> &mdash; (<?= e($mySchool['alias'] ?: 'No Alias') ?>)
                                    </option>
                                <?php endif;
                            else:
                                $allSchools = schools();
                                foreach ($allSchools as $sch): ?>
                                    <option value="<?= e($sch['id']) ?>">
                                        <?= e($sch['name']) ?> &mdash; (<?= e($sch['alias'] ?: 'No Alias') ?>)
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                <?php else:
                    $isPrincipalUser = isPrincipal($userId);
                    $employees = $isPrincipalUser ? activeEmployeesWithPosition($stationId) : activeEmployeesWithPosition();
                ?>
                    <div class="form-group" id="employee-group">
                        <label for="employee-id" class="mb-0">Select Employee <?php showAsterisk() ?></label>
                        <?php if ($isPrincipalUser): ?>
                            <!-- <small class="text-info d-block mb-1"><i class="fas fa-info-circle"></i> Showing personnel under your school only.</small> -->
                        <?php endif; ?>
                        <select id="employee-id" name="employee-id" class="form-control" title="Select employee..." required>
                            <option value="">Select Employee...</option>
                            <?php foreach ($employees as $emp):
                                $fullName = toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension']);
                                ?>
                                <option value="<?= e($emp['employee_id']) ?>">
                                    <?= e($fullName) ?> &mdash; <?= e($emp['official_title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <?php
                $needsLevel = false;
                $lowerAwardName = strtolower($awardName);
                $allowedAwards = [
                    'most outstanding teacher',
                    'most outstanding master teacher',
                    'most outstanding school head',
                    'best small school',
                    'best medium school',
                    'best large school'
                ];
                foreach ($allowedAwards as $allowed) {
                    if (strpos($lowerAwardName, $allowed) !== false) {
                        $needsLevel = true;
                        break;
                    }
                }
                if ($needsLevel): ?>
                    <div class="form-group mt-3" id="level-group">
                        <label for="level" class="mb-0">Level <?php showAsterisk() ?></label>
                        <select id="level" name="level" class="form-control" title="Select level..." required>
                            <option value="">Select Level...</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Secondary">Secondary</option>
                        </select>
                    </div>
                <?php endif; ?>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['e'] ?? null ?>">
                <button class="btn btn-primary" name="save-nominee" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
