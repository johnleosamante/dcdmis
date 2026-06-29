<?php
// modules/transfer-request/disapprove-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/database/transfer-request.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$requestId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$request = getTransferRequest($requestId);
$hasRequest = false;
$modalTitle = 'Request not found';

if ($request) {
    $hasRequest = true;
    $modalTitle = 'Disapprove Transfer Request';
    $employeeName = userName($request['employee_id'], true);
    $employee = employee($request['employee_id']);
    $positionTitle = position($request['employee_id'])['official_title'];
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? "{$baseUri}/" . $employee['profile_picture'] : "{$baseUri}/assets/img/user.png";
}
?>

<div class="modal-dialog <?= !$hasRequest ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($hasRequest) {
                    employeeProfile($picture, $employeeName, $employee['sex'], $employee['email_address'], $positionTitle, e(stationName($request['current_station_id'])), $employee['status']);

                    message("Disapproving this request will reject the transfer. The employee will remain at their current assignment.", 'danger', 'exclamation-triangle', 2, 3);
                    ?>

                    <div class="form-group mb-2">
                        <label class="font-weight-bold small mb-0">Preferred Assignment:</label>
                        <input class="form-control" value="<?= e(stationName($request['target_station_id'])) ?>" readonly>
                    </div>

                    <div class="form-group mb-2">
                        <label class="font-weight-bold small mb-0">Reason for Transfer:</label>
                        <textarea id="remarks" name="remarks" class="form-control" rows="3"
                            readonly><?= e($request['reason']) ?></textarea>
                    </div>

                    <?php if (!empty($request['specialization'])): ?>
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small mb-0">Major Subject / Area of
                                Specialization:</label>
                            <input class="form-control" value="<?= e($request['specialization']) ?>" readonly>
                        </div>
                    <?php endif; ?>

                    <div class=" form-group mb-2">
                        <label for="remarks" class="mb-0 font-weight-bold small">Reason / Remarks
                            <?php showAsterisk() ?></label>
                        <textarea id="remarks" name="remarks" class="form-control" rows="3"
                            placeholder="Please state the reason for disapproval..." required></textarea>
                    </div>
                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasRequest): ?>
                    <input type="hidden" name="data-verifier" value="<?= e($_GET['id']) ?>">
                    <button class="btn btn-danger" name="disapprove-transfer-request" type="submit">
                        Continue
                    </button>
                <?php endif;
                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>