<?php
// modules/race/rank-nominee-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$nomineeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$nominee = $nomineeId ? nominee($nomineeId) : null;

if (!$nominee) {
    echo '<div class="modal-dialog"><div class="modal-content">';
    modalHeader('Error');
    echo '<div class="modal-body"><p class="text-danger">Nominee not found.</p></div>';
    echo '<div class="modal-footer">';
    cancelModalButton();
    echo '</div></div></div>';
    return;
}

$awardId = $nominee['award_id'];
$award = recognitionAward($awardId);
$awardName = $award ? $award['name'] : 'Award';
$criteria = rankingCriteriaByAward($awardId);
$existingScores = rankingScoresByNominee($nomineeId);
$scoreMap = [];
foreach ($existingScores as $sc) {
    $scoreMap[$sc['criterion_id']] = $sc['points'];
}

$nomineeName = '';
if ($nominee['nominee_type'] === 'School') {
    $school = schoolById($nominee['nominee_id']);
    $nomineeName = $school ? $school['name'] : $nominee['nominee_id'];
} else {
    $emp = find("SELECT `first_name`, `last_name`, `middle_name`, `name_extension` FROM `employees` WHERE `id` = ? LIMIT 1", [$nominee['nominee_id']]);
    if ($emp) {
        $nomineeName = trim($emp['last_name'] . ', ' . $emp['first_name'] . ' ' . ($emp['middle_name'] ? $emp['middle_name'][0] . '.' : '') . ' ' . ($emp['name_extension'] ?? ''));
    } else {
        $nomineeName = $nominee['nominee_id'];
    }
}
$totalScore = totalScoreByNominee($nomineeId);
$isAdmin = raceAccessLevel($userId) === 'admin';
$currentValidated = $nominee['validated'] ?? null;
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Rank Nominee — ' . e($nomineeName)); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">

                <div class="mb-3">
                    <span class="badge badge-primary font-weight-bold text-uppercase p-2"><?= e($awardName) ?></span>
                </div>

                <?php if (empty($criteria)): ?>
                    <div class="text-center py-4">
                        <div class="text-muted mb-2" style="font-size:2rem;"><i class="fas fa-exclamation-circle"></i></div>
                        <p class="text-muted">No ranking criteria has been set for this award yet.</p>
                        <p class="text-muted small">Please set ranking criteria first before ranking nominees.</p>
                    </div>
                <?php else: ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Criterion</th>
                                <th class="text-center" style="width:120px;">Max Points</th>
                                <th class="text-center" style="width:150px;">Awarded Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($criteria as $cr): ?>
                                <tr>
                                    <td><?= e($cr['criterion_name']) ?></td>
                                    <td class="text-center font-weight-bold"><?= e($cr['max_points']) ?></td>
                                    <td class="text-center">
                                        <input type="number" class="form-control form-control-sm text-center"
                                               name="score[<?= e($cr['id']) ?>]"
                                               value="<?= e($scoreMap[$cr['id']] ?? 0) ?>"
                                               min="0" max="<?= e($cr['max_points']) ?>" step="any" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold table-active">
                                <td colspan="2" class="text-right">Total Score:</td>
                                <td class="text-center" id="total-score-display"><?= e(number_format($totalScore, 2)) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <small class="text-muted">Points cannot exceed the maximum for each criterion.</small>

                    <?php if ($isAdmin): ?>
                        <hr>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="toggle-validated" <?= $currentValidated ? 'checked' : '' ?> onchange="document.getElementById('validated-row').style.display = this.checked ? '' : 'none';">
                            <label class="form-check-label small font-weight-bold" for="toggle-validated">Set Validation Status</label>
                        </div>
                        <div id="validated-row" class="form-row align-items-center" style="display: <?= $currentValidated ? '' : 'none' ?>;">
                            <div class="col-auto">
                                <label class="small text-muted mb-0">Validated:</label>
                            </div>
                            <div class="col">
                                <select name="validated" class="form-control form-control-sm">
                                    <option value="Yes" <?= $currentValidated === 'Yes' ? 'selected' : '' ?>>Yes</option>
                                    <option value="No" <?= $currentValidated === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <?php if (!empty($criteria)): ?>
                    <button class="btn btn-primary" name="save-ranking-score" type="submit">Save Score</button>
                <?php endif; ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
