<?php
// modules/race/criteria-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['award_id']) ? sanitize(decipher($_GET['award_id'])) : null;
$scheduleParam = isset($_GET['e']) ? $_GET['e'] : null;
$award = $awardId ? recognitionAward($awardId) : null;
$criteria = $award ? trim($award['criteria'] ?? '') : '';
$awardName = $award ? $award['name'] : 'Award';

$nextUrl = '#';
if ($scheduleParam && $awardId) {
    $nextUrl = uri() . '/modules/race/save-nominee-dialog.php?e=' . urlencode($scheduleParam) . '&award_id=' . urlencode($_GET['award_id']);
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Nomination Criteria — ' . e($awardName)); ?>

        <style>
            .criteria-content table { margin-bottom: 0; }
            .criteria-content table th { background-color: #f8f9fc; }
            .criteria-content table td, .criteria-content table th { font-size: 0.875rem; }
        </style>

        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
            <?php if (!empty($criteria)): ?>
                <div class="criteria-content">
                    <?php if (strpos($criteria, '<table') !== false): ?>
                        <div class="table-responsive"><?= $criteria ?></div>
                    <?php else: ?>
                        <?= nl2br(e($criteria)) ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="text-muted mb-3" style="font-size:3rem;">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h5 class="text-muted">No criteria has been set for this award yet.</h5>
                    <p class="text-muted small">Please contact the RACE administrator for nomination guidelines.</p>
                </div>
            <?php endif; ?>

            <?php if (!empty($criteria)): ?>
                <div class="custom-control custom-checkbox mt-3 border-top pt-3">
                    <input type="checkbox" class="custom-control-input" id="agree-nomination" onchange="document.getElementById('btn-next-nomination').disabled = !this.checked;">
                    <label class="custom-control-label text-dark" for="agree-nomination">
                        I have read and understood the criteria above and agree to comply.
                    </label>
                </div>
            <?php endif; ?>
        </div>

        <div class="modal-footer d-flex justify-content-between">
            <?php cancelModalButton() ?>
            <?php if (!empty($criteria) && $nextUrl !== '#'): ?>
                <button type="button" class="btn btn-primary" id="btn-next-nomination" disabled onclick="loadData('<?= e($nextUrl) ?>'); return false;">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
