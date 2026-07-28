<?php
// modules/pm/phase2.php - Phase 2: Performance Monitoring and Coaching
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

// Phase 2 is for updating actual results
if ($ipcrf['phase'] < 2) {
    redirect(customUri('pis', 'IPCRF Details', $ipcrfId));
}

$employee = employee($ipcrf['employee_id']);
$objectives = pmObjectives($ipcrfId);

// Group objectives by KRA (use both id and title so custom KRAs stay distinct)
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
            <li class="breadcrumb-item active">Phase 2</li>
        </ol>
    </nav>
</div>

<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-chart-line mr-1"></i> Phase 2: Performance Monitoring and Coaching
        </h6>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">
            Update your actual results and accomplishments for each objective. 
            You can also upload Means of Verification (MOV) documents to support your accomplishments.
        </p>

        <form action="" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">

            <?php foreach ($kraGroups as $kraId => $kra): ?>
                <div class="card mb-3">
                    <div class="card-header py-2 bg-light">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <?= e($kra['title']) ?>
                            <span class="badge badge-primary ml-2"><?= e($kra['weight']) ?>%</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php foreach ($kra['objectives'] as $oi => $obj): ?>
                            <div class="objective-row border rounded p-3 mb-3 <?= $oi < count($kra['objectives']) - 1 ? '' : 'mb-0' ?>" data-weight="<?= e($obj['weight'] ?? 0) ?>">
                                <input type="hidden" name="obj_id[]" value="<?= cipher($obj['id']) ?>">
                                
                                <div class="row mb-2">
                                    <div class="col-md-8">
                                        <label class="font-weight-bold small text-primary">Objective</label>
                                        <p class="mb-0"><?= e($obj['objective']) ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="font-weight-bold small text-primary">Timeline</label>
                                        <p class="mb-0"><?= e($obj['timeline'] ?? '-') ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="font-weight-bold small text-primary">Weight</label>
                                        <p class="mb-0"><?= e($obj['weight']) ?>%</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold small">Actual Results / Accomplishments</label>
                                        <textarea name="actual_result[]" class="form-control" rows="3" 
                                            placeholder="Describe your actual accomplishments for this objective..."><?= e($obj['actual_result'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2 col-6">
                                        <label class="font-weight-bold small">Q</label>
                                        <input type="number" name="rating_q[]" class="form-control phase2-q" step="0.01" min="1" max="5"
                                            value="<?= $obj['rating_q'] !== null ? e($obj['rating_q']) : '' ?>" placeholder="Q" oninput="computeAvg(this)">
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <label class="font-weight-bold small">E</label>
                                        <input type="number" name="rating_e[]" class="form-control phase2-e" step="0.01" min="1" max="5"
                                            value="<?= $obj['rating_e'] !== null ? e($obj['rating_e']) : '' ?>" placeholder="E" oninput="computeAvg(this)">
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <label class="font-weight-bold small">T</label>
                                        <input type="number" name="rating_t[]" class="form-control phase2-t" step="0.01" min="1" max="5"
                                            value="<?= $obj['rating_t'] !== null ? e($obj['rating_t']) : '' ?>" placeholder="T" oninput="computeAvg(this)">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="font-weight-bold small">Average</label>
                                        <input type="number" name="average_rating[]" class="form-control phase2-avg" step="0.01" min="1" max="5"
                                            value="<?= $obj['average_rating'] !== null ? e($obj['average_rating']) : '' ?>" placeholder="Average" oninput="computeScore(this.closest('.objective-row'))">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <label class="font-weight-bold small">Score</label>
                                        <input type="number" name="score[]" class="form-control phase2-score" step="0.01" min="0" max="100"
                                            value="<?= $obj['score'] !== null ? e($obj['score']) : '' ?>" placeholder="Score">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <div>
                    <a href="<?= customUri('pis', 'Upload MOV', $ipcrfId) ?>" class="btn btn-outline-primary">
                        <i class="fas fa-upload mr-1"></i> Upload MOV
                    </a>
                    <button type="submit" name="save-actual-results" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i> Save Actual Results
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function computeAvg(input) {
    const row = input.closest('.objective-row');
    const q = parseFloat(row.querySelector('.phase2-q').value);
    const e = parseFloat(row.querySelector('.phase2-e').value);
    const t = parseFloat(row.querySelector('.phase2-t').value);

    if (isNaN(q) || isNaN(e) || isNaN(t)) {
        return;
    }

    const avg = (q + e + t) / 3;
    row.querySelector('.phase2-avg').value = avg.toFixed(2);
    computeScore(row);
}

function computeScore(row) {
    if (!row) {
        return;
    }

    const avgInput = row.querySelector('.phase2-avg');
    const weight = parseFloat(row.dataset.weight);
    const avg = parseFloat(avgInput.value);

    if (isNaN(avg) || isNaN(weight)) {
        return;
    }

    const score = avg * (weight / 100);
    row.querySelector('.phase2-score').value = score.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.objective-row').forEach(function(row) {
        const q = row.querySelector('.phase2-q').value;
        const e = row.querySelector('.phase2-e').value;
        const t = row.querySelector('.phase2-t').value;
        if (q !== '' && e !== '' && t !== '') {
            computeAvg(row.querySelector('.phase2-q'));
        }
    });
});
</script>

<!-- Progress Tips -->
<div class="card shadow mb-4">
    <div class="card-header py-2 bg-light">
        <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-lightbulb mr-1"></i> Tips for Phase 2
        </h6>
    </div>
    <div class="card-body">
        <ul class="mb-0 small">
            <li>Document your accomplishments clearly and specifically</li>
            <li>Include quantifiable results where possible (e.g., percentages, numbers)</li>
            <li>Upload supporting documents as Means of Verification (MOV)</li>
            <li>Keep track of your progress throughout the rating period</li>
            <li>Communicate with your rater for coaching and feedback</li>
        </ul>
    </div>
</div>
