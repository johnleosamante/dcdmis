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
                    <div>This action will receive all incoming documents to and complete all received/pending documents
                        of
                        [<?= strtoupper($stationName) ?>]. If you are sure about this action, click CONTINUE to proceed.
                    </div>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station</label>
                    <input id="station" type="text" value="<?= e($stationName) ?>"
                        class="form-control text-uppercase disabled">
                </div>

                <div class="form-group">
                    <label for="date-from" class="mb-0">Start Date</label>
                    <input id="date-from" type="date" value="<?= e($from) ?>" name="date-from" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="date-to" class="mb-0">End Date</label>
                    <input id="date-to" type="date" value="<?= e($to) ?>" name="date-to" class="form-control" required>
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