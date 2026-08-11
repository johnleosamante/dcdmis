<?php
// modules/pm/page.php - IPCRF Dashboard
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

if ($userId !== $employeeId || !employee($employeeId)) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employee = employee($employeeId);

// Check if PM tables exist
try {
    $activeCycle = pmActiveCycle();
    $myIpcrfList = pmIpcrfList($employeeId);
    $rateeList = $activeCycle ? pmIpcrfByValidator($employeeId, $activeCycle['id']) : [];
    $currentIpcrf = $activeCycle ? pmIpcrfByEmployee($employeeId, $activeCycle['id']) : null;
    $tablesExist = true;
} catch (Exception $e) {
    $activeCycle = null;
    $myIpcrfList = [];
    $rateeList = [];
    $currentIpcrf = null;
    $tablesExist = false;
}

$pendingRequests = [];

// Get position title
$positionData = position($employeeId);
$positionTitle = $positionData['official_title'] ?? '';

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">IPCRF</li>
        </ol>
    </nav>
</div>

<!-- Database Setup Warning -->
<?php if (!$tablesExist): ?>
    <div class="alert alert-danger mt-3">
        <h5 class="alert-heading"><i class="fas fa-database mr-2"></i> Database Setup Required</h5>
        <p class="mb-2">The IPCRF database tables have not been created yet. Please run the SQL schema file to set up the required tables.</p>
        <hr>
        <p class="mb-0 small">
            <strong>File location:</strong> <code>c:\xampp\htdocs\depeddipolog\public\pm_schema.sql</code><br>
            Import this file using phpMyAdmin or MySQL command line.
        </p>
    </div>
<?php else: ?>

<!-- Active Cycle Info -->
<?php if ($activeCycle): ?>
    <div class="alert alert-info d-flex align-items-center justify-content-between small p-2 mt-3">
        <div class="d-flex align-items-center">
            <i class="fas fa-calendar-alt mr-2"></i>
            <div>
                <strong>Active Rating Period:</strong> <?= e($activeCycle['title']) ?> (<?= e($activeCycle['school_year']) ?>)
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning d-flex align-items-center justify-content-between small p-2 mt-3">
        <div>
            <i class="fas fa-exclamation-circle mr-2"></i>
            No active rating period. Please create a rating period to proceed.
        </div>
        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#createCycleModal">
            <i class="fas fa-plus mr-1"></i> Create Rating Period
        </button>
    </div>
<?php endif; ?>

<!-- Create Rating Period Modal -->
<?php if (!$activeCycle): ?>
<div class="modal fade" id="createCycleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold"><i class="fas fa-calendar-alt mr-1"></i> Create Rating Period</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-weight-bold small">Title <?php showAsterisk() ?></label>
                    <input type="text" name="cycle_title" class="form-control form-control-sm" placeholder="e.g. RPMS 2025-2026" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold small">School Year <?php showAsterisk() ?></label>
                    <input type="text" name="cycle_school_year" class="form-control form-control-sm" placeholder="e.g. 2025-2026" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="submit" name="create-rating-period" class="btn btn-primary btn-sm">
                    <i class="fas fa-save mr-1"></i> Create Period
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- Quick Stats Cards -->
<?php if ($activeCycle): ?>
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Current Phase</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $currentIpcrf ? 'Phase ' . $currentIpcrf['phase'] : 'Not Started' ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $currentIpcrf ? $currentIpcrf['status'] : 'No IPCRF' ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>

<!-- My IPCRF Section -->
<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">
                <i class="fas fa-file-alt mr-1"></i> My IPCRF
            </h6>
            <?php if ($activeCycle && !$currentIpcrf): ?>
                <a href="<?= customUri('pis', 'Create IPCRF', $employeeId) ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus fa-sm mr-1"></i> Create IPCRF
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($myIpcrfList)): ?>
            <div class="text-center py-4">
                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No IPCRF records found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="text-center small text-uppercase">
                            <th class="align-middle">Rating Period</th>
                            <th class="align-middle">School Year</th>
                            <th class="align-middle">Phase</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Final Rating</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($myIpcrfList as $ipcrf): ?>
                            <tr class="text-center">
                                <td class="align-middle"><?= e($ipcrf['cycle_title']) ?></td>
                                <td class="align-middle"><?= e($ipcrf['school_year']) ?></td>
                                <td class="align-middle">
                                    <span class="badge badge-light px-2 py-1">Phase <?= e($ipcrf['phase']) ?></span>
                                </td>
                                <td class="align-middle"><?= pmStatusBadge($ipcrf['status']) ?></td>
                                <td class="align-middle">
                                    <?php if ($ipcrf['final_rating']): ?>
                                        <strong><?= number_format($ipcrf['final_rating'], 2) ?></strong>
                                        <br><small class="text-muted"><?= e($ipcrf['adjectival_rating']) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <a href="<?= customUri('pis', 'IPCRF Details', $ipcrf['id']) ?>" class="btn btn-sm btn-outline-primary" title="View IPCRF">
                                        <i class="fas fa-eye fa-sm"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Validator Section - Ratees to Review -->
<?php if (!empty($rateeList)): ?>
    <div class="card border-left-success shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success text-uppercase">
                <i class="fas fa-user-check mr-1"></i> Ratees for Review (As Rater)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="text-center small text-uppercase">
                            <th class="align-middle">Ratee Name</th>
                            <th class="align-middle">Rating Period</th>
                            <th class="align-middle">Phase</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Final Rating</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rateeList as $ratee): ?>
                            <tr class="text-center">
                                <td class="align-middle text-uppercase text-left"><?= e($ratee['ratee_name']) ?></td>
                                <td class="align-middle"><?= e($ratee['cycle_title']) ?></td>
                                <td class="align-middle">
                                    <span class="badge badge-light px-2 py-1">Phase <?= e($ratee['phase']) ?></span>
                                </td>
                                <td class="align-middle"><?= pmStatusBadge($ratee['status']) ?></td>
                                <td class="align-middle">
                                    <?php if ($ratee['final_rating']): ?>
                                        <strong><?= number_format($ratee['final_rating'], 2) ?></strong>
                                        <br><small class="text-muted"><?= e($ratee['adjectival_rating']) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <a href="<?= customUri('pis', 'Review IPCRF', $ratee['id']) ?>" class="btn btn-sm btn-outline-success" title="Review">
                                        <i class="fas fa-clipboard-check fa-sm"></i> Review
                                    </a>
                                    <a href="<?= customUri('pis', 'IPCRF Details', $ratee['id']) ?>" class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye fa-sm"></i>
                                    </a>
                                    <?php if ((int) $ratee['phase'] >= 4): ?>
                                        <a href="<?= customUri('pis', 'Phase 4', $ratee['id']) ?>" class="btn btn-sm btn-success" title="Development Planning">
                                            <i class="fas fa-award fa-sm"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Rater View Modals -->
<?php foreach ($rateeList as $ratee): ?>
    <?php
    $viewRateePosition = position($ratee['employee_id']);
    $viewRateePositionTitle = $viewRateePosition['official_title'] ?? '-';
    $viewObjectives = pmObjectives($ratee['id']);
    $viewKraGroups = [];
    foreach ($viewObjectives as $obj) {
        $groupKey = $obj['kra_id'] . '|' . strtolower(trim($obj['kra_title']));
        if (!isset($viewKraGroups[$groupKey])) {
            $viewKraGroups[$groupKey] = [
                'title' => $obj['kra_title'],
                'weight' => $obj['kra_weight'],
                'objectives' => []
            ];
        }
        $viewKraGroups[$groupKey]['objectives'][] = $obj;
    }
    ?>
    <div class="modal fade" id="raterViewModal<?= $ratee['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-eye mr-2"></i> IPCRF View - <?= e($ratee['ratee_name']) ?>
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row small mb-3">
                        <div class="col-md-6">
                            <strong>Ratee:</strong> <?= e($ratee['ratee_name']) ?><br>
                            <strong>Position:</strong> <?= e($viewRateePositionTitle) ?><br>
                            <strong>Review Period:</strong> <?= e($ratee['school_year'] ?: '-') ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Rater:</strong> <?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?><br>
                            <strong>Position:</strong> <?= e($positionTitle) ?><br>
                            <strong>Status:</strong> <?= e($ratee['status']) ?>
                        </div>
                    </div>

                    <?php if (empty($viewKraGroups)): ?>
                        <div class="alert alert-warning">No objectives defined yet.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm small">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th width="18%">KRA</th>
                                        <th width="25%">Objectives</th>
                                        <th width="10%">Timeline</th>
                                        <th width="6%">Weight</th>
                                        <th width="22%">Performance Indicator</th>
                                        <th width="12%">Actual Results</th>
                                        <th width="7%">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewKraGroups as $kraId => $kra): ?>
                                        <?php $firstRow = true; $rowCount = count($kra['objectives']); ?>
                                        <?php foreach ($kra['objectives'] as $obj): ?>
                                            <tr>
                                                <?php if ($firstRow): ?>
                                                    <td rowspan="<?= $rowCount ?>" class="align-middle font-weight-bold bg-light">
                                                        <?= e($kra['title']) ?>
                                                    </td>
                                                    <?php $firstRow = false; ?>
                                                <?php endif; ?>
                                                <td class="align-middle"><?= e($obj['objective']) ?></td>
                                                <td class="align-middle text-center"><?= e($obj['timeline'] ?? '-') ?></td>
                                                <td class="align-middle text-center font-weight-bold"><?= e($obj['weight']) ?>%</td>
                                                <td class="align-middle"><?= nl2br(e($obj['performance_indicator'] ?? '-')) ?></td>
                                                <td class="align-middle"><?= e($obj['actual_result'] ?? '-') ?></td>
                                                <td class="align-middle text-center">
                                                    Q: <?= $obj['rating_q'] ?? '-' ?><br>
                                                    E: <?= $obj['rating_e'] ?? '-' ?><br>
                                                    T: <?= $obj['rating_t'] ?? '-' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?= customUri('pis', 'Review IPCRF', $ratee['id']) ?>" class="btn btn-success">
                        <i class="fas fa-clipboard-check mr-1"></i> Review / Rate
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php endif; // End tablesExist check ?>

