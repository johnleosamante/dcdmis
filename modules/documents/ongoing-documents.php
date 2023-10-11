<?php
// modules/documents/ongoing-documents.php
messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center flex-row-reverse mt-2 mb-3">
  <div class="d-inline-block">
    <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus'); ?>
  </div>
</div>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Ongoing Documents', uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="15%">Code</th>
            <th class="align-middle" width="50%">Description</th>
            <th class="align-middle" width="15%">Posted on</th>
            <th class="align-middle" width="15%">Status</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = ongoingDocuments($station);
          while ($row = fetchArray($query)) {
          ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']); ?></td>
              <td class="text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
              <td class="align-middle"><?php echo $row['status']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                    if ($row['station'] === $station) {
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
            <th class="align-middle" width="50%">Description</th>
            <th class="align-middle" width="15%">Posted on</th>
            <th class="align-middle" width="15%">Status</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>