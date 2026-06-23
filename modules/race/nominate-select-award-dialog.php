<?php
// modules/race/nominate-select-award-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$schedule = null;

if ($scheduleId) {
    $schedule = awardSchedule($scheduleId);
}

$awards = recognitionAwardsWithCategory();
$nomineeCounts = $scheduleId ? nomineesCountByAward($scheduleId) : [];

$modalTitle = 'Select Award';
if ($schedule) {
    $modalTitle = 'Select Award — ' . $schedule['title'];
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <div class="modal-body p-0">
            <div class="px-4 pt-3 pb-2 d-flex align-items-center justify-content-between">
                <p class="mb-0 text-muted small">Choose an award to nominate for:</p>
                <a href="#" class="btn btn-outline-secondary btn-sm"
                   onclick="loadData('<?= uri() ?>/modules/race/nominate-select-schedule-dialog.php'); return false;">
                    <i class="fas fa-arrow-left fa-fw"></i> Back
                </a>
            </div>

            <?php if ($schedule): ?>
                <div class="px-4 pb-2">
                    <span class="badge badge-primary font-weight-bold text-uppercase p-2 text-xs">
                        Event: <?= e($schedule['title']) ?> &mdash; <?= toLongDate($schedule['date']) ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if (!empty($awards)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($awards as $aw):
                        $count = $nomineeCounts[$aw['id']] ?? 0;
                        ?>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3 px-4"
                           onclick="loadData('<?= uri() ?>/modules/race/save-nominee-dialog.php?e=<?= cipher($scheduleId) ?>&award_id=<?= cipher($aw['id']) ?>'); return false;">
                            <div>
                                <div class="font-weight-bold text-dark text-uppercase"><?= e($aw['name']) ?></div>
                                <div class="text-muted small"><?= e($aw['category_name']) ?></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-pill badge-info font-weight-bold px-2 py-1 mr-3" title="Current nominees"><?= $count ?></span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <div class="mb-2" style="font-size: 2rem;"><i class="fas fa-award"></i></div>
                    <p>No awards found.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>
