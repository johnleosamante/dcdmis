<?php
// modules/vacancies/fill-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/employee.php';
require_once root() . '/includes/database/school.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$vacancyId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$position = $itemNumber = $stationName = 'N/A';
$stationId = null;
$dateFilled = date('Y-m-d');

if (isset($vacancyId)) {
    $vacancyDataSet = vacancy($vacancyId);

    if (numRows($vacancyDataSet) > 0) {
        $vacancy = fetchArray($vacancyDataSet);
        $itemNumber = $vacancy['item_number'] ?? 'N/A';
        $stationId = $vacancy['station_id'];
        $positionId = $vacancy['position_id'];
        $positionData = fetchAssoc(positions($positionId));
        $position = $positionData['position'] ?? 'Unknown Position';

        if (!empty($stationId)) {
            $school = fetchAssoc(schoolById($stationId));
            $stationName = $school['name'] ?? 'Unknown Station';
        }
    }
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Fill Vacancy'); ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Position</p>
                                <p class="font-weight-bold text-uppercase mb-2">
                                    <?= $position ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Item Number</p>
                                <p class="font-weight-bold text-primary mb-2">
                                    <?= $itemNumber ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1 small text-muted">Station</p>
                                <p class="font-weight-bold mb-0">
                                    <?= $stationName ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="employee_id" class="mb-0 font-weight-bold">Select Applicant
                    <?php showAsterisk() ?>
                </label>
                <p class="small text-muted mb-2">Only applicants for this vacancy are listed.</p>
                <select id="employee_id" name="employee_id" class="form-control" required>
                    <option value="">Select applicant...</option>
                    <?php
                    $applications = applicationsByVacancy($vacancyId);
                    if (numRows($applications) > 0) {
                        while ($app = fetchAssoc($applications)) {
                            $empId = $app['employee_id'];
                            $appName = $app['applicant_name'];
                            $isDisabled = false;
                            $statusLabel = '';

                            if (!empty($empId)) {
                                $statusLabel = ' (Internal)';
                            } else {
                                // Try to find employee by name (simple check? or just disable)
                                // For now, if no employee_id, we disable
                                $isDisabled = true;
                                $statusLabel = ' (External - Employee record required)';
                            }
                            ?>
                            <option value="<?= $empId ?>" <?= $isDisabled ? 'disabled' : '' ?>>
                                <?= $appName . $statusLabel ?>
                            </option>
                            <?php
                        }
                    } else {
                        // Optional: Show message or empty
                        echo '<option value="" disabled>No applicants found for this vacancy</option>';
                    }
                    ?>
                </select>
            </div>

            <?php if (numRows($applications) == 0): ?>
                <div class="alert alert-warning small">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    No online applicants found. To fill with an existing employee who didn't apply online, ensure they are
                    in the database.
                    <!-- Maybe add a toggle to show all employees? -->
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="date_filled" class="mb-0 font-weight-bold">Date Filled
                    <?php showAsterisk() ?>
                </label>
                <p class="small text-muted mb-2">The date when the vacancy was filled</p>
                <input id="date_filled" name="date_filled" type="date" class="form-control" value="<?= $dateFilled ?>"
                    required>
            </div>

            <?php requiredLegend(0) ?>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?= cipher($vacancyId) ?>">
        <button class="btn btn-success" name="fill-vacancy" type="submit">
            <i class="fas fa-user-plus fa-fw mr-1"></i>Fill Vacancy
        </button>
        <?php cancelModalButton() ?>
    </div>
    </form>
</div>
</div>