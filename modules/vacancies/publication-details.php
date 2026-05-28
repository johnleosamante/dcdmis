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
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Publications') ?>">Publications</a></li>
            <li class="breadcrumb-item active">
                <?= e($code) ?>
            </li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isHrmis && $isPersonnel) {
            contentTitleWithLink('Publication Details', customUri('hrmis', 'Publish Vacancies', $publicationId), 'Edit', 'fa-edit');
        } else {
            contentTitle('Publication Details');
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
                            Publication Status</div>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Applications</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= countApplicationsByPublication($publicationId) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Public Link -->
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Public Application Link</div>
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
        <h6 class="m-0 font-weight-bold">Included Vacancies</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="35%">Position / Salary Grade</th>
                        <th class="align-middle" width="25%">Item Number</th>
                        <th class="align-middle" width="40%">Station</th>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="align-middle" width="35%">Position / Salary Grade</th>
                        <th class="align-middle" width="25%">Item Number</th>
                        <th class="align-middle" width="40%">Station</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Applications Received</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-center" width="100%" cellspacing="0" id="data-table">
                <thead>
                    <tr>
                        <th width="20%" class="align-middle">Applied on</th>
                        <th width="55" class="align-middle">Applicant</th>
                        <th width="25" class="align-middle">Position</th>
                        <?php if ($isHrmis && $isPersonnel): ?>
                            <th width="5%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $apps = applicantsByPublication($publicationId);
                    foreach ($apps as $app): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= toDatetime($app['created_at']) ?></td>
                            <td class="align-middle">
                                <?= applicantName($app['application_code']) ?>
                            </td>
                            <td class="align-middle">
                                <div><?= e($app['official_title']) ?></div>
                            </td>
                            <?php if ($isHrmis && $isPersonnel): ?>
                                <td class="align-middle"></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th width="20%" class="align-middle">Applied on</th>
                        <th width="55" class="align-middle">Applicant</th>
                        <th width="25" class="align-middle">Position</th>
                        <?php if ($isHrmis && $isPersonnel): ?>
                            <th width="5%" class="align-middle">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>