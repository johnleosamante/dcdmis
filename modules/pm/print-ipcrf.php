<?php
// modules/pm/print-ipcrf.php - Print-friendly IPCRF view
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
$approvingOfficer = !empty($ipcrf['approving_officer_id']) ? employee($ipcrf['approving_officer_id']) : null;
$positionData = position($ipcrf['employee_id']);
$positionTitle = $ipcrf['position_title'] ?: ($positionData['official_title'] ?? '');
$objectives = pmObjectives($ipcrfId);
$movList = pmMovByIpcrf($ipcrfId);
$coachingEntries = pmCoachingEntries($ipcrfId);
$recalibrations = pmRecalibrations($ipcrfId);
$developmentPlans = pmDevelopmentPlans($ipcrfId);
$competencyRatings = pmCompetencyRatings($ipcrfId);
?>

<style>
    @page {
        size: landscape;
        margin: 10mm;
    }
    @media print {
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        #print-area { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
        .no-print { display: none !important; }
        .btn, .navbar, #accordionSidebar, .topbar { display: none !important; }
    }
    .ipcrf-table, .ipcrf-table th, .ipcrf-table td {
        border: 1px solid #000;
        border-collapse: collapse;
    }
    .ipcrf-table th, .ipcrf-table td {
        padding: 4px 6px;
        font-size: 11px;
        vertical-align: top;
    }
    .ipcrf-table th { text-align: center; background: #fff; font-weight: bold; }
    .ipcrf-section-title {
        text-align: center;
        font-weight: bold;
        border: 1px solid #000;
        padding: 4px;
        margin-top: 10px;
        margin-bottom: 0;
        font-size: 12px;
    }
    .ipcrf-header { font-size: 12px; }
    .ipcrf-header td { border: none; padding: 2px 4px; }
    .text-xs { font-size: 10px; }
    .text-center { text-align: center; }
    .border { border: 1px solid #000; }
    .border-bottom { border-bottom: 1px solid #000; }
    .signature-line { border-top: 1px solid #000; margin-top: 30px; padding-top: 2px; font-size: 11px; }
</style>

<div id="print-area" class="container-fluid mt-3">
    <div class="text-center no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary btn-lg">
            <i class="fas fa-print mr-1"></i> Print IPCRF
        </button>
        <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="text-center font-weight-bold text-uppercase mb-4">
                Individual Performance Commitment and Review Form<br>
                <small class="text-muted">DepEd Schools Division of Dipolog City</small>
            </h5>

            <table class="table table-sm table-bordered mb-4">
                <tr>
                    <td class="print-label">Ratee:</td>
                    <td class="text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></td>
                </tr>
                <tr>
                    <td class="print-label">Position:</td>
                    <td><?= e($positionTitle) ?></td>
                </tr>
                <tr>
                    <td class="print-label">Rating Period:</td>
                    <td><?= e($ipcrf['school_year']) ?></td>
                </tr>
                <tr>
                    <td class="print-label">Review Period:</td>
                    <td><?= e($ipcrf['review_period'] ?? $ipcrf['school_year']) ?></td>
                </tr>
                <tr>
                    <td class="print-label">Rater:</td>
                    <td class="text-uppercase">
                        <?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '<span class="text-muted">Not assigned</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td class="print-label">Approving Authority:</td>
                    <td class="text-uppercase">
                        <?= $approvingOfficer ? e(toName($approvingOfficer['last_name'], $approvingOfficer['first_name'], $approvingOfficer['middle_name'], $approvingOfficer['name_extension'])) : '<span class="text-muted">Not assigned</span>' ?>
                    </td>
                </tr>
                <tr>
                    <td class="print-label">Status / Phase:</td>
                    <td><?= e($ipcrf['status']) ?> (Phase <?= e($ipcrf['phase']) ?>)</td>
                </tr>
            </table>

            <?php if (!empty($objectives)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Objectives and Ratings</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">KRA</th>
                            <th>Objective</th>
                            <th width="10%">Q</th>
                            <th width="10%">E</th>
                            <th width="10%">T</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($objectives as $obj): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= e($obj['kra_title']) ?></td>
                                <td><?= e($obj['objective']) ?></td>
                                <td class="text-center"><?= $obj['rating_q'] !== null ? e($obj['rating_q']) : '-' ?></td>
                                <td class="text-center"><?= $obj['rating_e'] !== null ? e($obj['rating_e']) : '-' ?></td>
                                <td class="text-center"><?= $obj['rating_t'] !== null ? e($obj['rating_t']) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if ($ipcrf['final_rating']): ?>
                <table class="table table-sm table-bordered mb-4">
                    <tr>
                        <td class="print-label">Final Rating:</td>
                        <td class="font-weight-bold"><?= e($ipcrf['final_rating']) ?> (<?= e($ipcrf['adjectival_rating'] ?? '') ?>)</td>
                    </tr>
                    <tr>
                        <td class="print-label">Rater Remarks:</td>
                        <td><?= e($ipcrf['validator_remarks'] ?? '-') ?></td>
                    </tr>
                </table>
            <?php endif; ?>

            <?php if (!empty($movList)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Means of Verification</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>KRA</th>
                            <th>Objective</th>
                            <th>File</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($movList as $mov): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= e($mov['kra_title']) ?></td>
                                <td><?= e($mov['objective']) ?></td>
                                <td><?= e($mov['original_name']) ?></td>
                                <td><?= e($mov['description'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (!empty($coachingEntries)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Coaching Entries</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>Date</th>
                            <th>KRA / Objective</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($coachingEntries as $c): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                                <td><?= e($c['kra_title']) ?> - <?= e($c['objective']) ?></td>
                                <td><?= e($c['remarks'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (!empty($recalibrations)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Recalibration Entries</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>IPCRF Content</th>
                            <th>Proposed Amendment</th>
                            <th>Justification</th>
                            <th>Rater Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($recalibrations as $r): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= e($r['ipcrf_content']) ?></td>
                                <td><?= e($r['proposed_amendment']) ?></td>
                                <td><?= e($r['justification']) ?></td>
                                <td class="text-center"><?= e($r['rater_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (!empty($developmentPlans)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Development Plans</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>Strengths</th>
                            <th>Development Needs</th>
                            <th>Action Plan</th>
                            <th>Timeline</th>
                            <th>Resources</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($developmentPlans as $dp): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= e($dp['strengths']) ?></td>
                                <td><?= e($dp['development_needs']) ?></td>
                                <td><?= e($dp['action_plan']) ?></td>
                                <td><?= e($dp['timeline']) ?></td>
                                <td><?= e($dp['resources']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <?php if (!empty($competencyRatings)): ?>
                <h6 class="font-weight-bold text-uppercase mt-4 mb-2">Competency Ratings</h6>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>Category</th>
                            <th>Competency #</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($competencyRatings as $cr): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><?= e($cr['category']) ?></td>
                                <td><?= e($cr['competency_number']) ?></td>
                                <td class="text-center"><?= e($cr['rating']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div class="mt-5 row">
                <div class="col-md-4 text-center">
                    <div class="border-bottom border-dark mb-2 pb-1 text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></div>
                    <small>Ratee</small>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border-bottom border-dark mb-2 pb-1 text-uppercase">
                        <?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '________________' ?>
                    </div>
                    <small>Rater</small>
                </div>
                <div class="col-md-4 text-center">
                    <div class="border-bottom border-dark mb-2 pb-1 text-uppercase">
                        <?= $approvingOfficer ? e(toName($approvingOfficer['last_name'], $approvingOfficer['first_name'], $approvingOfficer['middle_name'], $approvingOfficer['name_extension'])) : '________________' ?>
                    </div>
                    <small>Approving Authority</small>
                </div>
            </div>
        </div>
    </div>
</div>
