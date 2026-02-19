<?php
// modules/vacancies/delete-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$vacancyId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$position = $itemNumber = 'N/A';

if (isset($vacancyId)) {
    $vacancyDataSet = vacancy($vacancyId);

    if (numRows($vacancyDataSet) > 0) {
        $vacancy = fetchArray($vacancyDataSet);
        $itemNumber = $vacancy['item_number'] ?? 'N/A';
        $positionId = $vacancy['position_id'];
        $positionData = fetchAssoc(positions($positionId));
        $position = $positionData['position'] ?? 'Unknown Position';
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Delete Vacancy'); ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                    <h5 class="text-danger font-weight-bold">Are you sure you want to delete this vacancy?</h5>
                </div>

                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Position</p>
                                <p class="font-weight-bold text-uppercase mb-2">
                                    <?= $position ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 small text-muted">Item Number</p>
                                <p class="font-weight-bold text-primary mb-0">
                                    <?= $itemNumber ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 mb-0">
                    <small>This action cannot be undone.</small>
                </p>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= cipher($vacancyId) ?>">
                <button class="btn btn-danger" name="delete-vacancy" type="submit">
                    <i class="fas fa-trash-alt fa-fw mr-1"></i>Delete Vacancy
                </button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>