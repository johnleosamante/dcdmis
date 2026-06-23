<?php
// modules/vacancies/publication-details.php

if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

$publicationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$code = $title = $description = null;

if ($publicationId) {
    $publication = publication($publicationId);
    if (count($publication) > 0) {
        $code = $publication['code'];
        $title = $publication['title'];
        $description = $publication['description'];
    }
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Call for Applications') ?>">Call for
                    Applications</a></li>
            <li class="breadcrumb-item active">
                <?= e($code) ?>
            </li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isHrmis && ($isPersonnel || $isICT)) {
            contentTitleWithLink('Details', customUri('hrmis', 'Edit Call for Application', $publicationId), 'Edit', 'fa-edit');
        } else {
            contentTitle('Details');
        } ?>
    </div>

    <div class="card-body">
        <h2 class="my-0"><?= e($title) ?></h2>
        <?php if (!empty(e($description))): ?>
            <p class="mt-1 mb-0"><?= e($description) ?></p>
        <?php endif ?>
    </div>
</div>


<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= ucfirst($publication['status']) ?>
                        </div>
                        <div class="small text-muted mt-2">
                            <?= toLongDate($publication['open_date']) ?> -
                            <?= toLongDate($publication['close_date']) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-0">
                            Total Applications</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            <?= countApplicationsByPublication($publicationId) ?>
                        </div>
                        <div class="small text-muted mt-0">
                            <?php $applicantsCount = countApplicantsByPublication($publicationId);
                            echo "{$applicantsCount} applicant" . ($applicantsCount > 1 ? 's' : '') ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Public Link</div>
                        <div class="font-weight-bold text-gray-800 text-truncate">
                            <a href="<?= uri() . '/hrmis/apply?p=' . $code ?>" target="_blank">
                                <?= uri() . '/hrmis/apply?p=' . $code ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-link fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold">Applications for Initial Screening</h6>
            <div>
                <?php linkButtonSplit(customUri('hrmis', 'Qualified Applicants', $publicationId), 'Qualified', 'fa-thumbs-up', 'View Qualified Applicants', 'success');
                linkButtonSplit(customUri('hrmis', 'Disqualified Applicants', $publicationId), 'Disqualified', 'fa-thumbs-down', 'View Disqualified Applicants', 'danger'); ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-center" width="100%" cellspacing="0" id="data-table">
                <thead>
                    <tr>
                        <th width="15%" class="align-middle">Applied on</th>
                        <th width="40%" class="align-middle">Applicant</th>
                        <th width="30%" class="align-middle">Position Applied</th>
                        <th width="15%" class="align-middle">Attachment</th>
                        <?php if ($isHrmis && ($isPersonnel || $isICT) && $publication['status'] === 'open'): ?>
                            <th width="5%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $apps = applicantsForReviewByPublication($publicationId);
                    foreach ($apps as $app): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <?= toDatetime($app['created_at']) ?>
                            </td>
                            <td class="align-middle">
                                <?= applicantName($app['application_code']) ?>
                            </td>
                            <td class="align-middle">
                                <div>
                                    <?= e($app['official_title']) ?>
                                </div>
                            </td>
                            <td class="align-middle text-capitalize">
                                <?php
                                $applicantDocument = applicantDocument($publicationId, applicantId($app['application_code']));
                                $documentUri = root() . "/{$applicantDocument}";
                                if (!empty($applicantDocument) && file_exists($documentUri)) {
                                    linkButtonSplit("{$baseUri}/{$applicantDocument}", 'Document', 'fa-paperclip', "View Document Attachment", 'secondary', true);
                                } else { ?>
                                    <div class="small">No document attachment</div>
                                <?php } ?>
                            </td>
                            <?php if ($isHrmis && ($isPersonnel || $isICT) && $publication['status'] === 'open'): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php if ($app['status'] === 'For Review') {
                                                modalDropdownItem(uri() . '/modules/vacancies/qualify-application-dialog.php?id=' . cipher($app['id']), 'Qualify', 'fa-thumbs-up', 'Qualify Application');
                                                modalDropdownItem(uri() . '/modules/vacancies/disqualify-application-dialog.php?id=' . cipher($app['id']), 'Disqualify', 'fa-thumbs-down', 'Disqualify Application');
                                            } else {
                                                modalDropdownItem(uri() . '/modules/vacancies/for-review-application-dialog.php?id=' . cipher($app['id']), 'For Initial Screening', 'fa-redo', 'Mark Application For Initial Screening');
                                                if ($app['status'] === 'Qualified') {
                                                    modalDropdownItem(uri() . '/modules/vacancies/disqualify-application-dialog.php?id=' . cipher($app['id']), 'Disqualify', 'fa-thumbs-down', 'Disqualify Application');
                                                } else {
                                                    modalDropdownItem(uri() . '/modules/vacancies/qualify-application-dialog.php?id=' . cipher($app['id']), 'Qualify', 'fa-thumbs-up', 'Qualify Application');
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th width="15%" class="align-middle">Applied on</th>
                        <th width="40%" class="align-middle">Applicant</th>
                        <th width="30%" class="align-middle">Position Applied</th>
                        <th width="15%" class="align-middle">Attachment</th>
                        <?php if ($isHrmis && ($isPersonnel || $isICT) && $publication['status'] === 'open'): ?>
                            <th width="5%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Included Vacancies</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="30%">Position / Salary Grade</th>
                        <th class="align-middle" width="20%">Item Number</th>
                        <th class="align-middle" width="35%">Station</th>
                        <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                            <th class="align-middle" width="15%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items = publicationItems($publicationId);
                    foreach ($items as $item): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <?= e($item['official_title']) . ' (' . e($item['salary_grade']) . ')' ?>
                            </td>
                            <td class="align-middle"><?= e($item['item_number']) ?></td>
                            <td class="align-middle">
                                <?php $school = schoolById($item['station_id']);
                                echo $school ? $school['name'] : 'N/A'; ?>
                            </td>
                            <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                                <td class="align-middle text-capitalize">
                                    <?php if ($item['status'] === 'filled') { ?>
                                        <span class="badge badge-success py-1 px-2 text-uppercase small">Filled</span>
                                    <?php } elseif (countQualifiedApplicants($publicationId, $item['position_id']) === 0) { ?>
                                        <span class="badge badge-secondary py-1 px-2 text-uppercase small">No Qualified
                                            Applicants</span>
                                    <?php } else {
                                        modalButtonSplit(uri() . '/modules/vacancies/fill-vacancy-dialog.php?id=' . cipher($item['vacancy_id']), 'Fill Position', 'fa-user-plus', 'Fill Position Item');
                                    } ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="align-middle" width="30%">Position / Salary Grade</th>
                        <th class="align-middle" width="20%">Item Number</th>
                        <th class="align-middle" width="35%">Station</th>
                        <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                            <th class="align-middle" width="15%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>