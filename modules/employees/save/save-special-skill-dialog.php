<?php
// modules/employees/save/save-special-skill-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/special-skill.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$skillId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$skill = '';
$modalTitle = 'Add Special Skill / Hobby';

if (isset($skillId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Special Skill / Hobby' : 'Edit Special Skill / Hobby';
    $specialSkill = specialSkill($employeeId, $skillId);

    if ($specialSkill) {
        $skillId = $specialSkill['id'];
        $skill = $specialSkill['name'];
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
                    <label for="skill" class="mb-0">Special Skill / Hobby: <?php showAsterisk() ?></label>
                    <input id="skill" type="text" name="skill" class="form-control" title="Required field"
                        value="<?= e($skill) ?>" required>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['e'] ?? null ?>">
                <?php
                $verifier = $_GET['id'] ?? null;
                $verifier = $employeeId === $copiedId ? null : $verifier;
                ?>
                <input type="hidden" name="data-verifier" value="<?= e($verifier) ?>">
                <button type="submit" class="btn btn-primary" name="save-special-skill">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>