<?php
// modules/documents/document-information.php
$documents = document_from(real_escape_string($_GET['id']), $_SESSION[alias() . '_station']);

if (num_rows($documents) > 0) {
  $document = fetch_assoc($documents);
  $_SESSION[alias() . '_No'] = $document['id'];

  if (is_incoming_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Incoming Documents';
  } elseif (is_pending_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Pending Documents';
  } elseif (is_outgoing_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Outgoing Documents';
  } elseif (is_ongoing_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Ongoing Documents';
  } elseif (is_completed_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Completed Documents';
  } elseif (is_received_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Received Documents';
  } elseif (is_canceled_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Canceled Documents';
  } else {
    $previous_document = null;
  }
} else {
  include_once(root() . '/modules/error/no-results-found.php');
  return;
}

$back_link = isset($previous_document) ? custom_uri('dts', $previous_document) : uri() . '/dts';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title_with_link("Document Information : " . strtoupper($document['id']), $back_link); ?>
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
          <td class="text-uppercase"><?php echo to_date($document['datetime'], '', 'F d, Y h:i:s A'); ?></td>
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
        if (($_SESSION[alias() . '_station']) === $document['from']) {
          link_button_split(custom_uri('print', 'Document Tracking Slip', $document['id']), 'Print', 'fa-print', 'primary', 'Print Document Tracking Slip', true);
        }

        switch ($previous_document) {
          case 'Incoming Documents':
            if (!is_document($document['id'], 'Cancel')) {
              modal_button_split('Modal', 'receive_document', 'Receive', 'fa-hand-holding-medical', 'success', 'Receive Document');
            }
            break;
          case 'Pending Documents':
            modal_button_split('Modal', 'forward_document', 'Forward', 'fa-share', 'info', 'Forward Document');
            modal_button_split('Modal', 'complete_document', 'Mark Completed', 'fa-check-circle', 'success', 'Mark Complete Document');
            if (is_document_from($document['id'], $_SESSION[alias() . '_station']) && $document['from'] === $_SESSION[alias() . '_station'] && !is_document($document['id'], 'Cancel')) {
              modal_button_split('Modal', 'cancel_document', 'Cancel', 'fa-trash-alt', 'danger', 'Cancel Document');
            }
            break;
          case 'Outgoing Documents':
            if (!is_document($document['id'], 'Complete') && !is_document($document['id'], 'Cancel')) {
              modal_button_split('Modal', 'save_document', 'Edit', 'fa-edit', 'info', 'Edit Document');
            }
            if (is_document_from($document['id'], $_SESSION[alias() . '_station']) && $document['from'] === $_SESSION[alias() . '_station'] && !is_document($document['id'], 'Cancel')) {
              modal_button_split('Modal', 'cancel_document', 'Cancel', 'fa-trash-alt', 'danger', 'Cancel Document');
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
          $logs = document_logs($_GET['id']);
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