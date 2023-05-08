<?php
// modules/documents/incoming-documents.php
$_SESSION[alias() . '_previous_document'] = $page_title = 'Incoming Documents';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title_with_link($page_title, uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered mb-0 text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">#</th>
            <th class="align-middle" width="10%">Code</th>
            <th class="align-middle" width="30%">Description</th>
            <th class="align-middle" width="20%">From</th>
            <th class="align-middle" width="15%">Date</th>
            <th class="align-middle" width="15%">Purpose</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 0;
          $query = incoming_documents($_SESSION[alias() . '_station']);
          while ($row = fetch_array($query)) {
          ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo ++$no; ?></td>
              <td class="align-middle"><?php echo $row['id']; ?></td>
              <td class="text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle text-uppercase">
                <?php echo station_name($row['from']); ?>
              </td>
              <td class="align-middle"><?php echo to_datetime($row['datetime']); ?></td>
              <td class="align-middle"><?php echo $row['purpose']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdown_ellipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php link_dropdown_item(custom_uri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                    if ($row['station'] === $_SESSION[alias() . '_station']) {
                      link_dropdown_item(custom_uri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);
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