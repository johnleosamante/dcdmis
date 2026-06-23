<?php
// modules/race/view-winner-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$winnerId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$winner = null;

if ($winnerId) {
    $winner = nomineeDetails($winnerId);
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Winner Details'); ?>

        <div class="modal-body">
            <?php if ($winner): ?>
                <div class="text-center mb-4">
                    <div class="display-4 text-warning mb-3">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <span class="badge badge-success px-3 py-2 text-uppercase font-weight-bold mb-3"><?= e($winner['status']) ?></span>
                </div>

                <?php if ($winner['level']): ?>
                    <div class="text-center mb-3">
                        <span class="badge badge-pill badge-secondary text-uppercase px-3 py-1">
                            Level: <?= e($winner['level']) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($winner['nominee_type']) && $winner['nominee_type'] === 'School'): ?>
                    <div class="text-center">
                        <h4 class="font-weight-bold text-success text-uppercase mb-1">
                            <?= e($winner['school_name'] ?: 'Unknown School') ?>
                        </h4>
                        <p class="text-muted small text-uppercase font-weight-bold">
                            School Code: <?= e($winner['nominee_id']) ?> (<?= e($winner['school_alias'] ?: 'N/A') ?>)
                        </p>
                    </div>
                <?php else: ?>
                    <?php if ($winner['last_name'] !== null): ?>
                        <div class="text-center">
                            <h4 class="font-weight-bold text-success text-uppercase mb-1">
                                <?= toName($winner['last_name'], $winner['first_name'], $winner['middle_name'], $winner['name_extension']) ?>
                            </h4>
                            <p class="text-muted small text-uppercase font-weight-bold"><?= e($winner['position']) ?></p>
                        </div>
                    <?php else: ?>
                        <div class="text-center">
                            <h4 class="font-weight-bold text-danger text-uppercase mb-1">
                                Nominee ID: <?= e($winner['nominee_id']) ?>
                            </h4>
                            <p class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee Record Missing</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <hr>

                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="text-muted small text-uppercase font-weight-bold mb-1">Award</div>
                        <div class="font-weight-bold text-dark"><?= e($winner['award_name']) ?></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-muted small text-uppercase font-weight-bold mb-1">Category</div>
                        <span class="badge badge-danger px-3 py-1"><?= e($winner['category_name']) ?></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-muted small text-uppercase font-weight-bold mb-1">Event Schedule</div>
                        <div class="font-weight-bold text-dark"><?= e($winner['schedule_title']) ?></div>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <span class="text-muted small">Date Nominated:</span>
                    <div class="font-weight-bold text-dark"><?= toLongDate($winner['created_at']) ?></div>
                </div>

            <?php else: ?>
                <div class="py-5 text-center text-muted">
                    <div class="mb-3" style="font-size: 3rem;"><i class="fas fa-exclamation-circle"></i></div>
                    <h5>Winner record not found.</h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>
