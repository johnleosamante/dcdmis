<?php
// modules/vacancies/disqualified-applicants.php

if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

$publicationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$code = $title = null;

if ($publicationId) {
    $publication = publication($publicationId);
    if (count($publication) > 0) {
        $code = $publication['code'];
        $title = $publication['title'];
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
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Publications') ?>">Publications</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Publication Details', $publicationId) ?>">
                    <?= e($code) ?>
                </a></li>
            <li class="breadcrumb-item active">Disqualified Applicants</li>
        </ol>
    </nav>
</div>

<div class="card border-left-danger shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Disqualified Applicants', customUri('hrmis', 'Publication Details', $publicationId), 'Back', 'fa-arrow-circle-left') ?>
    </div>

    <div class="card-body">
        <h5 class="my-0"><?= e($title) ?></h5>
        <?php if (!empty($publication['description'])): ?>
            <p class="mt-1 mb-1"><?= e($publication['description']) ?></p>
        <?php endif ?>
        <small class="text-muted">Publication Code: <?= e($code) ?></small>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Disqualified Applicants</h6>
        <?php linkButtonSplit(uri() . '/export?v=' . encode('disqualified-applicants') . '&id=' . encode($publicationId), 'Export', 'fa-download', 'Export Disqualified Applicants', 'success'); ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-center" width="100%" cellspacing="0" id="data-table">
                <thead>
                    <tr>
                        <th width="12%" class="align-middle">Applied on</th>
                        <th width="25%" class="align-middle">Applicant</th>
                        <th width="23%" class="align-middle">Position Applied</th>
                        <th width="20%" class="align-middle">Remarks</th>
                        <th width="10%" class="align-middle">Document</th>
                        <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                            <th width="10%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $apps = applicantsByPublication($publicationId);
                    $disqualifiedApps = array_filter($apps, function ($app) {
                        return $app['status'] === 'Disqualified';
                    });

                    if (count($disqualifiedApps) > 0) {
                        foreach ($disqualifiedApps as $app): ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= toDatetime($app['created_at']) ?></td>
                                <td class="align-middle">
                                    <?= applicantName($app['application_code']) ?>
                                </td>
                                <td class="align-middle">
                                    <div><?= e($app['official_title']) ?></div>
                                </td>
                                <td class="align-middle text-capitalize">
                                    <div class="text-muted font-italic small text-uppercase"><?= e($app['remarks'] ?? '') ?>
                                    </div>
                                </td>
                                <td class="align-middle text-capitalize">
                                    <?php
                                    $applicantDocument = applicantDocument($publicationId, applicantId($app['application_code']));
                                    $documentUri = root() . "/{$applicantDocument}";
                                    if (!empty($applicantDocument) && file_exists($documentUri)) {
                                        linkButtonSplit("{$baseUri}/{$applicantDocument}", 'Attachment', 'fa-paperclip', "View Applicant Document", 'secondary', true);
                                    } else { ?>
                                        <div class="small">No document attachment</div>
                                    <?php } ?>
                                </td>
                                <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php
                                                modalDropdownItem(uri() . '/modules/vacancies/for-review-application-dialog.php?id=' . cipher($app['id']), 'For Review', 'fa-redo', 'Mark Application For Review');
                                                modalDropdownItem(uri() . '/modules/vacancies/qualify-application-dialog.php?id=' . cipher($app['id']), 'Qualify', 'fa-thumbs-up', 'Qualify Application');
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach;
                    } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th width="12%" class="align-middle">Applied on</th>
                        <th width="25%" class="align-middle">Applicant</th>
                        <th width="23%" class="align-middle">Position Applied</th>
                        <th width="20%" class="align-middle">Remarks</th>
                        <th width="10%" class="align-middle">Document</th>
                        <?php if ($isHrmis && $isPersonnel && $publication['status'] === 'open'): ?>
                            <th width="10%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>