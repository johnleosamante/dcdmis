<?php
// modules/pm/coaching-form.php - Performance Monitoring and Coaching Form (Phase 2)
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

// Phase 2 is for monitoring and coaching
if ($ipcrf['phase'] < 2) {
    redirect(customUri('pis', 'IPCRF Details', $ipcrfId));
}

$employee = employee($ipcrf['employee_id']);
$validator = $ipcrf['validator_id'] ? employee($ipcrf['validator_id']) : null;
$objectives = pmObjectives($ipcrfId);
$coachingEntries = pmCoachingEntries($ipcrfId);

// Get position titles
$rateePosition = position($ipcrf['employee_id']);
$rateePositionTitle = $ipcrf['position_title'] ?: ($rateePosition['official_title'] ?? '');
$validatorPosition = $validator ? position($validator['id']) : null;
$validatorPositionTitle = $validatorPosition['official_title'] ?? '';

// Group objectives by KRA
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

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Coaching Form</li>
        </ol>
    </nav>
    <div>
        <?= pmStatusBadge($ipcrf['status']) ?>
        <span class="badge badge-light px-2 py-1 ml-1">Phase <?= e($ipcrf['phase']) ?></span>
    </div>
</div>

<!-- Header Card -->
<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3 bg-info text-white">
        <h6 class="m-0 font-weight-bold text-center">
            PERFORMANCE MONITORING AND COACHING FORM
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="35%">Name of Employee:</td>
                        <td class="text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Position:</td>
                        <td><?= e($rateePositionTitle) ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="35%">Rating Period:</td>
                        <td><?= date('F j, Y', strtotime($ipcrf['date_start'])) ?> - <?= date('F j, Y', strtotime($ipcrf['date_end'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Rater:</td>
                        <td class="text-uppercase">
                            <?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '<span class="text-muted">Not assigned</span>' ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Coaching Entry Button -->
<?php if ($isValidator): ?>
<div class="mb-3">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addCoachingModal">
        <i class="fas fa-plus mr-1"></i> Add Coaching Entry
    </button>
    <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to IPCRF
    </a>
</div>
<?php endif; ?>

<!-- Coaching Entries Table -->
<div class="card shadow mb-4">
    <div class="card-header py-2">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-clipboard-list mr-1"></i> Coaching Entries
        </h6>
    </div>
    <div class="card-body">
        <?php if (empty($coachingEntries)): ?>
            <div class="text-center py-4">
                <i class="fas fa-clipboard fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No coaching entries recorded yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover small" width="100%">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th width="10%">Date</th>
                            <th width="20%">Key Result Area / Objective</th>
                            <th width="20%">Significant Incident<br>(Performance Observed)</th>
                            <th width="20%">Feedback / Coaching Provided</th>
                            <th width="20%">Action Agreed Upon</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coachingEntries as $entry): ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <?= date('M j, Y', strtotime($entry['coaching_date'])) ?>
                                </td>
                                <td class="align-middle">
                                    <strong>KRA:</strong> <?= e($entry['kra_title']) ?><br>
                                    <strong>Objective:</strong> <?= e($entry['objective']) ?>
                                </td>
                                <td class="align-middle"><?= nl2br(e($entry['incident'])) ?></td>
                                <td class="align-middle"><?= nl2br(e($entry['feedback'])) ?></td>
                                <td class="align-middle"><?= nl2br(e($entry['action_agreed'])) ?></td>
                                <td class="align-middle text-center">
                                    <?php if ($isValidator): ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-1" 
                                            data-toggle="modal" data-target="#editCoachingModal<?= $entry['id'] ?>" title="Edit">
                                            <i class="fas fa-edit fa-sm"></i>
                                        </button>
                                        <form action="" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="coaching_id" value="<?= cipher($entry['id']) ?>">
                                            <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                            <button type="submit" name="delete-coaching" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this coaching entry?')" title="Delete">
                                                <i class="fas fa-trash fa-sm"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Signature Section -->
<div class="card shadow mb-4">
    <div class="card-header py-2">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-signature mr-1"></i> Signatures
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 text-center border-right">
                <p class="mb-1"><strong>Ratee:</strong></p>
                <p class="text-uppercase mb-0"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></p>
                <small class="text-muted"><?= e($rateePositionTitle) ?></small>
            </div>
            <div class="col-md-6 text-center">
                <p class="mb-1"><strong>Rater:</strong></p>
                <?php if ($validator): ?>
                    <p class="text-uppercase mb-0"><?= e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) ?></p>
                    <small class="text-muted"><?= e($validatorPositionTitle) ?></small>
                <?php else: ?>
                    <p class="text-muted mb-0">Not assigned</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Coaching Modal -->
<div class="modal fade" id="addCoachingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <div class="modal-header bg-info text-white">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-plus mr-2"></i> Add Coaching Entry
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="coaching_date" class="form-control" required 
                            value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Key Result Area / Objective <span class="text-danger">*</span></label>
                        <select name="objective_id" class="form-control" required>
                            <option value="">-- Select Objective --</option>
                            <?php foreach ($kraGroups as $kra): ?>
                                <optgroup label="<?= e($kra['title']) ?>">
                                    <?php foreach ($kra['objectives'] as $obj): ?>
                                        <option value="<?= cipher($obj['id']) ?>">
                                            <?= e($obj['objective']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Significant Incident (Performance Observed) <span class="text-danger">*</span></label>
                        <textarea name="incident" class="form-control" rows="3" required
                            placeholder="Actual, factual event or behavior observed. May be positive (e.g., exceeded deadline) or negative (e.g., delayed submission). Must be objective, verifiable, and output- or behavior-based."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Feedback / Coaching Provided <span class="text-danger">*</span></label>
                        <textarea name="feedback" class="form-control" rows="3" required
                            placeholder="Guidance given by the rater: Corrections, Reinforcement of good practices, Recommendations"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Action Agreed Upon <span class="text-danger">*</span></label>
                        <textarea name="action_agreed" class="form-control" rows="3" required
                            placeholder="Specific next steps to: Sustain good performance, or Improve identified gaps"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-coaching" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i> Save Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Coaching Modals -->
<?php foreach ($coachingEntries as $entry): ?>
<div class="modal fade" id="editCoachingModal<?= $entry['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <input type="hidden" name="coaching_id" value="<?= cipher($entry['id']) ?>">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Coaching Entry
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" name="coaching_date" class="form-control" required 
                            value="<?= e($entry['coaching_date']) ?>" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Key Result Area / Objective</label>
                        <input type="text" class="form-control" readonly 
                            value="<?= e($entry['kra_title']) ?> - <?= e($entry['objective']) ?>">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Significant Incident (Performance Observed) <span class="text-danger">*</span></label>
                        <textarea name="incident" class="form-control" rows="3" required><?= e($entry['incident']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Feedback / Coaching Provided <span class="text-danger">*</span></label>
                        <textarea name="feedback" class="form-control" rows="3" required><?= e($entry['feedback']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Action Agreed Upon <span class="text-danger">*</span></label>
                        <textarea name="action_agreed" class="form-control" rows="3" required><?= e($entry['action_agreed']) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit-coaching" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
