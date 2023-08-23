<?php
// modules/documents/completed-documents.php
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Completed Documents', uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="15%">Code</th>
            <th class="align-middle" width="50%">Description</th>
            <th class="align-middle" width="15%">Posted on</th>
            <th class="align-middle" width="15%">Completed on</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = completedDocuments($station);
          while ($row = fetchArray($query)) : ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']); ?></td>
              <td class="text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle"><?php echo toDatetime($row['postedon']); ?></td>
              <td class="align-middle"><?php echo toDatetime($row['completedon']); ?></td>
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
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="15%">Code</th>
            <th class="align-middle" width="50%">Description</th>
            <th class="align-middle" width="15%">Posted on</th>
            <th class="align-middle" width="15%">Completed on</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>