<?php
// modules/race/save-ranking-criteria-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$awardName = $award ? $award['name'] : 'Award';
$existingCriteria = $awardId ? rankingCriteriaByAward($awardId) : [];
$criteriaLibrary = rankingCriteriaLibrary();
$existingByName = [];
foreach ($existingCriteria as $criterion) {
    $existingByName[strtolower(trim($criterion['criterion_name']))] = $criterion;
}
$customCriteria = [];
foreach ($existingCriteria as $criterion) {
    if (!rankingCriteriaLibraryIdByName($criterion['criterion_name'])) {
        $customCriteria[] = $criterion;
    }
}
?>

<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <?php modalHeader('Ranking Criteria — ' . e($awardName)); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">

                <div class="alert alert-light border mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle text-primary mt-1 mr-2"></i>
                        <div>
                            <div class="font-weight-bold text-dark">Set the criteria for this award</div>
                            <div class="small text-muted">Select criteria from the shared list and assign the maximum points. You may add a new criterion if it is not listed.</div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($criteriaLibrary)): ?>
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-list-check fa-fw mr-1"></i> Available Criteria</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width:80px;">Use</th>
                                        <th>Criterion</th>
                                        <th class="text-center" style="width:180px;">Maximum Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($criteriaLibrary as $libraryCriterion):
                                        $libraryName = strtolower(trim($libraryCriterion['criterion_name']));
                                        $awardCriterion = $existingByName[$libraryName] ?? null;
                                    ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="position-static" name="library_criterion_id[]" value="<?= e($libraryCriterion['id']) ?>" <?= $awardCriterion ? 'checked' : '' ?> aria-label="Use <?= e($libraryCriterion['criterion_name']) ?>">
                                            </td>
                                            <td class="align-middle font-weight-bold text-dark"><?= e($libraryCriterion['criterion_name']) ?></td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control form-control-sm text-center" name="library_max_points[<?= e($libraryCriterion['id']) ?>]" value="<?= e($awardCriterion['max_points'] ?? $libraryCriterion['default_max_points']) ?>" min="0" step="any" aria-label="Maximum points for <?= e($libraryCriterion['criterion_name']) ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card border">
                    <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-plus-circle fa-fw mr-1"></i> Additional Criteria</h6>
                        <button type="button" class="btn btn-sm btn-success" onclick="addRankingRow()"><i class="fas fa-plus fa-fw"></i> Add Criterion</button>
                    </div>
                    <div class="card-body" id="criteria-list">
                        <?php if (!empty($customCriteria)): ?>
                            <?php foreach ($customCriteria as $cr): ?>
                                <div class="form-row align-items-end mb-2 criteria-row">
                                    <div class="col">
                                        <label class="small text-muted mb-1">Criterion Name</label>
                                        <input type="text" class="form-control" name="criterion_name[]" value="<?= e($cr['criterion_name']) ?>" placeholder="e.g. Teaching Effectiveness" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted mb-1">Maximum Points</label>
                                        <input type="number" class="form-control" name="max_points[]" value="<?= e($cr['max_points']) ?>" min="0" step="any" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeRankingRow(this)" title="Remove criterion"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted small mb-0">No additional criteria have been added. Use the button above to add one.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <?php cancelModalButton() ?>
                <button class="btn btn-primary" name="save-ranking-criteria" type="submit"><i class="fas fa-save fa-fw mr-1"></i> Save Criteria</button>
            </div>
        </form>
    </div>
</div>
