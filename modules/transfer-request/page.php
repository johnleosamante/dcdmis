<?php
// modules/transfer-request/page.php
$isNonDivision = $stationId !== '143';
if (!$isPis || (!$isSchoolPortal && !$isNonDivision)) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employee = employee($userId);
if (!$employee) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);

$currStation = station($userId);
$currentStationId = $currStation ? $currStation['station_id'] : '';
$currentStationName = $currStation ? stationName($currentStationId) : 'N/A';

$isTeaching = false;
if ($currStation) {
    $pos = positions($currStation['position_id']);
    if ($pos && $pos['category'] === 'Teaching') {
        $isTeaching = true;
    }
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Request Transfer</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-12 mb-4">
        <div class="card border-left-primary shadow h-100">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-exchange-alt mr-2"></i>Request Transfer of Assignment
                </h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label class="mb-0 font-weight-bold">Current Assignment</label>
                        <input type="text" class="form-control bg-light" value="<?= e($currentStationName) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="target-station" class="mb-0 font-weight-bold">Preferred Assignment
                            <?php showAsterisk() ?></label>
                        <select id="target-station" name="target-station" class="form-control"
                            title="Select preferred assignment..." required>
                            <option value="">Select preferred assignment...</option>

                            <?php
                            $districts = districts();
                            foreach ($districts as $district): ?>
                                <optgroup label="<?= e($district['name']) ?>">
                                    <?php
                                    $schools = schoolsByDistrict($district['id']);
                                    foreach ($schools as $school): ?>
                                        <?php if ($school['id'] !== $currentStationId && $school['id'] !== '143' && strtolower($school['alias']) !== 'sdo'): ?>
                                            <option value="<?= e($school['id']) ?>">
                                                <?= e($school['name']) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                </optgroup>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <?php if ($isTeaching): ?>
                        <div class="form-group">
                            <label for="specialization" class="mb-0 font-weight-bold">Major Subject / Area of Specialization
                                <?php showAsterisk() ?></label>
                            <input type="text" id="specialization" name="specialization" class="form-control"
                                placeholder="e.g. English, Mathematics, General Science..." required>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="reason" class="mb-0 font-weight-bold">Reason for Transfer
                            <?php showAsterisk() ?></label>
                        <textarea id="reason" name="reason" class="form-control" rows="4"
                            placeholder="State your reasons for requesting this transfer..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="attachment" class="mb-0 font-weight-bold">Supporting Document (PDF)
                            <?php showAsterisk() ?></label>
                        <div class="custom-file mt-1">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" accept=".pdf"
                                required>
                            <label class="custom-file-label" for="attachment">Choose file...</label>
                        </div>
                        <small class="form-text text-muted">Max file upload size:
                            <?= ini_get('upload_max_filesize') ?>B
                        </small>
                    </div>

                    <?php requiredLegend(2) ?>

                    <button class="btn btn-primary btn-block font-weight-bold shadow-sm" name="submit-transfer-request"
                        type="submit">
                        Submit Transfer Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
        <div class="card border-left-secondary shadow h-100">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-history mr-2"></i>History of Transfer of Assignment
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="10%">Date Requested</th>
                                <th class="align-middle" width="70%">Assignment Details</th>
                                <th class="align-middle" width="15%">Status</th>
                                <th class="align-middle" width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $requests = getEmployeeTransferRequests($userId);
                            foreach ($requests as $row):
                                $statusClass = 'secondary';
                                if ($row['status'] === 'Pending') {
                                    $statusClass = 'warning text-dark';
                                } elseif ($row['status'] === 'Approved') {
                                    $statusClass = 'success';
                                } elseif ($row['status'] === 'Disapproved') {
                                    $statusClass = 'danger';
                                }
                                ?>
                                <tr>
                                    <td class="align-middle text-uppercase small">
                                        <?= toDateTime($row['created_at']) ?>
                                    </td>
                                    <td class="align-middle text-left small">
                                        <strong>From:</strong> <?= e(stationName($row['current_station_id'])) ?><br>
                                        <strong>To:</strong> <?= e(stationName($row['target_station_id'])) ?>
                                        <?php if (!empty($row['specialization'])): ?>
                                            <br><strong>Specialization:</strong> <?= e($row['specialization']) ?>
                                        <?php endif; ?>
                                        <?php if (!empty($row['reason'])): ?>
                                            <br><strong>Reason:</strong> <?= e($row['reason']) ?>
                                        <?php endif; ?>
                                        <?php if (!empty($row['remarks'])): ?>
                                            <br><strong>Remarks:</strong>
                                            <?= e($row['remarks']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle small">
                                        <span class="badge badge-<?= $statusClass ?> py-1 px-2 text-uppercase mb-1">
                                            <?= e($row['status']) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php if ($row['status'] === 'Pending'): ?>
                                                    <?php modalDropdownItem(uri() . '/modules/transfer-request/cancel-request-dialog.php?id=' . cipher($row['id']), 'Cancel Request', 'fa-times', 'Cancel Transfer Request'); ?>
                                                <?php else: ?>
                                                    <?php linkDropdownItem(uri() . '/' . e($row['attachment_path']), 'View Attachment', 'fa-eye', 'View Document Attachment', true); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="small">
                                <th class="align-middle" width="10%">Date Requested</th>
                                <th class="align-middle" width="70%">Assignment Details</th>
                                <th class="align-middle" width="15%">Status</th>
                                <th class="align-middle" width="5%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Show selected file name in custom file input labels
        document.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('custom-file-input')) {
                let fileName = e.target.files[0] ? e.target.files[0].name : "Choose file...";
                let nextLabel = e.target.nextElementSibling;
                if (nextLabel && nextLabel.classList.contains('custom-file-label')) {
                    nextLabel.innerText = fileName;
                }
            }
        });
    });
</script>