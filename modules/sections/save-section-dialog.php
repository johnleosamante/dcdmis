<?php
// modules/sections/save-section-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/layout/components.php');

$sectionAlias = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$section = section($sectionAlias);
$sectionName = $sectionHead = $sectionDivision = null;
$modalTitle = 'New Section';
$notFound = true;

if ($section) {
    $sectionName = $section['name'];
    $sectionHead = $section['head'];
    $sectionDivision = $section['division'];
    $modalTitle = 'Edit Section';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="alias" class="mb-0">Alias <?php showAsterisk(); ?></label>
                    <input type="text" id="alias" name="alias" class="form-control" minlength="3" maxlength="3"
                        value="<?php echo $sectionAlias; ?>" required>
                </div>
                <div class="form-group">
                    <label for="section" class="mb-0">Name <?php showAsterisk(); ?></label>
                    <input type="text" id="section" name="section" class="form-control"
                        value="<?php echo $sectionName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="division" class="mb-0">Functional Division <?php showAsterisk(); ?></label>
                    <select id="division" name="division" class="form-control" required>
                        <option value="">Select functional division...</option>
                        <?php $divisions = functionalDivisions();
                        foreach ($divisions as $division): ?>
                            <option value="<?php echo $division['id']; ?>" <?php echo setOptionSelected($division['id'], $sectionDivision); ?>><?php echo $division['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="head" class="mb-0">Section Head <?php showAsterisk(); ?></label>
                    <select id="head" name="head" class="form-control" required>
                        <option value="">Select section head...</option>
                        <?php $employees = activeEmployees(divisionId());
                        foreach ($employees as $employee): ?>
                            <option value="<?= $employee['id'] ?>" title="<?= position($employee['id'])['position'] ?>"
                                <?= setOptionSelected($employee['id'], $sectionHead) ?>>
                                <?= userName($employee['id']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php requiredLegend(0); ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['id'] ?? null ?>">
                <button class="btn btn-primary" name="save-section" type="submit">Continue</button>
                <?php cancelModalButton(); ?>
            </div>
        </form>
    </div>
</div>