<?php
// modules/pm/edit-objective.php - Edit an IPCRF objective
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$objectiveId = (int) sanitize(decode($_GET['id'] ?? null));
$objective = pmObjective($objectiveId);

if (!$objective) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$ipcrfId = (int) $objective['ipcrf_id'];
$ipcrf = pmIpcrf($ipcrfId);

if (!$ipcrf) {
    require_once(root() . '/modules/error/403.php');
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

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Edit Objective</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Edit Performance Objective', customUri('pis', 'IPCRF Details', $ipcrfId)) ?>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="verifier" value="<?= cipher($objectiveId) ?>">

            <div class="form-group">
                <label class="font-weight-bold">Key Result Area <?php showAsterisk() ?></label>
                <select id="kra-select" class="form-control mb-2" onchange="toggleCustomKra()">
                    <option value="">-- Select Predefined KRA --</option>
                    <option value="custom" <?= ($objective['kra_id'] == 1 || (int) $objective['kra_id'] === 0) ? 'selected' : '' ?>>✏️ Enter Custom KRA</option>
                    <?php foreach ($availableKras as $kra): ?>
                        <option value="<?= e($kra['id']) ?>" data-title="<?= e($kra['title']) ?>"
                            <?= ((int) $objective['kra_id'] == (int) $kra['id'] && (int) $objective['kra_id'] !== 0) ? 'selected' : '' ?>>
                            <?= e($kra['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="kra_id" id="kra-id" value="<?= e($objective['kra_id'] ?? 0) ?>">
                <input type="text" name="kra_title" id="kra-title" class="form-control" required
                    value="<?= e($objective['kra_title'] ?? '') ?>"
                    placeholder="Enter your KRA title...">
                <small class="form-text text-muted">Describe the key result area for this objective</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Objective Statement <?php showAsterisk() ?></label>
                <textarea name="objective" class="form-control" rows="3" required
                    placeholder="Describe the performance objective..."><?= e($objective['objective'] ?? '') ?></textarea>
                <small class="form-text text-muted">The specific performance objective to be accomplished.</small>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Timeline <?php showAsterisk() ?></label>
                        <input type="text" name="timeline" class="form-control" required
                            value="<?= e($objective['timeline'] ?? '') ?>"
                            placeholder="e.g., January to December 2024">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Weight (%) <?php showAsterisk() ?></label>
                        <input type="number" name="weight" class="form-control" min="1" max="100" required
                            value="<?= e($objective['weight'] ?? '') ?>"
                            placeholder="e.g., 10">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Performance Indicators <?php showAsterisk() ?></label>
                <textarea name="performance_indicator" class="form-control" rows="3" required
                    placeholder="Describe the success indicators or measures for this objective..."><?= e($objective['performance_indicator'] ?? '') ?></textarea>
                <small class="form-text text-muted">Describe how performance will be measured for this objective</small>
            </div>

            <hr class="my-3">
            <?php requiredLegend() ?>

            <div class="d-flex justify-content-between">
                <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <button type="submit" name="edit-objective" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCustomKra() {
    const select = document.getElementById('kra-select');
    const titleInput = document.getElementById('kra-title');
    const idInput = document.getElementById('kra-id');
    const option = select.options[select.selectedIndex];

    if (select.value === 'custom' || select.value === '') {
        // Custom KRA - allow user to type
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

// Set initial state correctly based on loaded values
(function initKra() {
    const select = document.getElementById('kra-select');
    const titleInput = document.getElementById('kra-title');
    const idInput = document.getElementById('kra-id');

    if (idInput.value === '0' || idInput.value === '') {
        select.value = 'custom';
        titleInput.readOnly = false;
    } else {
        select.value = idInput.value;
        titleInput.readOnly = true;
    }
})();
</script>
