<?php
// modules/race/nominate-reminder-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleParam = isset($_GET['e']) ? $_GET['e'] : null;
$awardParam = isset($_GET['award_id']) ? $_GET['award_id'] : null;

if ($scheduleParam && $awardParam) {
    $nextUrl = uri() . '/modules/race/save-nominee-dialog.php?e=' . urlencode($scheduleParam) . '&award_id=' . urlencode($awardParam);
} else {
    $nextUrl = uri() . '/modules/race/nominate-select-schedule-dialog.php';
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Nomination Guidelines'); ?>

        <div class="modal-body">
            <div class="d-flex align-items-start mb-3">
                <div class="text-warning mr-3" style="font-size: 2rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h5 class="text-danger font-weight-bold mb-3">Important Reminders:</h5>
                    <ol class="pl-3 mb-4">
                        <li class="mb-2">Nominees must meet the qualifications set by the Rewards and Recognition Committee.</li>
                        <li class="mb-2">Supporting documents (e.g., certifications, performance ratings, endorsements) must be submitted along with the nomination.</li>
                        <li class="mb-2">Only personnel under the nominator's jurisdiction may be nominated, unless otherwise authorized.</li>
                        <li class="mb-2">Nominations are final once submitted and cannot be modified without admin approval.</li>
                        <li class="mb-2">Ensure that all information provided is accurate and complete before proceeding.</li>
                    </ol>

                    <div class="custom-control custom-checkbox mt-3">
                        <input type="checkbox" class="custom-control-input" id="agree-nomination" onchange="document.getElementById('btn-next-nomination').disabled = !this.checked;">
                        <label class="custom-control-label text-dark" for="agree-nomination">
                            I have read and understood the guidelines above and agree to comply.
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer d-flex justify-content-between">
            <?php cancelModalButton() ?>
            <button type="button" class="btn btn-primary" id="btn-next-nomination" disabled onclick="loadData('<?= $nextUrl ?>'); return false;">
                Next <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</div>
