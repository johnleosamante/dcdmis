<?php
// modules/employees/save/save-reference-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/references.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$referenceId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$name = $address = $contact = '';
$modalTitle = 'Add Reference';

if (isset($referenceId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Reference' : 'Edit Reference';
    $reference = reference($employeeId, $referenceId);

    if ($reference) {
        $referenceId = $reference['id'];
        $name = $reference['name'];
        $address = $reference['address'];
        $contact = $reference['contact'];
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
                    <label for="name" class="mb-0">Name: <?php showAsterisk() ?></label>
                    <input type="text" id="name" name="name" class="form-control" title="Required field"
                        value="<?= e($name) ?>" required>
                </div>

                <div class="form-group">
                    <label for="address" class="mb-0">Address: <?php showAsterisk() ?></label>
                    <input type="text" id="address" name="address" class="form-control" title="Required field"
                        value="<?= e($address) ?>" required>
                </div>

                <div class="form-group">
                    <label for="telephone" class="mb-0">Contact Number: <?php showAsterisk() ?></label>
                    <input type="text" id="telephone" name="telephone" class="form-control" title="Required field"
                        value="<?= e($contact) ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-reference">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>