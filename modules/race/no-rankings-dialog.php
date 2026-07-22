<?php
// modules/race/no-rankings-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['award']) ? sanitize(decipher($_GET['award'])) : null;
$schedId = isset($_GET['sched']) ? sanitize(decipher($_GET['sched'])) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$awardName = $award ? $award['name'] : 'this award';
?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <?php modalHeader('No Nominees Ranked Yet'); ?>

        <div class="modal-body text-center py-4">
            <div class="text-warning mb-3" style="font-size:3rem;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h5 class="text-dark mb-2">No nominees have been ranked for <?= e($awardName) ?> yet.</h5>
            <p class="text-muted small mb-0">You need to give points to at least one nominee before you can save final rankings.</p>
        </div>

        <div class="modal-footer">
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>
