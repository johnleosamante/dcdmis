<?php
// modules/documents/completed-documents.php
$_SESSION[alias() . '_previous_document'] = $page_title = 'Canceled Documents';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title($page_title, true, uri() . '/dts'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered mb-0 text-center" id="dataTable" width="100%" cellspacing="0">
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
          $query = canceled_documents($_SESSION[alias() . '_station'], $_SESSION[alias() . '_station_is_school']);
          while ($row = fetch_array($query)) : ?>
            <tr>
              <td class="text-uppercase align-middle"><?php echo ++$no; ?></td>
              <td class="text-uppercase align-middle"><?php echo $row['id']; ?></td>
              <td class="text-uppercase text-left align-middle"><?php echo $row['description']; ?></td>
              <td class="align-middle"><?php echo $row['postedon']; ?></td>
              <td class="align-middle"><?php echo $row['canceledon']; ?></td>
              <td class="align-middle">
                <?php
                link_button_icon(custom_uri('/dts', 'Document Information', $row['id']), 'fa-eye', 'success', 'View Document Information');

                if ($row['station'] === $_SESSION[alias() . '_station']) {
                  link_button_icon('#', 'fa-print', 'primary', 'Print Document Tracking Slip', true);
                }
                ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>