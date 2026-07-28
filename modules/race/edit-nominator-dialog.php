<?php
// modules/race/edit-nominator-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$nomineeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$nominee = $nomineeId ? nominee($nomineeId) : null;
$isAdmin = raceAccessLevel($userId) === 'admin';
$employees = $isAdmin ? query("SELECT `id`, `first_name`, `middle_name`, `last_name`, `name_extension` FROM `employees` WHERE `status` = 'Active' ORDER BY `last_name`, `first_name`") : [];
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Change Nominee Nominator'); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">

                <?php if ($nominee && $isAdmin): ?>
                    <div class="alert alert-warning border">
                        <i class="fas fa-user-edit mr-1"></i>
                        Only RACE administrators can change the recorded nominator.
                    </div>

                    <div class="form-group">
                        <label for="nominated-by" class="font-weight-bold">Nominator</label>
                        <select id="nominated-by" name="nominated_by" class="form-control" required>
                            <option value="">Select nominator...</option>
                            <?php foreach ($employees as $employee):
                                $name = toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension']);
                            ?>
                                <option value="<?= e(cipher($employee['id'])) ?>" <?= (string) $nominee['nominated_by'] === (string) $employee['id'] ? 'selected' : '' ?>>
                                    <?= e($name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php elseif (!$isAdmin): ?>
                    <p class="text-danger text-center">Only RACE administrators can change the nominator.</p>
                <?php else: ?>
                    <p class="text-danger text-center">Nominee not found.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <?php if ($nominee && $isAdmin): ?>
                    <button class="btn btn-primary" name="change-nominator" type="submit"><i class="fas fa-save fa-fw mr-1"></i> Save Nominator</button>
                <?php endif; ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
