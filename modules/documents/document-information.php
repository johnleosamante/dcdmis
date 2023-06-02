<?php
// modules/documents/document-information.php
$document_id = isset($_GET['id']) ? sanitize($_GET['id']) : null;
$documents = document_from($document_id, $station);

if (num_rows($documents) > 0) {
  $document = fetch_assoc($documents);
  $document_id = $document['id'];

  if (is_incoming_document($document_id, $station)) {
    $document_type = 'Incoming Documents';
  } elseif (is_pending_document($document_id, $station)) {
    $document_type = 'Pending Documents';
  } elseif (is_outgoing_document($document_id, $station)) {
    $document_type = 'Outgoing Documents';
  } elseif (is_ongoing_document($document_id, $station)) {
    $document_type = 'Ongoing Documents';
  } elseif (is_completed_document($document_id, $station)) {
    $document_type = 'Completed Documents';
  } elseif (is_received_document($document_id, $station)) {
    $document_type = 'Received Documents';
  } elseif (is_canceled_document($document_id, $station)) {
    $document_type = 'Canceled Documents';
  } else {
    $document_type = null;
  }
} else {
  include_once(root() . '/modules/error/no-results-found.php');
  return;
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title("Document Information : " . strtoupper($document_id)); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table cellspacing="0">
        <tr>
          <th class="align-top pr-5" scope="row">Description:</th>
          <td class="text-uppercase"><?php echo $document['description']; ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">Created on:</th>
          <td class="text-uppercase"><?php echo to_date($document['datetime'], 'F d, Y h:i:s A'); ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">From:</th>
          <td class="text-uppercase"><?php echo station_name($document['from']); ?></td>
        </tr>
        <tr>
          <th class="align-top pr-5" scope="row">Status:</th>
          <td class="text-uppercase">
            <?php
            echo strlen($document['details']) === 0 ? $document['status'] : $document['status'] . ' - ' . $document['details'];
            ?>
          </td>
        </tr>
      </table>
    </div>

    <div class="d-sm-flex align-items-center flex-row-reverse my-2">
      <div class="d-inline-block">
        <?php
        if ($station === $document['from']) {
          link_button_split(custom_uri('print', 'Document Tracking Slip', $document_id), 'Print', 'fa-print', 'Print Document Tracking Slip', 'primary', true);
        }

        switch ($document_type) {
          case 'Incoming Documents':
            if (!is_document($document_id, 'Cancel')) {
              modal_button_split(uri() . '/modules/documents/receive-document-dialog.php?id=' . cipher($document_id), 'Receive', 'fa-hand-holding-medical','Receive Document', 'success');
            }
            break;
          case 'Pending Documents':
            if ($portal !== 'school_portal') {
              modal_button_split(uri() . '/modules/documents/forward-document-dialog.php?id=' . cipher($document_id), 'Forward', 'fa-share', 'Forward Document', 'info');
            }
            modal_button_split(uri() .'/modules/documents/complete-document-dialog.php?id=' . cipher($document_id), 'Mark Completed', 'fa-check-circle', 'Mark Complete Document', 'success');
            break;
          case 'Outgoing Documents':
            if (!is_document($document_id, 'Complete') && !is_document($document_id, 'Cancel')) {
              modal_button_split(uri() .'/modules/documents/save-document-dialog.php?id=' . cipher($document_id), 'Edit', 'fa-edit','Edit Document', 'info');
            }
            break;
          default:
            break;
        }

        switch ($document_type) {
          case 'Pending Documents':
            if ($portal === 'school_portal') {
              break;
            }
            
            if (is_document_from($document_id, $station) && $document['from'] === $station && !is_document($document_id, 'Cancel')) {
              modal_button_split(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($document_id), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
            }
            break;
          case 'Outgoing Documents':
            if (is_document_from($document_id, $station) && $document['from'] === $station && !is_document($document_id, 'Cancel')) {
              modal_button_split(uri() .'/modules/documents/cancel-document-dialog.php?id=' . cipher($document_id), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
            }
            break;
          default:
            break;
        }
        ?>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered mb-0 text-center" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="15%">Date &amp; Time</th>
            <th class="align-middle" width="20%">Processed by</th>
            <th class="align-middle" width="25%">From</th>
            <th class="align-middle" width="25%">To</th>
            <th class="align-middle" width="15%">Status</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $logs = document_logs($document_id);
          while ($log = fetch_array($logs)) {
          ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo to_datetime($log['datetime']); ?></td>
              <td class="align-middle"><?php echo user_name($log['user']); ?></td>
              <td class="align-middle"><?php echo station_name($log['from']); ?></td>
              <td class="align-middle"><?php echo station_name($log['to']); ?></td>
              <td class="align-middle">
                <?php
                  $status = $log['status'];
                  $details = $log['details'];

                  if (strlen($details) > 0) {
                    echo $status . ' - ' . $details;
                  } else {
                    echo $status;
                  }
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>