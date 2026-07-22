<?php
// modules/race/save-criteria-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$criteria = $award ? trim($award['criteria'] ?? '') : '';
$awardName = $award ? $award['name'] : 'Award';

$isTableMode = (strpos($criteria, '<table') !== false);
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Edit Criteria — ' . e($awardName)); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <input type="hidden" name="criteria_mode" id="criteria_mode" value="<?= $isTableMode ? 'table' : 'text' ?>">
                <input type="hidden" name="criteria" id="criteria_hidden" value="">

                <div class="btn-group mb-3 w-100" role="group">
                    <button type="button" class="btn btn-outline-primary <?= !$isTableMode ? 'active' : '' ?>" id="btn-text-mode" onclick="switchCriteriaMode('text')">
                        <i class="fas fa-font fa-fw"></i> Text Only
                    </button>
                    <button type="button" class="btn btn-outline-primary <?= $isTableMode ? 'active' : '' ?>" id="btn-table-mode" onclick="switchCriteriaMode('table')">
                        <i class="fas fa-table fa-fw"></i> Table
                    </button>
                </div>

                <!-- Text Mode -->
                <div id="text-mode" class="criteria-mode-section" style="<?= !$isTableMode ? '' : 'display:none;' ?>">
                    <small class="text-muted d-block mb-2">Enter the criteria and guidelines for this award. Line breaks will be preserved.</small>
                    <textarea id="criteria_text" class="form-control" rows="12" placeholder="Enter nomination criteria and guidelines for <?= e($awardName) ?>..."><?= $isTableMode ? '' : e($criteria) ?></textarea>
                </div>

                <!-- Table Mode -->
                <div id="table-mode" class="criteria-mode-section" style="<?= $isTableMode ? '' : 'display:none;' ?>">
                    <small class="text-muted d-block mb-2">Build a criteria table. Click cells to edit content.</small>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableRow()"><i class="fas fa-plus fa-fw"></i> Add Row</button>
                        <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableColumn()"><i class="fas fa-plus fa-fw"></i> Add Column</button>
                        <button type="button" class="btn btn-sm btn-danger mr-1" onclick="removeCriteriaTableRow()"><i class="fas fa-minus fa-fw"></i> Remove Row</button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeCriteriaTableColumn()"><i class="fas fa-minus fa-fw"></i> Remove Column</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="criteria_table">
                            <?php if ($isTableMode): ?>
                                <?= $criteria ?>
                            <?php else: ?>
                                <thead><tr><th contenteditable="true">Criterion</th><th contenteditable="true">Description</th></tr></thead>
                                <tbody><tr><td contenteditable="true">&nbsp;</td><td contenteditable="true">&nbsp;</td></tr></tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="save-criteria" type="submit" onclick="prepareCriteriaSubmit()">Save Criteria</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
