<?php
// modules/service-record/save-service-record-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$serviceRecordId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$service = $position = $organization = $organizationAlias = $status = $isgovernment = $leave = $separationCause = $sg = null;
$salary = 0;
$from = $to = $separationDate = date('Y-m-d');
$isPresent = $isSeparation = false;
$modalTitle = 'Add Service Record';

if (isset($serviceRecordId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Service Record' : 'Edit Service Record';
    $service = experience($employeeId, $serviceRecordId);

    if ($service) {
        $serviceRecordId = $service['id'];
        $from = toDate($service['from_date'], 'Y-m-d');
        $isPresent = $service['is_present'];
        $to = $isPresent ? date('Y-m-d') : toDate($service['to_date'], 'Y-m-d');
        $position = $service['designation'];
        $isgovernment = $service['is_government_service'] ? 'Y' : 'N';
        $sg = $service['salary_grade_step_increment'];
        $salary = $service['monthly_salary'];
        $organization = $service['agency_company'];
        $status = $service['appointment_status'];
        $leave = $service['leave_wo_pay'];
        $isSeparation = $service['for_separation'];
        $separationDate = !empty($service['separation_date']) ? toDate($service['separation_date'], 'Y-m-d') : date('Y-m-d');
        $separationCause = $service['separation_cause'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from" class="mb-0">Inclusive Dates From <?php showAsterisk() ?></label>
                            <input id="from" type="date" name="from" class="form-control" title="Required field"
                                value="<?= e($from) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="to" class="mb-0">Dates To <?php showAsterisk() ?></label>
                                </div>
                                <div class="col-6">
                                    <div class="form-check" title="Check if present work">
                                        <input class="form-check-input" id="is-present" type="checkbox"
                                            name="is-present" value="1" <?= setItemChecked($isPresent) ?>>
                                        <label class="form-check-label" for="is-present">Present</label>
                                    </div>
                                </div>
                            </div>
                            <input id="to" type="date" name="to" class="form-control" title="Required field"
                                value="<?= e($to) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="position" class="mb-0">Designation <?php showAsterisk() ?></label>
                            <input id="position" type="text" name="position" class="form-control" title="Required field"
                                value="<?= e($position) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="mb-0">Employment Status <?php showAsterisk() ?></label>
                            <select name="status" id="status" class="form-control" title="Required field" required>
                                <option value="Permanent" <?= setOptionSelected("Permanent", $status) ?>>Permanent
                                </option>
                                <option value="Temporary" <?= setOptionSelected("Temporary", $status) ?>>Temporary
                                </option>
                                <option value="Coterminus" <?= setOptionSelected("Coterminus", $status) ?>>Coterminus
                                </option>
                                <option value="Fixed Term" <?= setOptionSelected("Fixed Term", $status) ?>>Fixed Term
                                </option>
                                <option value="Contractual" <?= setOptionSelected("Contractual", $status) ?>>Contractual
                                </option>
                                <option value="Substitute" <?= setOptionSelected("Substitute", $status) ?>>Substitute
                                </option>
                                <option value="Provisional" <?= setOptionSelected("Provisional", $status) ?>>Provisional
                                </option>
                                <option value="Volunteer" <?= setOptionSelected("Volunteer", $status) ?>>Volunteer
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="is-government" class="mb-0">Government Service <?php showAsterisk() ?></label>
                            <select name="is-government" id="is-government" title="Required field" class="form-control"
                                required>
                                <option value="Y" <?= setOptionSelected("Y", $isgovernment) ?>>Yes</option>
                                <option value="N" <?= setOptionSelected("N", $isgovernment) ?>>No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sg-step" class="mb-0">Salary Grade &amp; Step Increment</label>
                            <input id="sg-step" type="text" name="sg-step" class="form-control"
                                title="Leave blank if not applicable" value="<?= e($sg) ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary" class="mb-0">Monthly<br>Salary</label>
                            <input id="salary" type="number" name="salary" class="form-control" min="0" step="1"
                                title="Leave blank if not applicable" value="<?= e($salary) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="station" class="mb-0">Office Entity / Division / Station / Place / Branch of
                                Assignment <?php showAsterisk() ?></label>
                            <input id="station" type="text" name="station" class="form-control" title="Required field"
                                value="<?= e($organization) ?>" required>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label for="leave" class="mb-0">Leave Without Pay</label>
                    <input id="leave" type="text" name="leave" class="form-control"
                        title="Leave blank if not applicable" value="<?= e($leave) ?>">
                </div>

                <div class="form-check mb-2" title="Check for separation">
                    <input class="form-check-input" id="is-separation" type="checkbox" name="is-separation" value="1"
                        <?= setItemChecked($isSeparation) ?>>
                    <label class="form-check-label" for="is-separation">Separation</label>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="separation-date" class="mb-0">Date</label>
                            <input id="separation-date" type="date" name="separation-date" class="form-control"
                                title="Leave blank if not applicable" value="<?= e($separationDate) ?>">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="separation-cause" class="mb-0">Cause</label>
                            <input id="separation-cause" type="text" name="separation-cause" class="form-control"
                                title="Leave blank if not applicable" value="<?= e($separationCause) ?>">
                        </div>
                    </div>
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
                <button type="submit" class="btn btn-primary" name="save-service-record">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>