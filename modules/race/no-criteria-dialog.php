<?php
// modules/race/no-criteria-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['award']) ? sanitize(decipher($_GET['award'])) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$awardName = $award ? $award['name'] : 'this award';
?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <?php modalHeader('No Ranking Criteria Set'); ?>

        <div class="modal-body text-center py-4">
            <div class="text-warning mb-3" style="font-size:3rem;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h5 class="text-dark mb-2">No criteria has been set for <?= e($awardName) ?> yet.</h5>
            <p class="text-muted small mb-0">You need to set ranking criteria before you can save rankings for this award.</p>
        </div>

        <div class="modal-footer">
            <?php if ($awardId): ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal"
                   onclick="loadData('<?= e(uri() . '/modules/race/save-ranking-criteria-dialog.php?id=' . cipher($awardId)) ?>'); return false;">
                    <i class="fas fa-clipboard-list fa-fw mr-1"></i> Set Criteria Now
                </a>
            <?php endif; ?>
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>
