<?php
// modules/pm/create-ipcrf.php - Create new IPCRF
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
$activeCycle = pmActiveCycle();

if (!$activeCycle) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

// Check if IPCRF already exists for this cycle
$existingIpcrf = pmIpcrfByEmployee($employeeId, $activeCycle['id']);
if ($existingIpcrf) {
    redirect(customUri('pis', 'IPCRF Details', $existingIpcrf['id']));
}

// Get available KRAs
$availableKras = pmKras(true);

// Get section heads / raters
$sectionHeads = pmSectionHeads();

// Get validator assignment if exists
$validatorAssignment = pmValidatorOf($employeeId, $activeCycle['id']);

// Get position title
$positionData = position($employeeId);
$positionTitle = $positionData['official_title'] ?? '';

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $employeeId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item active">Create IPCRF</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Phase 1: Performance Planning and Commitment', customUri('pis', 'IPCRF', $employeeId)) ?>
    </div>
    <div class="card-body">
        <form action="" method="POST" id="ipcrf-form">
            <?= csrf_field() ?>
            <input type="hidden" name="verifier" value="<?= cipher($employeeId) ?>">
            <input type="hidden" name="cycle-verifier" value="<?= cipher($activeCycle['id']) ?>">

            <!-- Header Information -->
            <div class="bg-light p-3 rounded mb-4">
                <h6 class="font-weight-bold text-primary mb-3">INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM <?= e($activeCycle['school_year']) ?></h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small">Name</label>
                            <input type="text" class="form-control form-control-sm bg-white" 
                                value="<?= e(strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension']))) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small">Name of Rater <?php showAsterisk() ?></label>
                            <select name="validator_id" class="form-control form-control-sm" required>
                                <option value="">-- Select Rater --</option>
                                <?php foreach ($sectionHeads as $sh): ?>
                                    <?php if ($sh['employee_id'] != $employeeId): ?>
                                        <option value="<?= e($sh['employee_id']) ?>" 
                                            <?= ($validatorAssignment && $validatorAssignment['validator_id'] == $sh['employee_id']) ? 'selected' : '' ?>>
                                            <?= e(strtoupper($sh['name'])) ?> — <?= e($sh['position_title']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small">Position</label>
                            <input type="text" name="position_title" class="form-control form-control-sm bg-white" 
                                value="<?= e($positionTitle) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small">Review Period</label>
                            <input type="text" class="form-control form-control-sm bg-white" 
                                value="<?= e($activeCycle['school_year']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Division</label>
                            <input type="text" class="form-control form-control-sm bg-white" value="Dipolog City" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Rating Period</label>
                            <input type="text" class="form-control form-control-sm bg-white" 
                                value="<?= date('F j, Y', strtotime($activeCycle['date_start'])) ?> to <?= date('F j, Y', strtotime($activeCycle['date_end'])) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small">Approving Authority <?php showAsterisk() ?></label>
                            <select name="approving_officer_id" class="form-control form-control-sm" required>
                                <option value="">-- Select Approving Authority --</option>
                                <?php foreach ($sectionHeads as $sh): ?>
                                    <?php if ($sh['employee_id'] != $employeeId): ?>
                                        <option value="<?= e($sh['employee_id']) ?>">
                                            <?= e(strtoupper($sh['name'])) ?> — <?= e($sh['position_title']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KRA Selection and Objectives -->
            <h6 class="font-weight-bold text-primary mb-3">
                <i class="fas fa-bullseye mr-1"></i> Key Result Areas and Objectives
            </h6>
            <p class="small text-muted mb-3">
                Define your Key Result Areas (KRAs) and objectives. You can select from predefined KRAs or enter your own custom KRA.
                Performance indicators should describe the expected output at each rating level (5-Outstanding to 1-Poor).
            </p>

            <div id="kra-container">
                <!-- KRA items will be added here -->
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="addKraSection()">
                <i class="fas fa-plus mr-1"></i> Add Key Result Area
            </button>

            <hr class="my-3">

            <?php requiredLegend() ?>

            <div class="d-flex justify-content-between">
                <a href="<?= customUri('pis', 'IPCRF', $employeeId) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                <button type="submit" name="create-ipcrf" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Create IPCRF
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let kraCount = 0;
const availableKras = <?= json_encode($availableKras) ?>;

function addKraSection(kraId = '', kraTitle = '') {
    kraCount++;
    const container = document.getElementById('kra-container');
    
    let kraOptions = '<option value="">-- Select Predefined KRA --</option>';
    kraOptions += '<option value="custom">✏️ Enter Custom KRA</option>';
    availableKras.forEach(kra => {
        const selected = kra.id == kraId ? 'selected' : '';
        kraOptions += `<option value="${kra.id}" data-title="${kra.title}" data-weight="${kra.weight}" ${selected}>${kra.title}</option>`;
    });

    const html = `
        <div class="kra-section card border mb-3" id="kra-section-${kraCount}">
            <div class="card-header bg-light py-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">KRA #${kraCount}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeKraSection(${kraCount})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="font-weight-bold small">Key Result Area <?php showAsterisk() ?></label>
                    <select id="kra-select-${kraCount}" class="form-control form-control-sm kra-select mb-2" onchange="toggleCustomKra(${kraCount})">
                        ${kraOptions}
                    </select>
                    <input type="hidden" name="kra_id[]" id="kra-id-${kraCount}" value="${kraId}">
                    <input type="text" name="kra_title[]" id="kra-title-${kraCount}" class="form-control form-control-sm" 
                        value="${kraTitle}" required placeholder="Enter your KRA title...">
                    <small class="text-muted">Describe the key result area you will be measured on</small>
                </div>
                
                <div class="objectives-container" id="objectives-${kraCount}">
                    <!-- Objectives will be added here -->
                </div>
                
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addObjective(${kraCount})">
                    <i class="fas fa-plus mr-1"></i> Add Objective
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    addObjective(kraCount); // Add first objective by default
}

function removeKraSection(id) {
    if (confirm('Remove this KRA and all its objectives?')) {
        document.getElementById(`kra-section-${id}`).remove();
    }
}

function toggleCustomKra(kraId) {
    const select = document.getElementById(`kra-select-${kraId}`);
    const titleInput = document.getElementById(`kra-title-${kraId}`);
    const idInput = document.getElementById(`kra-id-${kraId}`);
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

let objectiveCount = {};

function addObjective(kraId) {
    if (!objectiveCount[kraId]) objectiveCount[kraId] = 0;
    objectiveCount[kraId]++;
    const objId = objectiveCount[kraId];
    
    const container = document.getElementById(`objectives-${kraId}`);
    
    const html = `
        <div class="objective-item border rounded p-3 mb-3 bg-white" id="objective-${kraId}-${objId}">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="font-weight-bold small text-secondary mb-0">Objective #${objId}</h6>
                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeObjective(${kraId}, ${objId})">
                    <i class="fas fa-trash fa-sm"></i>
                </button>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-8">
                    <label class="small">Objective Statement <?php showAsterisk() ?></label>
                    <textarea name="objective_${kraId}[]" class="form-control form-control-sm" rows="2" required 
                        placeholder="Describe the performance objective..."></textarea>
                </div>
                <div class="col-md-2">
                    <label class="small">Timeline <?php showAsterisk() ?></label>
                    <input type="text" name="timeline_${kraId}[]" class="form-control form-control-sm" required
                        placeholder="e.g., Jan-Dec 2024">
                </div>
                <div class="col-md-2">
                    <label class="small">Weight % <?php showAsterisk() ?></label>
                    <input type="number" name="obj_weight_${kraId}[]" class="form-control form-control-sm" 
                        min="1" max="100" required placeholder="e.g., 10">
                </div>
            </div>
            
            <div>
                <label class="small">Performance Indicators <?php showAsterisk() ?></label>
                <textarea name="performance_indicator_${kraId}[]" class="form-control form-control-sm" rows="3" required
                    placeholder="Describe the success indicators or measures for this objective..."></textarea>
                <small class="text-muted">Describe how performance will be measured for this objective</small>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

function removeObjective(kraId, objId) {
    const container = document.getElementById(`objectives-${kraId}`);
    if (container.children.length > 1) {
        document.getElementById(`objective-${kraId}-${objId}`).remove();
    } else {
        alert('Each KRA must have at least one objective.');
    }
}

// Add first KRA section on page load
document.addEventListener('DOMContentLoaded', function() {
    addKraSection();
});
</script>
