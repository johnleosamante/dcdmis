<?php
// modules/documents/pending-documents.php
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Pending Documents', uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">#</th>
            <th class="align-middle" width="10%">Code</th>
            <th class="align-middle" width="45%">Description</th>
            <th class="align-middle" width="20%">Received by</th>
            <th class="align-middle" width="15%">Received on</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 0;
          $query = pendingDocuments($station);
          while ($row = fetchArray($query)) {
          ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo ++$no; ?></td>
              <td class="align-middle"><?php echo $row['id']; ?></td>
              <td class="text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle"><?php echo userName($row['user']); ?></td>
              <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
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
      </table>
    </div>
  </div>
</div>