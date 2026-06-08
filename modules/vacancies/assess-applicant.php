<?php
// modules/vacancies/assess-applicant.php

if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

$applicationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$appRecord = null;
$score = null;
$applicantName = 'Unknown Applicant';
$positionTitle = 'Unknown Position';
$publication = null;
$publicationId = null;
$appCode = null;

if ($applicationId) {
    $appRecord = applicationRecord($applicationId);
    if ($appRecord) {
        $score = getAssessmentScore($applicationId);
        $appCode = applicantCode($appRecord['application_code_id']);
        $applicantName = applicantName($appCode);

        $positionData = find("SELECT * FROM `positions` WHERE `id` = ?", [$appRecord['position_id']]);
        $positionTitle = $positionData ? $positionData['official_title'] : 'Unknown Position';
        $positionSG = $positionData ? $positionData['salary_grade'] : 'N/A';
        $positionCategory = $positionData ? $positionData['category'] : 'N/A';

        $publicationId = $appRecord['publication_id'];
        $publication = publication($publicationId);
    }
}

if (!$appRecord || !$publication) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "$baseUri/$activeApp" ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Publications') ?>">Publications</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Publication Details', $publicationId) ?>">
                    <?= e($publication['code']) ?>
                </a></li>
            <li class="breadcrumb-item"><a
                    href="<?= customUri('hrmis', 'Qualified Applicants', $publicationId) ?>">Qualified Applicants</a>
            </li>
            <li class="breadcrumb-item active">Assess Applicant</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-12">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-user mr-1"></i> Applicant Info</h6>
            </div>
            <div class="card-body">
                <h5 class="text-uppercase font-weight-bold text-gray-800 mb-1"><?= e($applicantName) ?></h5>
                <p class="text-muted mb-0 small">Code: <?= e($appCode) ?></p>
            </div>
        </div>

        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-briefcase mr-1"></i> Position Applied
                </h6>
            </div>
            <div class="card-body">
                <h5 class="text-uppercase font-weight-bold text-gray-800 mb-1"><?= e($positionTitle) ?></h5>
                <div class="small text-muted mb-2">Salary Grade: <?= e($positionSG) ?> | Category:
                    <?= e($positionCategory) ?>
                </div>

                <?php
                $vacancyData = find("SELECT vpi.vacancy_id, pi.item_number, pi.station_id 
                                     FROM vacancy_publication_items AS vpi
                                     INNER JOIN vacancies AS v ON vpi.vacancy_id = v.id
                                     INNER JOIN plantilla_items AS pi ON v.plantilla_item_id = pi.id
                                     WHERE vpi.publication_id = ? AND pi.position_id = ? LIMIT 1",
                    [$publicationId, $appRecord['position_id']]
                );

                $itemNumber = $vacancyData ? $vacancyData['item_number'] : 'N/A';
                $stationName = 'N/A';
                if ($vacancyData && !empty($vacancyData['station_id'])) {
                    $school = schoolById($vacancyData['station_id']);
                    $stationName = $school ? $school['name'] : 'Unknown';
                }
                ?>
                <p class="mb-1 text-gray-800"><strong>Item Number:</strong> <?= e($itemNumber) ?></p>
                <p class="mb-0 text-gray-800"><strong>Station:</strong> <?= e($stationName) ?></p>
            </div>
        </div>

        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bullhorn mr-1"></i> Publication Details
                </h6>
            </div>
            <div class="card-body">
                <h5 class="font-weight-bold text-gray-800 mb-1"><?= e($publication['title']) ?></h5>
                <p class="text-muted small mb-2">Code: <?= e($publication['code']) ?></p>
                <?php if (!empty($publication['description'])): ?>
                    <p class="small text-gray-700 mb-3"><?= e($publication['description']) ?></p>
                <?php endif ?>

                <div class="small text-gray-800 mb-1">
                    <strong>Status:</strong> <span
                        class="badge badge-primary text-capitalize"><?= e($publication['status']) ?></span>
                </div>
                <div class="small text-gray-800">
                    <strong>Period:</strong> <?= toLongDate($publication['open_date']) ?> to
                    <?= toLongDate($publication['close_date']) ?>
                </div>
            </div>
        </div>

        <a href="<?= customUri('hrmis', 'Qualified Applicants', $publicationId) ?>"
            class="btn btn-secondary btn-block shadow mb-4">
            <i class="fas fa-arrow-circle-left mr-1"></i> Back to Qualified Applicants
        </a>
    </div>

    <div class="col-xl-8 col-lg-7 col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-poll-h mr-1"></i> Applicant Assessment
                    Scores</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?= csrf_field(); ?>

                    <div class="row">
                        <div class="col-xl-6 col-md-12 col-sm-12">
                            <h6 class="font-weight-bold text-primary mb-3">Core Assessment Criteria</h6>
                            <div class="form-group">
                                <label for="education_score" class="font-weight-bold text-dark mb-0">Education
                                    Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="education_score" name="education_score"
                                    value="<?= e($score['education_score'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="training_score" class="font-weight-bold text-dark mb-0">Training
                                    Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="training_score" name="training_score"
                                    value="<?= e($score['training_score'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="experience_score" class="font-weight-bold text-dark mb-0">Experience
                                    Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="experience_score" name="experience_score"
                                    value="<?= e($score['experience_score'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="performance_score" class="font-weight-bold text-dark mb-0">Performance
                                    Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="performance_score" name="performance_score"
                                    value="<?= e($score['performance_score'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="outstanding_accomplishments_score"
                                    class="font-weight-bold text-dark mb-0">Outstanding Accomplishments Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="outstanding_accomplishments_score" name="outstanding_accomplishments_score"
                                    value="<?= e($score['outstanding_accomplishments_score'] ?? '0.00') ?>" required>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12 col-sm-12">
                            <h6 class="font-weight-bold text-primary mb-3">Application & L&D</h6>
                            <div class="form-group">
                                <label for="application_of_education_score"
                                    class="font-weight-bold text-dark mb-0">Application of Education Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="application_of_education_score" name="application_of_education_score"
                                    value="<?= e($score['application_of_education_score'] ?? '0.00') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="application_of_ld_score" class="font-weight-bold text-dark mb-0">Application
                                    of L&D Score</label>
                                <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                    id="application_of_ld_score" name="application_of_ld_score"
                                    value="<?= e($score['application_of_ld_score'] ?? '0.00') ?>" required>
                            </div>

                            <h6 class="font-weight-bold text-primary mt-4 mb-2">Potential Raw Scores</h6>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="potential_written_exam_raw" class="mb-0 small">Written Exam</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                        id="potential_written_exam_raw" name="potential_written_exam_raw"
                                        value="<?= e($score['potential_written_exam_raw'] ?? '0.00') ?>" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="potential_bei_raw" class="mb-0 small">BEI</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                        id="potential_bei_raw" name="potential_bei_raw"
                                        value="<?= e($score['potential_bei_raw'] ?? '0.00') ?>" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="potential_wst_raw" class="mb-0 small">WST</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control score-input"
                                        id="potential_wst_raw" name="potential_wst_raw"
                                        value="<?= e($score['potential_wst_raw'] ?? '0.00') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="potential_final_score" class="font-weight-bold text-dark mb-0">Potential Final
                                Score</label>
                            <input type="number" step="0.01" min="0" max="100"
                                class="form-control bg-light font-weight-bold" id="potential_final_score"
                                name="potential_final_score" value="<?= e($score['potential_final_score'] ?? '0.00') ?>"
                                required>
                            <small class="form-text text-muted font-italic">Auto calculated (Written + BEI +
                                WST)</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="total_accumulated_score" class="font-weight-bold text-success mb-0">Total
                                Accumulated Score</label>
                            <input type="number" step="0.01" min="0" max="100"
                                class="form-control bg-light text-success font-weight-bold" id="total_accumulated_score"
                                name="total_accumulated_score"
                                value="<?= e($score['total_accumulated_score'] ?? '0.00') ?>" required readonly>
                            <small class="form-text text-muted font-italic">Auto calculated total criteria sum</small>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="hrmspb_remarks" class="font-weight-bold text-dark mb-0">Remarks</label>
                            <textarea class="form-control" id="hrmspb_remarks" name="hrmspb_remarks" rows="3"
                                placeholder="Enter remarks..."><?= e($score['hrmspb_remarks'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="text-right">
                        <input type="hidden" name="verifier" value="<?= cipher($applicationId) ?>">
                        <button type="submit" name="save-assessment-score" class="btn btn-primary px-5 shadow">
                            <i class="fas fa-save mr-1"></i> Save Assessment Score
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scoreInputs = document.querySelectorAll('.score-input');
        const potentialFinalInput = document.getElementById('potential_final_score');
        const totalAccumulatedInput = document.getElementById('total_accumulated_score');

        function calculateScores() {
            const edu = parseFloat(document.getElementById('education_score').value) || 0;
            const tra = parseFloat(document.getElementById('training_score').value) || 0;
            const exp = parseFloat(document.getElementById('experience_score').value) || 0;
            const perf = parseFloat(document.getElementById('performance_score').value) || 0;
            const acc = parseFloat(document.getElementById('outstanding_accomplishments_score').value) || 0;
            const appEdu = parseFloat(document.getElementById('application_of_education_score').value) || 0;
            const appLd = parseFloat(document.getElementById('application_of_ld_score').value) || 0;

            const exam = parseFloat(document.getElementById('potential_written_exam_raw').value) || 0;
            const bei = parseFloat(document.getElementById('potential_bei_raw').value) || 0;
            const wst = parseFloat(document.getElementById('potential_wst_raw').value) || 0;

            const potFinal = exam + bei + wst;
            potentialFinalInput.value = potFinal.toFixed(2);

            const total = edu + tra + exp + perf + acc + appEdu + appLd + potFinal;
            totalAccumulatedInput.value = total.toFixed(2);
        }

        scoreInputs.forEach(input => {
            input.addEventListener('input', calculateScores);
            input.addEventListener('change', calculateScores);
        });

        potentialFinalInput.addEventListener('input', function () {
            const edu = parseFloat(document.getElementById('education_score').value) || 0;
            const tra = parseFloat(document.getElementById('training_score').value) || 0;
            const exp = parseFloat(document.getElementById('experience_score').value) || 0;
            const perf = parseFloat(document.getElementById('performance_score').value) || 0;
            const acc = parseFloat(document.getElementById('outstanding_accomplishments_score').value) || 0;
            const appEdu = parseFloat(document.getElementById('application_of_education_score').value) || 0;
            const appLd = parseFloat(document.getElementById('application_of_ld_score').value) || 0;
            const potFinal = parseFloat(potentialFinalInput.value) || 0;

            const total = edu + tra + exp + perf + acc + appEdu + appLd + potFinal;
            totalAccumulatedInput.value = total.toFixed(2);
        });

        potentialFinalInput.addEventListener('change', function () {
            const edu = parseFloat(document.getElementById('education_score').value) || 0;
            const tra = parseFloat(document.getElementById('training_score').value) || 0;
            const exp = parseFloat(document.getElementById('experience_score').value) || 0;
            const perf = parseFloat(document.getElementById('performance_score').value) || 0;
            const acc = parseFloat(document.getElementById('outstanding_accomplishments_score').value) || 0;
            const appEdu = parseFloat(document.getElementById('application_of_education_score').value) || 0;
            const appLd = parseFloat(document.getElementById('application_of_ld_score').value) || 0;
            const potFinal = parseFloat(potentialFinalInput.value) || 0;

            const total = edu + tra + exp + perf + acc + appEdu + appLd + potFinal;
            totalAccumulatedInput.value = total.toFixed(2);
        });

        calculateScores();
    });
</script>