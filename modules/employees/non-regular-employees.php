<?php
// modules/employees/non-regular-employees.php
if (!$isHrmis && !$isHrtdms && !$isDmis && !$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
$selectedType = isset($_GET['type']) ? sanitize($_GET['type']) : '';
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Non-Regular Employees</li>
        </ol>
    </nav>

    <?php if ($isHrmis): ?>
        <div class="d-inline-block">
            <?php modalButtonSplit(uri() . '/modules/employees/save-non-regular-employee-dialog.php', 'Add Non-Regular Employee', 'fa-user-plus') ?>
        </div>
    <?php endif ?>
</div>

<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <?php contentTitle('Contract of Service, Job Order, Casual & Substitute Teacher Employees') ?>

        <div class="btn-group btn-group-sm" role="group">
            <a href="<?= customUri($activeApp, 'Non-Regular Employees') ?>"
                class="btn btn-<?= empty($selectedType) ? 'info' : 'outline-info' ?>">All</a>
            <a href="<?= customUri($activeApp, 'Non-Regular Employees') ?>&type=Contract of Service"
                class="btn btn-<?= $selectedType === 'Contract of Service' ? 'info' : 'outline-info' ?>">COS</a>
            <a href="<?= customUri($activeApp, 'Non-Regular Employees') ?>&type=Job Order"
                class="btn btn-<?= $selectedType === 'Job Order' ? 'info' : 'outline-info' ?>">Job Order</a>
            <a href="<?= customUri($activeApp, 'Non-Regular Employees') ?>&type=Casual"
                class="btn btn-<?= $selectedType === 'Casual' ? 'info' : 'outline-info' ?>">Casual</a>
            <a href="<?= customUri($activeApp, 'Non-Regular Employees') ?>&type=Substitute Teacher"
                class="btn btn-<?= $selectedType === 'Substitute Teacher' ? 'info' : 'outline-info' ?>">Substitute
                Teacher</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="15%">Category</th>
                        <th class="align-middle" width="20%">Name</th>
                        <th class="align-middle" width="20%">Email Address</th>
                        <th class="align-middle" width="15%">Position</th>
                        <th class="align-middle" width="15%">Station</th>
                        <th class="align-middle" width="10%">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $nonRegulars = nonRegularEmployees($selectedType);
                    foreach ($nonRegulars as $row):
                        $employeeName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
                        $photo = file_exists(root() . '/' . $row['profile_picture']) ? uri() . '/' . $row['profile_picture'] : uri() . '/assets/img/user.png';
                        $pos = positions($row['position_id']);
                        $stn = schoolById($row['station_id'])['name'];
                        $typeBadgeClass = match ($row['employment_type']) {
                            'Contract of Service' => 'badge-primary',
                            'Job Order' => 'badge-warning',
                            'Casual' => 'badge-success',
                            'Substitute Teacher' => 'badge-danger',
                            default => 'badge-info'
                        };
                        ?>
                        <tr>
                            <td class="align-middle">
                                <div class="image-container">
                                    <img class="img-profile rounded-circle" src="<?= e($photo) ?>" alt="Profile"
                                        style="width:40px; height:40px; object-fit:cover;">
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge <?= $typeBadgeClass ?> p-2"><?= e($row['employment_type']) ?></span>
                            </td>
                            <td class="align-middle text-left font-weight-bold">
                                <?= e(strtoupper($employeeName)) ?>
                            </td>
                            <td class="align-middle text-lowercase">
                                <?= e($row['email_address']) ?>
                            </td>
                            <td class="align-middle text-uppercase">
                                <?= e($pos ?: 'N/A') ?>
                            </td>
                            <td class="align-middle text-uppercase">
                                <?= e($stn ?: 'N/A') ?>
                            </td>
                            <td class="align-middle">
                                <span
                                    class="badge badge-<?= $row['status'] === 'Active' ? 'success' : 'secondary' ?> p-2"><?= e($row['status']) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>