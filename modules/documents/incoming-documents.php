<?php
// modules/documents/incoming-documents.php
if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}
messageAlert($showAlert, $message, $success);

$query = incomingDocuments($station);
if (count($query) === 1000) {
    $message = "Showing latest 1,000 incoming documents.";
    messageAlert(true, $message);
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Incoming</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Incoming Documents', uri() . '/dts') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="30%">Description</th>
                        <th class="align-middle" width="20%">From</th>
                        <th class="align-middle" width="15%">Date</th>
                        <th class="align-middle" width="15%">Purpose</th>
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
                            <td class="align-middle text-uppercase">
                                <?= stationName($row['received_from']) ?>
                            </td>
                            <td class="align-middle"><?= toDatetime($row['created_at']) ?></td>
                            <td class="align-middle"><?= e(documentTransactionStatus($row['status_id'])) ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                                        modalDropdownItem(uri() . '/modules/documents/receive-document-dialog.php?id=' . cipher($row['id']), 'Receive', 'fa-hand-holding-medical', 'Receive Document');

                                        if ($row['created_from'] === $station) {
                                            linkDropdownItem(customUri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="30%">Description</th>
                        <th class="align-middle" width="20%">From</th>
                        <th class="align-middle" width="15%">Date</th>
                        <th class="align-middle" width="15%">Purpose</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>