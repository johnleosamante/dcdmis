<?php
// modules/documents/bulk-process-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/layout/components.php');

$stationId = sanitize(decipher($_GET['id'] ?? null));
$stationName = stationName($stationId);

$previousYear = date('Y', strtotime('-1 year'));
$from = "$previousYear-01-01";
$to = "$previousYear-12-31";
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Bulk Process Document') ?>

        <form action="" method="POST">
            <?= csrf_field() ?>

            <div class="modal-body">
                <div class="alert alert-info text-left p-2 d-flex align-items-start small">
                    <i class="fa fas fa-info-circle mt-1 mr-1"></i>
                    <div>This action will :
                        <ul class="my-0">
                            <li>Receive all incoming documents to this station</li>
                            <li>Complete all pending documents by this station</li>
                            <li>Cancel all created documents by this station that are not yet received by a destination
                            </li>
                        </ul>
                        If you are sure about this action, click CONTINUE to proceed.
                    </div>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station</label>
                    <input id="station" type="text" value="<?= e($stationName) ?>"
                        class="form-control text-uppercase disabled">
                </div>

                <div class="form-group">
                    <label for="from-date" class="mb-0">Start Date</label>
                    <input id="from-date" type="date" value="<?= e($from) ?>" name="from-date" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="to-date" class="mb-0">End Date</label>
                    <input id="to-date" type="date" value="<?= e($to) ?>" name="to-date" class="form-control" required>
                </div>

                <?= requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($_GET['id']) ?>">
                <button class="btn btn-primary" name="bulk-process-documents" type="submit">Continue</button>
                <?= cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>