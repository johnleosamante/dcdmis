<?php
// modules/race/revert-winner-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleId = isset($_GET['sched']) ? sanitize(decipher($_GET['sched'])) : null;
$awardId = isset($_GET['award']) ? sanitize(decipher($_GET['award'])) : null;
$level = isset($_GET['level']) ? sanitize(decipher($_GET['level'])) : null;

$award = $awardId ? recognitionAward($awardId) : null;
$schedule = $scheduleId ? awardSchedule($scheduleId) : null;
$rankings = ($scheduleId && $awardId) ? getRankingsByScheduleAndAward($scheduleId, $awardId, $level) : [];
$winner = null;
foreach ($rankings as $r) {
    if ($r['rank_position'] == 1) {
        $winner = $r;
        break;
    }
}
if (!$winner && !empty($rankings)) {
    $winner = $rankings[0];
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Revert Winner'); ?>

        <div class="modal-body">
            <?php if ($award && $winner): ?>
                <div class="text-center mb-3">
                    <div class="text-warning mb-2" style="font-size: 2.5rem;">
                        <i class="fas fa-undo"></i>
                    </div>
                </div>
                <p class="text-center">Are you sure you want to <strong class="text-warning">revert the winner</strong> back to a nominee? Ranking will be <strong class="text-success">reopened</strong> after this action.</p>
                <div class="bg-light rounded p-3 text-center">
                    <?php if (isset($winner['nominee_type']) && $winner['nominee_type'] === 'School'): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= e($winner['school_name'] ?: 'Unknown School') ?></div>
                    <?php elseif ($winner['last_name'] !== null): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= toName($winner['last_name'], $winner['first_name'], $winner['middle_name'], $winner['name_extension']) ?></div>
                    <?php else: ?>
                        <div class="font-weight-bold text-dark">Nominee ID: <?= e($winner['nominee_ref_id']) ?></div>
                    <?php endif; ?>
                    <hr class="my-2">
                    <div class="small text-muted">
                        <span class="badge badge-warning p-1">Rank #1</span>
                        <span class="badge badge-success p-1 ml-1">Score: <?= number_format($winner['total_score'], 2) ?></span>
                    </div>
                    <hr class="my-2">
                    <div class="small text-muted"><?= e($award['name']) ?><?php if ($level): ?> &bull; <?= e($level) ?><?php endif; ?><?php if ($schedule): ?> &bull; <?= e($schedule['title']) ?><?php endif; ?></div>
                </div>
            <?php else: ?>
                <p class="text-danger text-center">No winner found to revert.</p>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php if ($award && $winner): ?>
                <form action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="revert-winner-ranking" value="1">
                    <input type="hidden" name="rank_schedule_id" value="<?= e($scheduleId) ?>">
                    <input type="hidden" name="rank_award_id" value="<?= e($awardId) ?>">
                    <?php if ($level): ?>
                        <input type="hidden" name="rank_level" value="<?= e($level) ?>">
                    <?php endif; ?>
                    <input type="submit" class="btn btn-warning" value="Yes, Revert Winner & Reopen Ranking">
                    <?php cancelModalButton() ?>
                </form>
            <?php else: ?>
                <?php cancelModalButton() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
