<?php
// modules/documents/completed-documents.php
$_SESSION[alias() . '_previous_document'] = $page_title = 'Canceled Documents';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title_with_link($page_title, uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">#</th>
            <th class="align-middle" width="10%">Code</th>
            <th class="align-middle" width="50%">Description</th>
            <th class="align-middle" width="15%">Posted on</th>
            <th class="align-middle" width="15%">Canceled on</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 0;
          $query = canceled_documents($_SESSION[alias() . '_station']);
          while ($row = fetch_array($query)) : ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo ++$no; ?></td>
              <td class="align-middle"><?php echo $row['id']; ?></td>
              <td class="text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle"><?php echo to_datetime($row['postedon']); ?></td>
              <td class="align-middle"><?php echo to_datetime($row['canceledon']); ?></td>
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
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>