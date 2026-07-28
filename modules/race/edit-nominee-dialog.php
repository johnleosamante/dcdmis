<?php
// modules/race/edit-nominee-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$nomineeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$nominee = $nomineeId ? nominee($nomineeId) : null;
$isAdmin = raceAccessLevel($userId) === 'admin';
$awards = $isAdmin ? recognitionAwards() : [];

$currentAward = $nominee ? recognitionAward($nominee['award_id']) : null;
$needsLevel = $currentAward && (int)$currentAward['has_level'] === 1;

$isSchoolNominee = $nominee && strtolower($nominee['nominee_type']) === 'school';
$isEmployeeNominee = $nominee && strtolower($nominee['nominee_type']) === 'employee';

$allSchools = $isAdmin ? schools() : [];
$allEmployees = $isAdmin ? activeEmployeesWithPosition() : [];
usort($allEmployees, function ($a, $b) {
    $cmp = strcasecmp($a['last_name'] ?? '', $b['last_name'] ?? '');
    if ($cmp !== 0) return $cmp;
    $cmp = strcasecmp($a['first_name'] ?? '', $b['first_name'] ?? '');
    if ($cmp !== 0) return $cmp;
    return strcasecmp($a['middle_name'] ?? '', $b['middle_name'] ?? '');
});
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Edit Nominee'); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">

                <?php if ($nominee && $isAdmin):
                    $currentNomineeLabel = $nominee['nominee_id'];
                    if ($isSchoolNominee) {
                        $sch = find("SELECT `name`, `alias` FROM `schools` WHERE `id` = ? LIMIT 1", [$nominee['nominee_id']]);
                        if ($sch) {
                            $currentNomineeLabel = $sch['name'] . ' (' . ($sch['alias'] ?: 'N/A') . ')';
                        }
                    } else {
                        $emp = find("SELECT `first_name`, `last_name`, `middle_name`, `name_extension` FROM `employees` WHERE `id` = ? LIMIT 1", [$nominee['nominee_id']]);
                        if ($emp) {
                            $currentNomineeLabel = toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension']);
                        }
                    }
                ?>
                    <div class="form-group">
                        <label class="mb-0 text-gray-800">Current Nominee</label>
                        <div class="font-weight-bold text-uppercase text-xs mt-1">
                            <span class="text-primary"><?= e($nominee['nominee_type']) ?></span>
                            &raquo;
                            <span class="text-danger"><?= e($currentNomineeLabel) ?></span>
                        </div>
                    </div>

                    <input type="hidden" name="nominee_type" value="<?= e($nominee['nominee_type']) ?>">

                    <?php if ($isSchoolNominee): ?>
                        <div class="form-group">
                            <label for="edit-school-id" class="font-weight-bold">Select School <?= showAsterisk() ?></label>
                            <select id="edit-school-id" name="nominee_ref_id" class="form-control" required>
                                <option value="">Select School...</option>
                                <?php foreach ($allSchools as $sch): ?>
                                    <option value="<?= e($sch['id']) ?>" <?= ((string) $sch['id'] === (string) ($nominee['nominee_id'] ?? '')) ? 'selected' : '' ?>>
                                        <?= e($sch['name']) ?> &mdash; (<?= e($sch['alias'] ?: 'No Alias') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label for="edit-employee-id" class="font-weight-bold">Select Employee <?= showAsterisk() ?></label>
                            <select id="edit-employee-id" name="nominee_ref_id" class="form-control" required>
                                <option value="">Select Employee...</option>
                                <?php foreach ($allEmployees as $emp):
                                    $fullName = toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension']);
                                ?>
                                    <option value="<?= e($emp['employee_id']) ?>" <?= ((string) $emp['employee_id'] === (string) ($nominee['nominee_id'] ?? '')) ? 'selected' : '' ?>>
                                        <?= e($fullName) ?> &mdash; <?= e($emp['official_title']) ?>
                                        <?php if (!empty($emp['school_name'])): ?>
                                            &mdash; <?= e($emp['school_name']) ?><?php if (!empty($emp['school_alias'])): ?> (<?= e($emp['school_alias']) ?>)<?php endif; ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="edit-award-id" class="font-weight-bold">Award <?= showAsterisk() ?></label>
                        <select id="edit-award-id" name="award_id" class="form-control" required>
                            <option value="">Select Award...</option>
                            <?php foreach ($awards as $a): ?>
                                <option value="<?= e($a['id']) ?>" <?= ((string) $a['id'] === (string) ($nominee['award_id'] ?? '')) ? 'selected' : '' ?>>
                                    <?= e($a['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if ($needsLevel): ?>
                        <div class="form-group">
                            <label for="edit-level" class="font-weight-bold">Level <?= showAsterisk() ?></label>
                            <select id="edit-level" name="level" class="form-control" required>
                                <option value="">Select Level...</option>
                                <option value="Elementary" <?= ($nominee['level'] ?? '') === 'Elementary' ? 'selected' : '' ?>>Elementary</option>
                                <option value="Secondary" <?= ($nominee['level'] ?? '') === 'Secondary' ? 'selected' : '' ?>>Secondary</option>
                                <option value="Integrated" <?= ($nominee['level'] ?? '') === 'Integrated' ? 'selected' : '' ?>>Integrated</option>
                            </select>
                        </div>
                    <?php endif; ?>

                <?php elseif (!$isAdmin): ?>
                    <p class="text-danger text-center">Only RACE administrators can edit nominees.</p>
                <?php else: ?>
                    <p class="text-danger text-center">Nominee not found.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <?php if ($nominee && $isAdmin): ?>
                    <button class="btn btn-primary" name="edit-nominee" type="submit"><i class="fas fa-save fa-fw mr-1"></i> Save Changes</button>
                <?php endif; ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
