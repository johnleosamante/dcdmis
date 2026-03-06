<?php
// modules/vacancies/publication-details.php

if (!$isHrmpsb && !$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

$publicationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$code = 'N/A';
$title = 'Publication Details';

if ($publicationId) {
    $pubResult = publication($publicationId);
    if (numRows($pubResult) > 0) {
        $pub = fetchAssoc($pubResult);
        $code = $pub['code'];
        $title = $pub['title'];
    }
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmpsb', 'Publications') ?>">Publications</a></li>
            <li class="breadcrumb-item active">
                <?= e($code) ?>
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Publication Info -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Publication Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= ucfirst($pub['status']) ?>
                        </div>
                        <div class="small text-muted mt-2">
                            <?= toLongDate($pub['open_date']) ?> -
                            <?= toLongDate($pub['close_date']) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Count -->
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
                            <a href="<?= uri() . '/hrmpsb/apply?p=' . $code ?>" target="_blank">
                                <?= uri() . '/hrmpsb/apply?p=' . $code ?>
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

<!-- Included Vacancies -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Included Vacancies</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Item Number</th>
                        <th>SG</th>
                        <th>Station</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items = publicationItems($publicationId);
                    while ($item = fetchAssoc($items)):
                        ?>
                        <tr>
                            <td>
                                <?= e($item['position']) ?>
                            </td>
                            <td>
                                <?= e($item['item_number']) ?>
                            </td>
                            <td>
                                <?= e($item['salary_grade']) ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($item['station_id'])) {
                                    $school = fetchAssoc(schoolById($item['station_id']));
                                    echo $school ? $school['name'] : 'N/A';
                                } else {
                                    echo 'TO BE DETERMINED';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Applications List -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Applications Received</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="applications-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date Submitted</th>
                        <th>Applicant Name</th>
                        <th>Applied For</th>
                        <th>Contact</th>
                        <th>Resume</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $apps = applicationsByPublication($publicationId);
                    while ($app = fetchAssoc($apps)):
                        ?>
                        <tr>
                            <td>
                                <?= toLongDate($app['submitted_on']) ?>
                            </td>
                            <td class="font-weight-bold text-uppercase">
                                <?= e($app['applicant_name']) ?>
                            </td>
                            <td>
                                <?= e($app['position']) ?><br><small>
                                    <?= e($app['item_number']) ?>
                                </small>
                            </td>
                            <td>
                                <div><i class="fas fa-envelope mr-1 text-gray-400"></i>
                                    <?= e($app['email']) ?>
                                </div>
                                <div><i class="fas fa-phone mr-1 text-gray-400"></i>
                                    <?= e($app['mobile']) ?>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($app['resume_path'])): ?>
                                    <a href="<?= uri() . '/' . $app['resume_path'] ?>" target="_blank"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-file-pdf"></i> View
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">No file</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= $app['status'] == 'pending' ? 'warning' : 'success' ?>">
                                    <?= ucfirst($app['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#applications-table').DataTable();
    });
</script>