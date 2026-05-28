<?php
// modules/employees/save/save-child-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/family-background.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = sanitize(decipher($_GET['e'] ?? null));
$childId = sanitize(decipher($_GET['id'] ?? null));
$copiedId = sanitize(decipher($_GET['c'] ?? null));
$fname = $mname = $lname = $ext = null;
$bdate = date('Y-M-d');
$modalTitle = 'Add Child Name';

if ($childId) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Child Name' : 'Edit Child Name';
    $child = child($employeeId, $childId);

    if ($child) {
        $childId = $child['id'];
        $fname = $child['first_name'];
        $mname = $child['middle_name'];
        $lname = $child['last_name'];
        $ext = $child['name_extension'];
        $bdate = $child['birthdate'];
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
                    <label for="clast" class="mb-0">Last Name <?php showAsterisk() ?></label>
                    <input id="clast" type="text" name="clast" class="form-control" placeholder="ex. DELA CRUZ"
                        title="ex. DELA CRUZ" value="<?= e($lname) ?>" required>
                </div>

                <div class="form-group">
                    <label for="cfirst" class="mb-0">First Name <?php showAsterisk() ?></label>
                    <input id="cfirst" type="text" name="cfirst" class="form-control" placeholder="ex. JUAN"
                        title="ex. JUAN" value="<?= e($fname) ?>" required>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="cmiddle" class="mb-0">Middle Name</label>
                            <input id="cmiddle" type="text" name="cmiddle" class="form-control"
                                placeholder="ex. BAUTISTA" title=" ex. BAUTISTA, Leave blank if not applicable"
                                value="<?= e($mname) ?>">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cext" class="mb-0">Extension</label>
                            <input id="cext" type="text" name="cext" class="form-control"
                                placeholder="ex. JR., SR., III"
                                title=" ex. JR., SR., III, Leave blank if not applicable" value="<?= e($ext) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cdob" class="mb-0">Date of Birth <?php showAsterisk() ?></label>
                    <input id="cdob" type="date" name="cdob" class="form-control" title="Set child date of birth..."
                        value="<?= toDate($bdate, "Y-m-d") ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-child">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>