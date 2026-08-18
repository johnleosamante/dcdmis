<?php
// modules/applicants/applicant-information.php
if (!$isHrmis || (!$isPersonnel && !$isICT)) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);

$applicantId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$employeeData = $applicantId ? employee($applicantId) : null;
$isInternal = !empty($employeeData);
$extApplicant = $applicantId ? applicant($applicantId) : null;
$applicant = $isInternal ? ($extApplicant ? array_merge($extApplicant, $employeeData) : $employeeData) : $extApplicant;

if (!$applicant) {
    echo '<div class="alert alert-danger shadow"><i class="fas fa-exclamation-triangle mr-2"></i> Applicant record not found.</div>';
    return;
}

$fullName = toName($applicant['last_name'] ?? '', $applicant['first_name'] ?? '', $applicant['middle_name'] ?? '', $applicant['name_extension'] ?? '', true);
$age = !empty($applicant['birthdate']) && $applicant['birthdate'] !== '0000-00-00' ? date_diff(date_create($applicant['birthdate']), date_create('today'))->y : 'N/A';
$fullAddress = implode(', ', array_filter([$applicant['lot'] ?? '', $applicant['street'] ?? '', $applicant['subdivision'] ?? '', $applicant['barangay'] ?? '', $applicant['city'] ?? '', $applicant['province'] ?? '', $applicant['zip'] ?? '']));
$religionName = !empty($applicant['religion_id']) ? (religion($applicant['religion_id'])['name'] ?? 'Not Specified') : (!empty($applicant['specify_other_religion']) ? $applicant['specify_other_religion'] : 'Not Specified');

if (!empty($applicant['ethnic_group_id'])) {
    $egObj = find("SELECT `name` FROM `ethnic_groups` WHERE `id` = ? LIMIT 1", [$applicant['ethnic_group_id']]);
    $ethnicName = $egObj ? $egObj['name'] : (!empty($applicant['specify_other_ethnic_group']) ? $applicant['specify_other_ethnic_group'] : 'Not Specified');
} else {
    $ethnicName = !empty($applicant['specify_other_ethnic_group']) ? $applicant['specify_other_ethnic_group'] : 'Not Specified';
}

$undergraduate = $applicant['undergraduate'] ?? '';
$graduateStudies = $applicant['graduate_studies'] ?? '';
$eligibilities = !empty($applicant['eligibilities']) ? json_decode($applicant['eligibilities'], true) : [];

if (!is_array($eligibilities)) {
    $eligibilities = [];
}

if ($isInternal) {
    if (!function_exists('educationalBackgrounds')) {
        require_once(root() . '/includes/database/education.php');
    }
    if (!function_exists('eligibilities')) {
        require_once(root() . '/includes/database/eligibility.php');
    }

    $empEdbs = educationalBackgrounds($applicantId);
    if (!empty($empEdbs)) {
        $undergradList = [];
        $gradList = [];
        foreach ($empEdbs as $ed) {
            $lvl = strtolower($ed['level'] ?? '');
            $courseStr = !empty($ed['course']) ? $ed['course'] : (!empty($ed['school']) ? $ed['school'] : '');
            if ($courseStr !== '') {
                if (strpos($lvl, 'college') !== false) {
                    $undergradList[] = html_entity_decode($courseStr, ENT_QUOTES);
                } elseif (strpos($lvl, 'graduate') !== false) {
                    $gradList[] = html_entity_decode($courseStr, ENT_QUOTES);
                }
            }
        }
        if (!empty($undergradList)) {
            $undergraduate = implode(', ', array_unique($undergradList));
        }
        if (!empty($gradList)) {
            $graduateStudies = implode(', ', array_unique($gradList));
        }
    }

    $empEligs = eligibilities($applicantId);
    if (!empty($empEligs)) {
        $eligList = [];
        foreach ($empEligs as $el) {
            if (!empty($el['title'])) {
                $eligList[] = html_entity_decode($el['title'], ENT_QUOTES);
            }
        }
        if (!empty($eligList)) {
            $eligibilities = array_values(array_unique($eligList));
        }
    }
}

$applications = applicantApplications($applicantId);
$applicantCode = applicantCode($applicantId) ?: $applicantId;
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Applicants') ?>">Applicants</a></li>
            <li class="breadcrumb-item active"><?= e($fullName) ?></li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php linkButtonSplit(customUri('hrmis', 'Applicants'), 'Back', 'fa-arrow-circle-left') ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card border-left-primary shadow mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    <?php $photo = ($isInternal && !empty($applicant['profile_picture']) && file_exists(root() . '/' . $applicant['profile_picture'])) ? uri() . '/' . $applicant['profile_picture'] : uri() . '/assets/img/user.png'; ?>
                    <img class="img-profile rounded-circle shadow-sm" src="<?= e($photo) ?>" width="110" height="110"
                        alt="Applicant Photo">
                </div>
                <h5 class="font-weight-bold text-dark text-uppercase mb-0"><?= e($fullName) ?></h5>
                <div class="font-weight-bold text-center">
                    <span class="badge badge-secondary">
                        <?= e($applicantCode) ?>
                    </span>
                </div>
                <?php if ($isInternal): ?>
                    <p class="badge badge-primary px-2 py-1 mb-3"><i class="fas fa-building mr-1"></i> Internal</p>
                <?php else: ?>
                    <p class="badge badge-success px-2 py-1 mb-3"><i class="fas fa-globe mr-1"></i> External</p>
                <?php endif; ?>

                <div class="text-left border-top border-bottom py-2 my-2">
                    <p class="small text-muted mb-1 text-lowercase">
                        <i class="fas fa-envelope mr-2 text-primary"></i> <?= e($applicant['email_address'] ?? 'N/A') ?>
                    </p>
                    <p class="small text-muted mb-1">
                        <i class="fas fa-phone mr-2 text-primary"></i> <?= e($applicant['mobile_number'] ?? 'N/A') ?>
                    </p>
                    <p class="small text-muted mb-1 text-capitalize">
                        <i class="fas fa-venus-mars mr-2 text-primary"></i> <?= e($applicant['sex'] ?? 'N/A') ?>
                    </p>
                    <p class="small text-muted mb-1">
                        <i class="fas fa-birthday-cake mr-2 text-primary"></i>
                        <?= $age !== 'N/A' ? "{$age} years old" : 'N/A' ?>
                    </p>
                    <p class="small text-muted mb-0 text-capitalize">
                        <i class="fas fa-heart mr-2 text-primary"></i>
                        <?= e($applicant['civil_status'] ?? 'N/A') ?>
                    </p>
                </div>

                <div class="d-flex justify-content-center mb-n1">
                    <?php if ($isInternal): ?>
                        <?php linkButtonSplit(customUri('hrmis', 'Employee Information', $applicantId), 'Edit', 'fa-edit', 'View / Edit Employee Information', 'primary') ?>
                    <?php else: ?>
                        <?php linkButtonSplit(customUri('hrmis', 'Edit External Applicant', $applicantId), 'Edit', 'fa-edit', 'Edit Applicant Information', 'primary') ?>
                        <?php if (count($applications) === 0): ?>
                            <div class="ml-2">
                                <?php modalButtonSplit(uri() . '/modules/applicants/delete-applicant-dialog.php?id=' . cipher($applicantId), 'Remove', 'fa-trash', 'Remove External Applicant', 'danger') ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 font-weight-bold text-secondary">Date of Birth:</div>
                    <div class="col-sm-8">
                        <?= !empty($applicant['birthdate']) && $applicant['birthdate'] !== '0000-00-00' ? date('F j, Y', strtotime($applicant['birthdate'])) : 'N/A' ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 font-weight-bold text-secondary">Religion:</div>
                    <div class="col-sm-8"><?= e($religionName) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 font-weight-bold text-secondary">Ethnic Group:</div>
                    <div class="col-sm-8"><?= e($ethnicName) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 font-weight-bold text-secondary">Disability Status:</div>
                    <div class="col-sm-8">
                        <?php if (!empty($applicant['with_disability'])): ?>
                            <span class="badge badge-warning">Person with Disability (PWD)</span>
                        <?php else: ?>
                            <span class="badge badge-light border">Non-PWD</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-sm-4 font-weight-bold text-secondary">Residential Address:</div>
                    <div class="col-sm-8"><?= !empty($fullAddress) ? e($fullAddress) : 'Not Specified' ?></div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Education &
                    Eligibilities</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 font-weight-bold text-secondary">Undergraduate:</div>
                    <div class="col-sm-8">
                        <?= !empty($undergraduate) ? e($undergraduate) : 'Not Specified' ?>
                    </div>
                </div>
                <?php if (!empty($graduateStudies)): ?>
                    <div class="row mb-2">
                        <div class="col-sm-4 font-weight-bold text-secondary">Graduate Studies:</div>
                        <div class="col-sm-8"><?= e($graduateStudies) ?></div>
                    </div>
                <?php endif; ?>
                <div class="row mb-0">
                    <div class="col-sm-4 font-weight-bold text-secondary">Eligibilities:</div>
                    <div class="col-sm-8">
                        <?php if (!empty($eligibilities)): ?>
                            <ul class="pl-3 mb-0">
                                <?php foreach ($eligibilities as $elig): ?>
                                    <li><?= e($elig) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span class="text-muted">None specified</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card border-left-info shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Application Submission
                    History <span class="badge badge-info">
                        <?= count($applications) ?>
                    </span></h6>
            </div>
            <div class="card-body">
                <?php if (!empty($applications)): ?>
                    <div class="table-responsive">
                        <table class="table mb-0" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle">Position Title</th>
                                    <th class="align-middle">Call for Application</th>
                                    <th class="align-middle text-center">Date Applied</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app):
                                    $doc = applicantDocument($app['publication_id'], $applicantId);
                                    $statusClass = 'secondary';
                                    if ($app['status'] === 'Qualified')
                                        $statusClass = 'success';
                                    elseif ($app['status'] === 'Disqualified')
                                        $statusClass = 'danger';
                                    elseif ($app['status'] === 'For Review')
                                        $statusClass = 'warning';
                                    ?>
                                    <tr>
                                        <td class="align-middle font-weight-bold">
                                            <?= e($app['official_title']) ?>
                                        </td>
                                        <td class="align-middle small">
                                            <?php
                                            $pubTitle = $app['publication_title'] ?: ('Publication #' . $app['publication_id']);
                                            $pubUri = customUri('hrmis', 'Call for Application Details', $app['publication_id']);
                                            ?>
                                            <a href="<?= e($pubUri) ?>">
                                                <?= e($pubTitle) ?>
                                                <?php if (!empty($app['publication_code'])): ?>
                                                    (<?= e($app['publication_code']) ?>)
                                                <?php endif; ?>
                                            </a>
                                        </td>
                                        <td class="align-middle text-center small">
                                            <?= toDateTime($app['created_at']) ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-<?= $statusClass ?> px-2 py-1">
                                                <?= e($app['status']) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <?php if ($doc && file_exists(root() . '/' . $doc)): ?>
                                                <a href="<?= root() . '/' . $doc ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary" title="View Document">
                                                    <i class="fas fa-paperclip"></i> View
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">None</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="small">
                                    <th class="align-middle">Position Title</th>
                                    <th class="align-middle">Call for Application</th>
                                    <th class="align-middle text-center">Date Applied</th>
                                    <th class="align-middle text-center">Status</th>
                                    <th class="align-middle text-center">Attachment</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center my-3"><i class="fas fa-info-circle mr-1"></i> No job applications have
                        been submitted by this <?= $isInternal ? 'internal' : 'external' ?> applicant yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>