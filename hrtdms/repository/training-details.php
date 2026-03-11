<?php
// hrtdms/repository/training-details.php

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$training = training($trainingId);
$participants = trainingParticipants($trainingId);

if ($training) {
    $trainingId = $training['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}
?>

<div class="card-header py-3">
    <?php contentTitleWithLink('Training Details', uri() . '/hrtdms/repository') ?>
</div>

<div class="card-body">
    <div class="table-responsive mb-3">
        <table cellspacing="0">
            <tr>
                <th class="pr-5" scope="row">Code</th>
                <td class="text-uppercase"><?= e($training['id']) ?></td>
            </tr>
            <tr>
                <th class="align-top pr-5" scope="row">Title</th>
                <td class="text-uppercase"><?= e($training['title']) ?></td>
            </tr>
            <tr>
                <th class="pr-5" scope="row">Date</th>
                <td class="text-uppercase">
                    <?= empty($training['unconsecutive_date']) ? toDateRange($training['start_date'], $training['end_date']) : toHandleEncoding($training['unconsecutive_date']) ?>
                </td>
            </tr>
            <?php if (!empty($training['number_of_hours'])): ?>
                <tr>
                    <th class="pr-5" scope="row">Hours</th>
                    <td class="text-uppercase"><?= e($training['number_of_hours']) ?></td>
                </tr>
            <?php endif ?>
            <tr>
                <th class="pr-5" scope="row">Type</th>
                <td class="text-uppercase"><?= trainingType($training['training_type_id']) ?></td>
            </tr>
            <tr>
                <th class="pr-5" scope="row">Level</th>
                <?php
                $functional_division = functionalDivision($training['functional_division_id']);
                $functional_division = (!empty($functional_division) && strtolower($functional_division['name']) !== 'n/a') ? " ({$functional_division['name']})" : '';
                ?>
                <td class="text-uppercase"><?= trainingSponsor($training['conducted_by']) . $functional_division ?></td>
            </tr>
            <?php if (!empty($training['sponsor'])): ?>
                <tr>
                    <th class="align-top pr-5" scope="row">Sponsor</th>
                    <td class="text-uppercase"><?= e($training['sponsor']) ?></td>
                </tr>
            <?php endif ?>
            <?php if (!empty($training['venue'])): ?>
                <tr>
                    <th class="align-top pr-5" scope="row">Venue</th>
                    <td class="text-uppercase"><?= e($training['venue']) ?></td>
                </tr>
            <?php endif ?>
            <tr>
                <th class="align-top pr-5" scope="row">Participants</th>
                <td class="text-uppercase"><?= count($participants) ?></td>
            </tr>
        </table>
    </div>

    <div class="table-responsive mt-2">
        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="align-middle" width="5%">Photo</th>
                    <th class="align-middle" width="35%">Name</th>
                    <th class="align-middle" width="20%">Position</th>
                    <th class="align-middle" width="25%">Station</th>
                    <th class="align-middle" width="5%">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($participants as $row):
                    $employeeName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
                    $photo = file_exists(root() . '/' . $row['profile_picture']) ? uri() . '/' . $row['profile_picture'] : uri() . '/assets/img/user.png';
                    ?>
                    <tr class="text-uppercase">
                        <td class="align-middle">
                            <div class="image-container">
                                <span
                                    class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                    <img height="100%" src="<?= e($photo) ?>" alt="<?= e($employeeName) ?>">
                                </span>
                                <div class="sex-sign"><?php sex($row['sex']) ?></div>
                            </div>
                        </td>
                        <td class="align-middle text-left">
                            <?= e($employeeName) ?>
                        </td>
                        <td class="align-middle"><?= positions($row['position_id'])['official_title'] ?></td>
                        <td class="align-middle"><?= schoolById($row['station_id'])['name'] ?></td>
                        <td class="align-middle text-capitalize">
                            <div class="dropdown no-arrow">
                                <?php dropdownEllipsis() ?>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                    <?php
                                    if ($training['has_certificate']):
                                        linkDropdownItem(customUri('print', 'Certificate of Participation', $training['id']) . '&p=' . encode($row['id']), 'Certificate', 'fa-certificate', 'View Certificate of Participation', true) ?>
                                    <?php endif;
                                    linkDropdownItem(customUri('print', 'Certificate of Appearance', $training['id']) . '&p=' . encode($row['id']), 'Appearance', 'fa-stamp', 'View Certificate of Appearance', true) ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

            <tfoot>
                <tr>
                    <th class="align-middle" width="5%">Photo</th>
                    <th class="align-middle" width="35%">Name</th>
                    <th class="align-middle" width="20%">Position</th>
                    <th class="align-middle" width="25%">Station</th>
                    <th class="align-middle" width="5%">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>