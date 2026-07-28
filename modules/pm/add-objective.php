<?php
// modules/pm/add-objective.php - Add objectives to IPCRF
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

if (!$isOwner) {
    require_once(root() . '/modules/error/403.php');
    return;
}

if ($ipcrf['status'] !== 'Draft' && $ipcrf['status'] !== 'Returned') {
    redirect(customUri('pis', 'IPCRF Details', $ipcrfId));
}

$employee = employee($ipcrf['employee_id']);
$availableKras = pmKras(true);
$existingObjectives = pmObjectives($ipcrfId);

// Group existing objectives by KRA
$existingByKra = [];
foreach ($existingObjectives as $obj) {
    $kraId = $obj['kra_id'];
    if (!isset($existingByKra[$kraId])) {
        $existingByKra[$kraId] = [];
    }
    $existingByKra[$kraId][] = $obj;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Add Objective</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Add Performance Objective', customUri('pis', 'IPCRF Details', $ipcrfId)) ?>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">

            <div class="form-group">
                <label class="font-weight-bold">Key Result Area <?php showAsterisk() ?></label>
                <select id="kra-select" class="form-control mb-2" onchange="toggleCustomKra()">
                    <option value="">-- Select Predefined KRA --</option>
                    <option value="custom">✏️ Enter Custom KRA</option>
                    <?php foreach ($availableKras as $kra): ?>
                        <option value="<?= e($kra['id']) ?>" data-title="<?= e($kra['title']) ?>">
                            <?= e($kra['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="kra_id" id="kra-id" value="0">
                <input type="text" name="kra_title" id="kra-title" class="form-control" required
                    placeholder="Enter your KRA title...">
                <small class="form-text text-muted">Describe the key result area for this objective</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Objective Statement <?php showAsterisk() ?></label>
                <textarea name="objective" class="form-control" rows="3" required 
                    placeholder="Describe the performance objective..."></textarea>
                <small class="form-text text-muted">The specific performance objective to be accomplished.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Timeline <?php showAsterisk() ?></label>
                        <input type="text" name="timeline" class="form-control" required 
                            placeholder="e.g., January to December 2024">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Weight (%) <?php showAsterisk() ?></label>
                        <input type="number" name="weight" class="form-control" min="1" max="100" required 
                            placeholder="e.g., 10">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Performance Indicators <?php showAsterisk() ?></label>
                <textarea name="performance_indicator" class="form-control" rows="3" required
                    placeholder="Describe the success indicators or measures for this objective..."></textarea>
                <small class="form-text text-muted">Describe how performance will be measured for this objective</small>
            </div>

            <hr class="my-3">
            <?php requiredLegend() ?>

            <div class="d-flex justify-content-between">
                <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" name="save-objective" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Objective
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Existing Objectives -->
<?php if (!empty($existingObjectives)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-2 bg-light">
            <h6 class="m-0 font-weight-bold text-dark">Existing Objectives</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="bg-light">
                        <tr class="text-center small">
                            <th width="5%">#</th>
                            <th width="20%">KRA</th>
                            <th width="30%">Objective</th>
                            <th width="10%">Timeline</th>
                            <th width="8%">Weight</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($existingObjectives as $oi => $obj): ?>
                            <tr class="small">
                                <td class="text-center align-middle"><?= $oi + 1 ?></td>
                                <td class="align-middle"><?= e($obj['kra_title']) ?></td>
                                <td class="align-middle"><?= e($obj['objective']) ?></td>
                                <td class="align-middle text-center"><?= e($obj['timeline'] ?? '-') ?></td>
                                <td class="align-middle text-center"><?= e($obj['weight']) ?>%</td>
                                <td class="text-center align-middle">
                                    <form action="" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                        <input type="hidden" name="objective-verifier" value="<?= cipher($obj['id']) ?>">
                                        <button type="submit" name="delete-objective" class="btn btn-sm btn-outline-danger" 
                                            title="Delete" onclick="return confirm('Delete this objective?')">
                                            <i class="fas fa-trash fa-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
function toggleCustomKra() {
    const select = document.getElementById('kra-select');
    const titleInput = document.getElementById('kra-title');
    const idInput = document.getElementById('kra-id');
    const option = select.options[select.selectedIndex];
    
    if (select.value === 'custom' || select.value === '') {
        // Custom KRA - allow user to type
        titleInput.value = '';
        titleInput.readOnly = false;
        titleInput.focus();
        idInput.value = '0';
    } else {
        // Predefined KRA selected
        titleInput.value = option.dataset.title || '';
        titleInput.readOnly = true;
        idInput.value = select.value;
    }
}
</script>
