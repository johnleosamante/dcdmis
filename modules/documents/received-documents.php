<?php
// modules/documents/received-documents.php
if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);

$query = receivedDocuments($station, $from, $to);
if (count($query) === 1000) {
    $message = "Showing latest 1,000 received documents as of " . toDate($from, 'F j, Y') . ' - ' . toDate($to, 'F j, Y') . ".";
    messageAlert(true, $message);
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Received</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Received Documents', uri() . '/dts') ?>
    </div>

    <div class="card-body">
        <?= dateFilterForm($from, $to) ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="45">Description</th>
                        <th class="align-middle" width="20%">Received by</th>
                        <th class="align-middle" width="15%">Received on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($query as $row) {
                        ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']) ?>
                            </td>
                            <td class="text-left align-middle"><?= toTruncate($row['description']) ?></td>
                            <td class="align-middle">
                                <div>
                                    <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['processor_id']), userName($row['processor_id'])) ?>
                                </div>
                                <div class="small"><?= position($row['processor_id'])['official_title'] ?></div>
                            </td>
                            <td class="align-middle"><?= toDatetime($row['created_at']) ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information') ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="45">Description</th>
                        <th class="align-middle" width="20%">Received by</th>
                        <th class="align-middle" width="15%">Received on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>