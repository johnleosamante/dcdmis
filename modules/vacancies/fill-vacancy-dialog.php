<?php
// modules/vacancies/fill-vacancy-dialog.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/employee.php';
require_once root() . '/includes/database/school.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/layout/components.php';

$vacancyId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$position = $itemNumber = $stationName = 'N/A';
$stationId = $positionId = null;
$effectivityDate = date('Y-m-d');

if (isset($vacancyId)) {
    $sql = "SELECT v.`id`, pi.`item_number`, pi.`station_id`, pi.`position_id`, p.`official_title`
            FROM `vacancies` AS v
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id`
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id`
            WHERE v.`id` = ? LIMIT 1";
    $vacancy = find($sql, [$vacancyId]);

    if ($vacancy !== false) {
        $itemNumber = $vacancy['item_number'] ?? 'N/A';
        $stationId = $vacancy['station_id'];
        $positionId = $vacancy['position_id'];
        $position = $vacancy['official_title'] ?? 'Unknown Position';

        if (!empty($stationId)) {
            $school = schoolById($stationId);
            $stationName = $school['name'] ?? 'Unknown Station';
        }
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Fill Position Item'); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="card bg-light mb-3">
                    <div class="card-body px-3 py-2">
                        <p class="font-weight-bold text-uppercase m-0">
                            <?= e($position) ?>
                        </p>
                        <p class="font-weight-bold text-primary m-0">
                            <?= e($itemNumber) ?>
                        </p>
                        <p class="font-weight-bold m-0">
                            <?= e($stationName) ?>
                        </p>
                    </div>
                </div>

                <?php
                $pubItem = find("SELECT `publication_id` FROM `vacancy_publication_items` WHERE `vacancy_id` = ? LIMIT 1", [$vacancyId]);
                $publicationId = $pubItem ? $pubItem['publication_id'] : null;

                $applicants = [];
                if ($publicationId && $positionId) {
                    $sql = "SELECT va.id AS application_id, va.application_code_id, ac.code AS application_code,
                                   s.total_accumulated_score
                            FROM vacancy_applications AS va
                            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
                            LEFT JOIN assessment_scores AS s ON va.id = s.application_id
                            WHERE va.publication_id = ? AND va.position_id = ? AND va.status = 'Qualified'
                            ORDER BY s.total_accumulated_score DESC, ac.code ASC";
                    $applicants = query($sql, [$publicationId, $positionId]);
                }

                $optionsHtml = '';
                $optionsCount = 0;

                if (!empty($applicants)) {
                    // 1. Calculate ranks based on score ordering
                    $ranks = [];
                    $currentRank = 1;
                    $prevScore = null;
                    $itemCount = 0;
                    foreach ($applicants as $index => $app) {
                        $itemCount++;
                        $score = $app['total_accumulated_score'];
                        if ($score === null) {
                            $ranks[$index] = '-';
                        } else {
                            if ($prevScore === null || (float) $score !== (float) $prevScore) {
                                $currentRank = $itemCount;
                            }
                            $ranks[$index] = $currentRank;
                            $prevScore = $score;
                        }
                    }

                    // 2. Filter out already-filled applicants and buffer options string
                    foreach ($applicants as $index => $app) {
                        $appId = $app['application_code_id'];
                        $appCode = $app['application_code'];
                        $appName = applicantName($appCode);
                        $score = $app['total_accumulated_score'];
                        $rank = $ranks[$index];

                        // Check if applicant has already filled a plantilla item in this publication
                        $hasFilled = false;
                        if ($publicationId) {
                            $sqlCheck = "SELECT vh.`id` 
                                         FROM `vacancy_history` AS vh
                                         INNER JOIN `vacancy_publication_items` AS vpi ON vh.`vacancy_id` = vpi.`vacancy_id`
                                         WHERE vh.`filled_by_id` = ? AND vpi.`publication_id` = ?
                                         LIMIT 1";
                            $filledCheck = find($sqlCheck, [$appId, $publicationId]);
                            if ($filledCheck !== false) {
                                $hasFilled = true;
                            }
                        }

                        if ($hasFilled) {
                            continue;
                        }

                        $optionsCount++;
                        $scoreText = ($score !== null) ? ' - Score: ' . number_format($score, 2) : ' - No Score';

                        $optionsHtml .= '<option value="' . e($appId) . '">';
                        $optionsHtml .= "{$rank} - " . strtoupper(e($appName)) . $scoreText;
                        $optionsHtml .= '</option>';
                    }
                }

                // Conditional rendering based on applicant availability
                if (empty($applicants) || $optionsCount === 0) {
                    $messageText = empty($applicants) ? 'No qualified applicants available.' : '';
                    $messageText = $applicants && $optionsCount === 0 ? 'All applicants have filled a position item.' : $messageText;
                    message($messageText, 'warning', 'exclamation-circle');
                    ?>
                <?php } else { ?>
                    <div class="form-group">
                        <label for="employee_id" class="mb-0 font-weight-bold">Select Applicant
                            <?php showAsterisk() ?>
                        </label>
                        <p class="small text-muted mb-1">Qualified applicants for this position (in rank order):</p>
                        <select id="employee_id" name="employee_id" class="form-control" required>
                            <option value="">Select applicant...</option>
                            <?= $optionsHtml ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="effectivity_date" class="mb-0 font-weight-bold">Effectivity Date
                            <?php showAsterisk() ?>
                        </label>
                        <p class="small text-muted mb-1">The effective date of appointment / reassignment</p>
                        <input id="effectivity_date" name="effectivity_date" type="date" class="form-control"
                            value="<?= e($effectivityDate) ?>" required>
                    </div>

                    <?php requiredLegend(0) ?>
                <?php } ?>
            </div>

            <div class="modal-footer">
                <?php if (!empty($applicants) && $optionsCount > 0): ?>
                    <input type="hidden" name="verifier" value="<?= cipher($vacancyId) ?>">
                    <button class="btn btn-primary" name="fill-vacancy" type="submit">Continue</button>
                <?php endif; ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>