<?php
// modules/race/save-schedule-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$id = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$modalTitle = 'Program Schedule';
$title = '';
$date = '';
$venue = '';
$nominationStart = '';
$nominationDeadline = '';

if ($id) {
    $modalTitle = 'Edit RACE Program Schedule';
    $schedule = awardSchedule($id);
    if ($schedule) {
        $title = $schedule['title'];
        $date = $schedule['date'];
        $venue = $schedule['venue'];
        $nominationStart = $schedule['nomination_start'] ?? '';
        $nominationDeadline = $schedule['nomination_deadline'] ?? '';
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title" class="mb-0">Title <?php showAsterisk() ?></label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter program title..." value="<?= e($title) ?>" required>
                </div>

                <div class="form-group">
                    <label for="date" class="mb-0">Event Date <?php showAsterisk() ?></label>
                    <input type="date" id="date" name="date" class="form-control" value="<?= e($date) ?>" required>
                </div>

                <div class="form-group">
                    <label for="venue" class="mb-0">Venue <?php showAsterisk() ?></label>
                    <input type="text" id="venue" name="venue" class="form-control" placeholder="Enter venue..." value="<?= e($venue) ?>" required>
                </div>

                <hr class="my-3">
                <p class="text-muted small mb-2"><i class="fas fa-info-circle mr-1"></i> Set the nomination window. Leave blank for no deadline.</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomination_start" class="mb-0">Nomination Start</label>
                            <input type="date" id="nomination_start" name="nomination_start" class="form-control" value="<?= e($nominationStart) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomination_deadline" class="mb-0">Nomination Deadline</label>
                            <input type="date" id="nomination_deadline" name="nomination_deadline" class="form-control" value="<?= e($nominationDeadline) ?>">
                        </div>
                    </div>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['id'] ?? null ?>">
                <button class="btn btn-primary" name="save-schedule" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>
