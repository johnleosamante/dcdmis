<?php
// modules/applicants/page.php
if (!$isHrmis || (!$isPersonnel && !$isICT)) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);

$selectedType = isset($_GET['type']) ? sanitize($_GET['type']) : 'all';
if (!in_array($selectedType, ['all', 'internal', 'external'], true)) {
    $selectedType = 'all';
}

$allApplicants = allApplicantsList('all');
$filteredApplicants = allApplicantsList($selectedType);

$countTotal = count($allApplicants);
$countInternal = 0;
$countExternal = 0;

foreach ($allApplicants as $appItem) {
    if (!empty($appItem['is_employed'])) {
        $countInternal++;
    } else {
        $countExternal++;
    }
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Applicants</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Applicants', uri() . '/hrmis') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center">
                        <th class="align-middle" width="40%">Name</th>
                        <th class="align-middle" width="45%">Details</th>
                        <th class="align-middle" width="10%">Applications</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($filteredApplicants as $row):
                        $isEmployed = !empty($row['is_employed']);
                        $fullName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension'], true);
                        $appCount = (int) ($row['application_count'] ?? 0);

                        if ($isEmployed) {
                            $empPos = position($row['id']);
                            $posText = $empPos['official_title'] ?? 'Division Employee';
                            $stationText = $empPos['station'] ?? '';
                            $profileLink = customUri('hrmis', 'Employee Information', $row['id']);
                        } else {
                            $address = implode(', ', array_filter([$row['barangay'], $row['city'], $row['province']]));
                            $profileLink = customUri('hrmis', 'Applicant Information', $row['id']);
                        }
                        ?>
                        <tr>
                            <td class="align-middle">
                                <div class="font-weight-bold">
                                    <?php linkItem($profileLink, $fullName) ?>
                                </div>
                                <div class="text-muted">
                                    <span class="badge badge-secondary">
                                        <?= e($row['id']) ?>
                                    </span>
                                </div>
                                <div>
                                    <?php if ($isEmployed): ?>
                                        <span class="badge badge-primary px-2 py-1"><i class="fas fa-building mr-1"></i>
                                            Internal</span>
                                    <?php else: ?>
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-globe mr-1"></i>
                                            External</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="align-middle small">
                                <div><?= e($row['email_address']) ?></div>
                                <div><?= e($row['mobile_number']) ?></div>
                                <?php if ($isEmployed): ?>
                                    <div class="font-weight-bold text-dark"><?= e($posText) ?></div>
                                    <div class="text-muted"><?= e($stationText) ?></div>
                                <?php else: ?>
                                    <div><?= e($row['undergraduate']) ?></div>
                                    <div class="text-muted"><?= e($address) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-<?= $appCount > 0 ? 'info' : 'secondary' ?> badge-pill px-2 py-1">
                                    <?= $appCount ?>
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        if ($isEmployed) {
                                            linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-id-badge', 'View Employee Profile');
                                        } else {
                                            linkDropdownItem(customUri('hrmis', 'Applicant Information', $row['id']), 'View', 'fa-eye', 'View Applicant Details');
                                            linkDropdownItem(customUri('hrmis', 'Edit External Applicant', $row['id']), 'Edit', 'fa-edit', 'Edit External Applicant');
                                            if ($appCount === 0) {
                                                echo '<div class="dropdown-divider"></div>';
                                                modalDropdownItem(uri() . '/modules/applicants/delete-applicant-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Delete Applicant');
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>