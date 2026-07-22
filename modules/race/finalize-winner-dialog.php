<?php
// modules/race/finalize-winner-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleId = isset($_GET['sched']) ? sanitize(decipher($_GET['sched'])) : null;
$awardId = isset($_GET['award']) ? sanitize(decipher($_GET['award'])) : null;
$level = isset($_GET['level']) ? sanitize(decipher($_GET['level'])) : null;

$award = $awardId ? recognitionAward($awardId) : null;
$schedule = $scheduleId ? awardSchedule($scheduleId) : null;
$liveNominees = ($scheduleId && $awardId) ? nomineesWithScoresByAward($awardId, $scheduleId, $level) : [];
$topNominee = null;
if (!empty($liveNominees)) {
    $topNominee = $liveNominees[0];
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Finalize & Declare Winner'); ?>

        <div class="modal-body">
            <?php if ($award && $schedule && $topNominee): ?>
                <div class="text-center mb-3">
                    <div class="text-warning mb-2" style="font-size: 2.5rem;">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <p class="text-center">Are you sure you want to declare the <strong class="text-success">top-ranked nominee</strong> as the winner? Ranking will be <strong class="text-danger">closed</strong> after this action.</p>
                <div class="bg-light rounded p-3 text-center">
                    <?php if (isset($topNominee['nominee_type']) && $topNominee['nominee_type'] === 'School'): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= e($topNominee['school_name'] ?: 'Unknown School') ?></div>
                    <?php elseif ($topNominee['last_name'] !== null): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= toName($topNominee['last_name'], $topNominee['first_name'], $topNominee['middle_name'], $topNominee['name_extension']) ?></div>
                    <?php else: ?>
                        <div class="font-weight-bold text-dark">Nominee ID: <?= e($topNominee['nominee_id']) ?></div>
                    <?php endif; ?>
                    <hr class="my-2">
                    <div class="small text-muted">
                        <span class="badge badge-warning p-1">Rank #1</span>
                        <span class="badge badge-success p-1 ml-1">Score: <?= number_format($topNominee['total_score'], 2) ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="small text-muted"><?= e($award['name']) ?><?php if ($level): ?> &bull; <?= e($level) ?><?php endif; ?> &bull; <?= e($schedule['title']) ?></div>
                </div>
            <?php else: ?>
                <p class="text-danger text-center">No nominees with scores found. Please rank nominees first before declaring a winner.</p>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php if ($award && $schedule && $topNominee): ?>
                <form action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="finalize-winner" value="1">
                    <input type="hidden" name="rank_schedule_id" value="<?= e($scheduleId) ?>">
                    <input type="hidden" name="rank_award_id" value="<?= e($awardId) ?>">
                    <?php if ($level): ?>
                        <input type="hidden" name="rank_level" value="<?= e($level) ?>">
                    <?php endif; ?>
                    <input type="submit" class="btn btn-warning" name="confirm-finalize" value="Yes, Declare Winner & Close Ranking">
                    <?php cancelModalButton() ?>
                </form>
            <?php else: ?>
                <?php cancelModalButton() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
