<?php
// modules/users/view-user-dialog.php
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
$depedEmail = $temporaryPassword = '';

if ($employee) {
    $employeeId = $employee['id'];
    $employeeName = toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'], true);
    $sex = $employee['sex'];
    $status = $employee['status'];
    $positions = position($employeeId);
    $stationId = $positions['station_id'];
    $station = $positions['station'];
    $positionId = $positions['position_id'];
    $position = $positions['official_title'];
    $depedEmail = $employee['email_address'];
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? "$baseUri/" . $employee['profile_picture'] : "$baseUri/assets/img/user.png";
    $modalTitle = 'Reset User Password';
    $hasEmployee = true;
    $randomPassword = generateStrongRandomPassword();
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($hasEmployee) {
                    employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $status);
                    ?>
                    <hr>
                    <div class="text-center bg-secondary text-light rounded p-2 h2 mt-3 mb-0"><?= e($randomPassword) ?>
                    </div>
                    <div class="text-center mt-1 small"><em>The user will receive an email containing the above code to be
                            used as the temporary password.</em></div>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee): ?>
                    <input type="hidden" name="verifier" value="<?= e($_GET['id']) ?>">
                    <input type="hidden" name="data-verifier" value="<?= cipher($randomPassword) ?>">
                    <button class="btn btn-danger" name="reset-user" type="submit">Continue</button>
                <?php endif;

                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>