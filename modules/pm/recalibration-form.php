<?php
// modules/pm/recalibration-form.php - Individual Performance Recalibration Form (Phases 2 & 3)
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

// Recalibration is available in Phase 2 and Phase 3 only
if ($ipcrf['phase'] < 2 || $ipcrf['phase'] > 3) {
    redirect(customUri('pis', 'IPCRF Details', $ipcrfId));
}

$employee = employee($ipcrf['employee_id']);
$validator = $ipcrf['validator_id'] ? employee($ipcrf['validator_id']) : null;
$recalibrations = pmRecalibrations($ipcrfId);

$canEditRatee = ($isOwner && $ipcrf['phase'] >= 2 && $ipcrf['phase'] <= 3);
$canEditRater = $isValidator;

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Recalibration Form</li>
        </ol>
    </nav>
</div>

<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-info text-uppercase">
            <i class="fas fa-balance-scale mr-1"></i> Individual Performance Calibration Form
        </h6>
        <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to Details
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="bg-light text-center small text-uppercase">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">IPCRF Content<br><small class="text-muted font-weight-normal">(Based from approved IPCRF)</small></th>
                        <th width="25%">Proposed Amendment</th>
                        <th width="25%">Justification</th>
                        <th width="20%">Rater Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recalibrations)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No recalibration entries yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recalibrations as $i => $entry): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i + 1 ?></td>
                                <td class="align-middle small"><?= nl2br(e($entry['ipcrf_content'])) ?></td>
                                <td class="align-middle small"><?= nl2br(e($entry['proposed_amendment'])) ?></td>
                                <td class="align-middle small"><?= nl2br(e($entry['justification'])) ?></td>
                                <td class="align-middle small">
                                    <form action="" method="POST" class="mb-0">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="recalibration_id" value="<?= cipher($entry['id']) ?>">
                                        <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="rater_status" value="Approved" id="statusApproved<?= $entry['id'] ?>" <?= $entry['rater_status'] === 'Approved' ? 'checked' : '' ?> <?= $canEditRater ? '' : 'disabled' ?>>
                                            <label class="form-check-label" for="statusApproved<?= $entry['id'] ?>">Approved</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="rater_status" value="Disapproved" id="statusDisapproved<?= $entry['id'] ?>" <?= $entry['rater_status'] === 'Disapproved' ? 'checked' : '' ?> <?= $canEditRater ? '' : 'disabled' ?>>
                                            <label class="form-check-label" for="statusDisapproved<?= $entry['id'] ?>">Disapproved</label>
                                        </div>
                                        <label class="small font-weight-bold mt-1 mb-0">Remarks:</label>
                                        <textarea name="rater_remarks" class="form-control form-control-sm" rows="2" <?= $canEditRater ? '' : 'readonly' ?>><?= e($entry['rater_remarks']) ?></textarea>
                                        <?php if ($canEditRater): ?>
                                            <button type="submit" name="update-recalibration-rater" class="btn btn-sm btn-primary mt-2" onclick="return confirm('Are you sure you want to save this rater remark?')">
                                                <i class="fas fa-save mr-1"></i> Save
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($canEditRatee): ?>
            <form action="" method="POST" class="mt-4">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <h6 class="font-weight-bold text-info mb-3"><i class="fas fa-plus mr-1"></i> Add Recalibration Entry</h6>
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small">IPCRF Content</label>
                        <textarea name="ipcrf_content" class="form-control form-control-sm" rows="4" required placeholder="Current IPCRF objective, timeline, weight, etc."></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small">Proposed Amendment</label>
                        <textarea name="proposed_amendment" class="form-control form-control-sm" rows="4" required placeholder="Proposed change"></textarea>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small">Justification</label>
                        <textarea name="justification" class="form-control form-control-sm" rows="4" required placeholder="Reason for the amendment"></textarea>
                    </div>
                </div>
                <button type="submit" name="add-recalibration" class="btn btn-info btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Entry
                </button>
            </form>
        <?php elseif ($isOwner && ($ipcrf['phase'] < 2 || $ipcrf['phase'] > 3)): ?>
            <div class="alert alert-info mt-3 mb-0 small">
                <i class="fas fa-info-circle mr-1"></i> Recalibration entries can only be added in Phase 2 and Phase 3.
            </div>
        <?php endif; ?>
    </div>
</div>
