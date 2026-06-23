<?php
// modules/race/nominate-select-schedule-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$schedules = awardSchedules();
$modalTitle = 'Select Event Schedule';
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <div class="modal-body p-0">
            <p class="px-4 pt-3 mb-2 text-muted large">Choose an event schedule to nominate under:</p>
            <?php if (!empty($schedules)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($schedules as $sched):
                        $nomStatus = nominationStatus($sched);
                        $isOpen = isNominationOpen($sched);
                    ?>
                        <?php if ($isOpen): ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3 px-4"
                               onclick="loadData('<?= uri() ?>/modules/race/nominate-select-award-dialog.php?e=<?= cipher($sched['id']) ?>'); return false;">
                        <?php else: ?>
                            <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 bg-light">
                        <?php endif; ?>
                            <div>
                                <div class="font-weight-bold <?= $isOpen ? 'text-dark' : 'text-muted' ?> text-uppercase"><?= e($sched['title']) ?></div>
                                <div class="text-muted small">
                                    <i class="fas fa-calendar-alt fa-fw mr-1"></i> <?= toLongDate($sched['date']) ?>
                                    &nbsp;&bull;&nbsp;
                                    <i class="fas fa-map-marker-alt fa-fw mr-1"></i> <?= e($sched['venue']) ?>
                                    <?php if (!empty($sched['nomination_deadline'])): ?>
                                        &nbsp;&bull;&nbsp;
                                        <span class="<?= $isOpen ? 'text-danger' : 'text-muted' ?>"><i class="fas fa-clock fa-fw mr-1"></i>Deadline: <?= toLongDate($sched['nomination_deadline']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-<?= $nomStatus['color'] ?> px-2 py-1 mr-2"><?= $nomStatus['label'] ?></span>
                                <?php if ($isOpen): ?>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                <?php else: ?>
                                    <i class="fas fa-lock text-gray-400"></i>
                                <?php endif; ?>
                            </div>
                        <?php if ($isOpen): ?>
                            </a>
                        <?php else: ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <div class="mb-2" style="font-size: 2rem;"><i class="fas fa-calendar-times"></i></div>
                    <p>No event schedules available.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>
