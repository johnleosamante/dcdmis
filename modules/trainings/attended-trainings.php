<?php
// modules/trainings/attended-trainings.php
if (!$isPis && !$isHrmis && !$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

if ($isPis && $userId !== $employeeId) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employee = employee($employeeId);
$employeeName = $schoolId = $schoolName = '';

if ($employee) {
    $employeeId = $employee['id'];
    $employeeName = strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension']));
    $schoolId = station($employeeId)['station_id'];
    $schoolName = schoolById($schoolId)['name'];
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
            <?php if ($isHrtdms): ?>
                <li class="breadcrumb-item"><a href="<?= customUri($activeApp, 'Schools') ?>">Schools</a></li>
                <li class="breadcrumb-item"><a
                        href="<?= customUri($activeApp, 'School Information', $schoolId) ?>"><?= e($schoolName) ?></a></li>
                <li class="breadcrumb-item active">Employee Trainings</li>
            <?php else: ?>
                <li class="breadcrumb-item active">Trainings</li>
            <?php endif ?>
        </ol>
    </nav>
</div>

<?php
if ($isHrmis) {
    require_once(root() . '/modules/employees/employee-tabs.php');
}
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isPis) {
            contentTitleWithLink("Trainings : {$employeeName}", uri() . '/pis');
        } elseif ($isHrtdms) {
            contentTitleWithLink("Trainings : {$employeeName}", customUri($activeApp, 'School Information', $schoolId));
        } else {
            contentTitle("Trainings : {$employeeName}");
        } ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="35%">Title of Learning &amp; Development Interventions /
                            Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="15%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="20%">Venue</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $trainings = attendedTrainings($employeeId);
                    foreach ($trainings as $training): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= e($training['title']) ?></td>
                            <td class="align-middle"><?= toDate($training['start_date']) ?></td>
                            <td class="align-middle"><?= toDate($training['end_date']) ?></td>
                            <td class="align-middle"><?= e($training['number_of_hours']) ?></td>
                            <td class="align-middle"><?= e($training['training_type']) ?></td>
                            <td class="align-middle"><?= e($training['sponsored_by']) ?></td>
                            <td class="align-middle"><?= e($training['venue']) ?></td>
                            <td class="align-middle text-capitalize">
                                <?php if ($training['has_certificate']): ?>
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                                            <?php
                                            linkDropdownItem(customUri('print', 'Certificate of Participation', $training['id']) . '&p=' . encode($employeeId), 'Participation', 'fa-star', 'Certificate of Participation', true);
                                            linkDropdownItem(customUri('print', 'Certificate of Appearance', $training['id']) . '&p=' . encode($employeeId), 'Appearance', 'fa-stamp', 'Certificate of Appearance', true);
                                            ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="35%">Title of Learning &amp; Development Interventions /
                            Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="15%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="20%">Venue</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>