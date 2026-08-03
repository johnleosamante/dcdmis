<?php
// modules/pm/ipcrf-details.php - View IPCRF details
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$ipcrfId = (int) sanitize(decode($_GET['id'] ?? null));
$ipcrf = pmIpcrf($ipcrfId);

if (!$ipcrf) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$isOwner = ($userId === (int) $ipcrf['employee_id']);
$isValidator = ($userId === (int) $ipcrf['validator_id']);

if (!$isOwner && !$isValidator) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employee = employee($ipcrf['employee_id']);
$validator = $ipcrf['validator_id'] ? employee($ipcrf['validator_id']) : null;
$objectives = pmObjectives($ipcrfId);
$movList = pmMovByIpcrf($ipcrfId);

// Phase 4 data
$developmentPlans = ($ipcrf['phase'] >= 4) ? pmDevelopmentPlans($ipcrfId) : [];

// Overall rating totals
$totalWeight = array_sum(array_map('floatval', array_column($objectives, 'weight')));
$totalScore = array_sum(array_map('floatval', array_column($objectives, 'score')));

$isDraft = ($ipcrf['status'] === 'Draft' || $ipcrf['status'] === 'Returned');
$canEdit = $isOwner && $isDraft;
$canSubmit = $isOwner && $isDraft && !empty($objectives);

$adjectivalRating = pmAdjectivalRating($totalScore);
$footerColspan = $canEdit ? 12 : 11;

// Group objectives by KRA for display (each KRA title forms a distinct group)
$kraGroups = [];
foreach ($objectives as $obj) {
    $groupKey = $obj['kra_id'] . '|' . strtolower(trim($obj['kra_title']));
    if (!isset($kraGroups[$groupKey])) {
        $kraGroups[$groupKey] = [
            'title' => $obj['kra_title'],
            'weight' => $obj['kra_weight'],
            'objectives' => []
        ];
    }
    $kraGroups[$groupKey]['objectives'][] = $obj;
}

// Get position title
$positionData = position($ipcrf['employee_id']);
$positionTitle = $ipcrf['position_title'] ?: ($positionData['official_title'] ?? '');

// Get approving officer and section heads for dropdown
$approvingOfficer = isset($ipcrf['approving_officer_id']) && $ipcrf['approving_officer_id'] ? employee($ipcrf['approving_officer_id']) : null;
$sectionHeads = pmSectionHeads();

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item active">IPCRF Details</li>
        </ol>
    </nav>
    <div>
        <?= pmStatusBadge($ipcrf['status']) ?>
        <span class="badge badge-light px-2 py-1 ml-1">Phase <?= e($ipcrf['phase']) ?></span>
    </div>
</div>

<!-- IPCRF Header Card -->
<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold text-center">
            INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM <?= e($ipcrf['school_year']) ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="30%">Name:</td>
                        <td class="text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Position:</td>
                        <td><?= e($positionTitle) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Review Period:</td>
                        <td><?= e($ipcrf['review_period'] ?? $ipcrf['school_year']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Division:</td>
                        <td>Dipolog City</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="30%">Name of Rater:</td>
                        <td class="text-uppercase">
                            <?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '<span class="text-muted">Not assigned</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Position:</td>
                        <td><?php 
                            if ($validator) {
                                $vPos = position($validator['id']);
                                echo $vPos ? e($vPos['official_title']) : '-';
                            } else {
                                echo '-';
                            }
                        ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Review Date:</td>
                        <td><?= $ipcrf['validated_at'] ? date('F j, Y', strtotime($ipcrf['validated_at'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Rating Period:</td>
                        <td><?= e($ipcrf['school_year']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Approving Authority:</td>
                        <td>
                            <?php 
                            $canEditApproving = $isOwner && in_array($ipcrf['status'], ['Draft', 'Returned', 'Submitted', 'Approved']);
                            ?>
                            <?php if ($canEditApproving): ?>
                                <form action="" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                    <div class="input-group input-group-sm">
                                        <select name="approving_officer_id" class="form-control form-control-sm" required>
                                            <option value="">-- Select Approving Authority --</option>
                                            <?php foreach ($sectionHeads as $head): ?>
                                                <option value="<?= cipher($head['employee_id']) ?>" 
                                                    <?= ($approvingOfficer && $approvingOfficer['id'] == $head['employee_id']) ? 'selected' : '' ?>>
                                                    <?= e($head['name']) ?> - <?= e($head['position_title']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" name="update-approving-officer" class="btn btn-sm btn-primary">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php elseif ($approvingOfficer): ?>
                                <span class="text-uppercase"><?= e(toName($approvingOfficer['last_name'], $approvingOfficer['first_name'], $approvingOfficer['middle_name'], $approvingOfficer['name_extension'])) ?></span>
                                <?php 
                                    $aoPos = position($approvingOfficer['id']);
                                    if ($aoPos) echo '<br><small class="text-muted">' . e($aoPos['official_title']) . '</small>';
                                ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if ($ipcrf['final_rating']): ?>
            <div class="alert alert-success mt-3 mb-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <strong>Final Rating:</strong> 
                        <span class="h4 mb-0 ml-2"><?= number_format($ipcrf['final_rating'], 2) ?></span>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <strong>Adjectival Rating:</strong> 
                        <span class="h4 mb-0 ml-2"><?= e($ipcrf['adjectival_rating']) ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Phase Indicator -->
<div class="card shadow mb-4">
    <div class="card-body py-2">
        <div class="d-flex justify-content-between align-items-center">
            <?php for ($p = 1; $p <= 4; $p++): ?>
                <div class="text-center flex-fill <?= $p < 4 ? 'border-right' : '' ?>">
                    <span class="badge <?= $ipcrf['phase'] >= $p ? 'badge-primary' : 'badge-light' ?> px-3 py-2">
                        Phase <?= $p ?>
                    </span>
                    <div class="small text-muted mt-1"><?= e(pmPhaseLabel($p)) ?></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- KRAs and Objectives Table -->
<?php if (empty($kraGroups)): ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-circle mr-1"></i> No objectives defined yet.
        <?php if ($canEdit): ?>
            <a href="<?= customUri('pis', 'Add Objective', $ipcrfId) ?>" class="btn btn-sm btn-warning ml-2">
                <i class="fas fa-plus mr-1"></i> Add Objectives
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="card shadow mb-4">
        <div class="card-header py-2 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Performance Objectives</h6>
                <?php if ($canEdit): ?>
                    <a href="<?= customUri('pis', 'Add Objective', $ipcrfId) ?>" class="btn btn-sm btn-outline-primary mr-2">
                        <i class="fas fa-plus mr-1"></i> Add KRA
                    </a>
                    <a href="<?= customUri('pis', 'Add Objective', $ipcrfId) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus mr-1"></i> Add Objective
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0" id="ipcrf-table">
                    <thead class="bg-light">
                        <tr class="text-center small">
                            <th width="20%">KRA</th>
                            <th width="25%">Objectives</th>
                            <th width="10%">Timeline</th>
                            <th width="6%">Weight</th>
                            <th width="20%">Performance Indicator</th>
                            <th width="10%">Actual Results</th>
                            <th width="3%">Q</th>
                            <th width="3%">E</th>
                            <th width="3%">T</th>
                            <th width="5%">Ave</th>
                            <th width="5%">Score</th>
                            <?php if ($canEdit): ?>
                            <th width="5%">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kraGroups as $kraId => $kra): ?>
                            <?php $firstRow = true; $rowCount = count($kra['objectives']); ?>
                            <?php foreach ($kra['objectives'] as $oi => $obj): ?>
                                <tr class="small">
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
                                    <td class="align-middle text-center"><?= $obj['rating_q'] ?? '-' ?></td>
                                    <td class="align-middle text-center"><?= $obj['rating_e'] ?? '-' ?></td>
                                    <td class="align-middle text-center"><?= $obj['rating_t'] ?? '-' ?></td>
                                    <td class="align-middle text-center font-weight-bold">
                                        <?= $obj['average_rating'] ? number_format($obj['average_rating'], 2) : '-' ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?= $obj['score'] ? number_format($obj['score'], 2) : '-' ?>
                                    </td>
                                    <?php if ($canEdit): ?>
                                    <td class="align-middle text-center">
                                        <a href="<?= customUri('pis', 'Edit Objective', $obj['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit fa-sm"></i>
                                        </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <tr class="small bg-light font-weight-bold text-center">
                            <td colspan="3" class="align-middle text-left">OVERALL RATING FOR ACCOMPLISHMENTS</td>
                            <td class="align-middle"><?= number_format($totalWeight, 0) ?>%</td>
                            <td colspan="6" class="align-middle text-right">Total Score</td>
                            <td class="align-middle"><?= number_format($totalScore, 2) ?></td>
                            <?php if ($canEdit): ?>
                            <td></td>
                            <?php endif; ?>
                        </tr>
                        <tr class="small bg-light font-weight-bold text-center">
                            <td colspan="<?= $footerColspan ?>" class="align-middle text-right">
                                Adjectival Rating: <span class="badge badge-info"><?= e($adjectivalRating) ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Remarks Section -->
<?php if ($ipcrf['ratee_remarks'] || $ipcrf['validator_remarks']): ?>
    <div class="row mb-4">
        <?php if ($ipcrf['ratee_remarks']): ?>
            <div class="col-md-6">
                <div class="card border-left-info h-100">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-info">Ratee Remarks</h6>
                        <p class="mb-0"><?= nl2br(e($ipcrf['ratee_remarks'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($ipcrf['validator_remarks']): ?>
            <div class="col-md-6">
                <div class="card border-left-success h-100">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-success">Validator Remarks</h6>
                        <p class="mb-0"><?= nl2br(e($ipcrf['validator_remarks'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Means of Verification -->
<?php if (!empty($movList) || $isOwner): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-file-upload mr-1"></i> Means of Verification (MOV)
                </h6>
                <?php if ($isOwner && ($ipcrf['phase'] >= 2)): ?>
                    <a href="<?= customUri('pis', 'Upload MOV', $ipcrfId) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-upload mr-1"></i> Upload MOV
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($movList)): ?>
                <p class="text-muted text-center mb-0">No means of verification uploaded yet.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr class="small">
                                <th>KRA</th>
                                <th>Objective</th>
                                <th>File</th>
                                <th>Description</th>
                                <th>Uploaded</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movList as $mov): ?>
                                <tr class="small">
                                    <td><?= e($mov['kra_title']) ?></td>
                                    <td><?= e(substr($mov['objective'], 0, 50)) ?>...</td>
                                    <td>
                                        <i class="fas fa-file mr-1"></i>
                                        <?= e($mov['original_name']) ?>
                                    </td>
                                    <td><?= e($mov['description'] ?? '-') ?></td>
                                    <td><?= date('M d, Y', strtotime($mov['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= uri() ?>/uploads/mov/<?= e($mov['file_name']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye fa-sm"></i>
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
<?php endif; ?>

<!-- Part IV: Development Plans (Phase 4) -->
<?php if ($ipcrf['phase'] >= 4 && !empty($developmentPlans)): ?>
<div class="card shadow mb-4">
    <div class="card-header py-2 bg-success text-white d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-award mr-1"></i> Part IV: Development Plans
        </h6>
        <a href="<?= customUri('pis', 'Phase 4', $ipcrfId) ?>" class="btn btn-sm btn-light">
            <i class="fas fa-external-link-alt mr-1"></i> View Full Phase 4
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered small mb-0">
                <thead class="bg-light">
                    <tr class="text-center">
                        <th width="15%">Strengths</th>
                        <th width="18%">Development Needs</th>
                        <th width="30%">Action Plan<br><small>(Recommended Development Intervention)</small></th>
                        <th width="17%">Timeline</th>
                        <th width="20%">Resources Needed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($developmentPlans as $plan): ?>
                    <tr>
                        <td><?= nl2br(e($plan['strengths'])) ?></td>
                        <td><?= nl2br(e($plan['development_needs'])) ?></td>
                        <td><?= nl2br(e($plan['action_plan'])) ?></td>
                        <td class="text-center"><?= nl2br(e($plan['timeline'])) ?></td>
                        <td><?= nl2br(e($plan['resources'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Action Buttons -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= customUri('pis', 'IPCRF', $userId) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to IPCRF
            </a>
            
            <div>
                <?php if ($canSubmit): ?>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#submitModal">
                        <i class="fas fa-paper-plane mr-1"></i> Submit for Validation
                    </button>
                <?php endif; ?>
                
                <?php if ($isOwner && $ipcrf['phase'] >= 2 && $ipcrf['phase'] < 4): ?>
                    <a href="<?= customUri('pis', 'Phase 2', $ipcrfId) ?>" class="btn btn-info">
                        <i class="fas fa-edit mr-1"></i> Update Actual Results
                    </a>
                <?php endif; ?>
                
                <?php if ($ipcrf['phase'] >= 2): ?>
                    <a href="<?= customUri('pis', 'Coaching Form', $ipcrfId) ?>" class="btn btn-warning">
                        <i class="fas fa-clipboard-list mr-1"></i> Coaching Form
                    </a>
                <?php endif; ?>
                
                <?php if ($ipcrf['phase'] >= 2 && $ipcrf['phase'] <= 3): ?>
                    <a href="<?= customUri('pis', 'Recalibration Form', $ipcrfId) ?>" class="btn btn-info">
                        <i class="fas fa-balance-scale mr-1"></i> Recalibration Form
                    </a>
                <?php endif; ?>
                
                <?php if ($ipcrf['phase'] >= 4): ?>
                    <a href="<?= customUri('pis', 'Phase 4', $ipcrfId) ?>" class="btn btn-success">
                        <i class="fas fa-clipboard-list mr-1"></i> Development Planning
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Print IPCRF -->
<div class="card shadow mb-4 no-print">
    <div class="card-body text-right">
        <a href="<?= customUri('pis', 'Print IPCRF', $ipcrfId) ?>" target="_blank" class="btn btn-dark">
            <i class="fas fa-print mr-1"></i> Print IPCRF
        </a>
    </div>
</div>

<!-- Submit Modal -->
<?php if ($canSubmit): ?>
<div class="modal fade" id="submitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Submit IPCRF for Validation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to submit this IPCRF for validation?</p>
                    <p class="text-warning small">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Once submitted, you cannot edit your objectives until the validator returns it.
                    </p>
                    <div class="form-group">
                        <label class="font-weight-bold">Remarks (Optional)</label>
                        <textarea name="ratee_remarks" class="form-control" rows="3" 
                            placeholder="Any remarks for your rater..."><?= e($ipcrf['ratee_remarks'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit-ipcrf" class="btn btn-success">
                        <i class="fas fa-paper-plane mr-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
