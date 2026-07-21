<?php
// modules/201-file/page.php
if (!$isPis && !$isHrmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

$isHeadOfThisEmployee = false;
$schoolInfo = schoolByHead($userId);
if ($schoolInfo && $employeeId > 0) {
    $empStation = station($employeeId);
    if ($empStation && $empStation['station_id'] === $schoolInfo['id']) {
        $isHeadOfThisEmployee = true;
    }
}

$userPositionId = null;
if ($isPis) {
    if (!function_exists('position')) {
        require_once(root() . '/includes/database/position.php');
    }
    $userPosition = position($userId);
    $userPositionId = $userPosition['position_id'] ?? null;
}
$isAllowedHigherPosition = $isPis && (in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT);

if ($isPis && $userId !== $employeeId && !$isHeadOfThisEmployee && !$isAllowedHigherPosition) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employee = employee($employeeId);

if ($employee) {
    $employeeId = $employee['id'];
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
            <li class="breadcrumb-item active">201 Files</li>
        </ol>
    </nav>
</div>

<?php
if ($isHrmis) {
    require_once(root() . '/modules/employees/employee-tabs.php');
}

$uploadDirectory = root() . '/uploads/201_files/' . $employeeId;

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isHrmis) {
            contentTitleWithModal('201 Files : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])), uri() . '/modules/201-file/save-201-file-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus');
        } else {
            contentTitleWithLink('201 Files : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])), uri() . '/pis');
        } ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="25%">Uploaded on</th>
                        <th class="align-middle" width="75%">Description / File Type</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $results = fileAttachments($employeeId);

                    foreach ($results as $row):
                        $fullPath = root() . '/' . $row['file_name'];
                        $fileExists = !empty($row['file_name']) && file_exists($fullPath);
                        $showActions = $fileExists || $isHrmis;
                        ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= toDatetime($row['created_at']) ?></td>
                            <td class="align-middle text-left">
                                <div><?= e($row['description']) ?></div>
                                <div class="small text-muted"><?= e($row['file_type']) ?></div>
                            </td>
                            <td class="align-middle text-capitalize">
                                <?php if ($showActions): ?>
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                                            <?php
                                            if ($fileExists) {
                                                previewLinkDropdownItem(uri() . '/' . $row['file_name'], 'Preview', 'fa-eye', 'Preview ' . $row['description']);
                                                downloadLinkDropdownItem(uri() . '/' . $row['file_name'], 'Download', 'fa-download', 'Download ' . $row['description'], $row['description'] . '.' . $row['file_extension'], true);
                                            }

                                            if ($isHrmis) {
                                                if ($fileExists) {
                                                    echo '<div class="dropdown-divider"></div>';
                                                }
                                                modalDropdownItem(uri() . '/modules/201-file/save-201-file-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit 201 File');
                                                modalDropdownItem(uri() . '/modules/201-file/save-201-file-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy 201 File');
                                                echo '<div class="dropdown-divider"></div>';
                                                modalDropdownItem(uri() . '/modules/201-file/delete-201-file-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($row['id']), 'Delete', 'fa-trash', 'Delete 201 File');
                                            }
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
                        <th class="align-middle" width="25%">Uploaded on</th>
                        <th class="align-middle" width="75%">Description / File Type</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>