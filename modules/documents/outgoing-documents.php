<?php
// modules/documents/outgoing-documents.php
if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center flex-row-reverse mt-2 mb-3">
    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus'); ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Outgoing Documents', uri() . '/dts'); ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="25%">Description</th>
                        <th class="align-middle" width="20%">Forwarded by</th>
                        <th class="align-middle" width="20%">Forwarded to</th>
                        <th class="align-middle" width="15%">Forwarded on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = outgoingDocuments($station);
                    while ($row = fetchArray($query)) { ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']); ?></td>
                            <td class="text-left align-middle"><?php echo $row['description']; ?></td>
                            <td class="align-middle">
                                <div>
                                    <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['user']), userName($row['user'])); ?>
                                </div>
                                <div class="small"><?php echo fetchAssoc(position($row['user']))['position']; ?></div>
                            </td>
                            <td class="align-middle"><?php echo stationName($row['to']); ?></td>
                            <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis(); ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                                        modalDropdownItem(uri() . '/modules/documents/save-document-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Document');

                                        if ($row['station'] === $station) {
                                            linkDropdownItem(customUri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);
                                            modalDropdownItem(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($row['id']), 'Cancel', 'fa-trash-alt', 'Cancel Document');
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
                        <th class="align-middle" width="25%">Description</th>
                        <th class="align-middle" width="20%">Forwarded by</th>
                        <th class="align-middle" width="20%">Forwarded to</th>
                        <th class="align-middle" width="15%">Forwarded on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>