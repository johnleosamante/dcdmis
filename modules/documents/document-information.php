<?php
// modules/documents/document-information.php
$previous_document = $_SESSION[alias() . '_previous_document'];
$back_link = isset($previous_document) ? custom_uri('dts', $previous_document) : uri() . '/dts';
$documents = document(real_escape_string($_GET['id']));

if (num_rows($documents) > 0) {
  $document = fetch_assoc($documents);
  $_SESSION[alias() . '_No'] = $document['id'];

  if (is_incoming_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Incoming Documents';
  }

  if (is_pending_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Pending Documents';
  }

  if (is_outgoing_document($_SESSION[alias() . '_No'], $_SESSION[alias() . '_station'])) {
    $_SESSION[alias() . '_previous_document'] = $previous_document = 'Outgoing Documents';
  }
} else {
  include_once(root() . '/modules/error/not-found.php');
  return;
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title("{$previous_document} : " . strtoupper($document['id']), true, $back_link); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table cellspacing="0">
        <tr>
          <th class="pr-5" scope="row">Code:</th>
          <td class="text-uppercase"><?php echo $document['id']; ?></td>
        </tr>
        <tr>
          <th class="align-top pr-5" scope="row">Description:</th>
          <td class="text-uppercase"><?php echo $document['description']; ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">Created on:</th>
          <td><?php echo $document['datetime']; ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">From:</th>
          <td class="text-uppercase"><?php echo station_name($document['from']); ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">Status:</th>
          <td class="text-uppercase">
            <?php echo $document['status']; ?>
          </td>
        </tr>
      </table>
    </div>

    <div class="d-sm-flex align-items-center flex-row-reverse my-2">
      <div class="d-inline-block">
        <?php
        link_button_split('#', 'Print', 'fa-print', 'primary', 'Print Document Information', true);

        switch ($previous_document) {
          case 'Incoming Documents':
            if (!is_document($document['id'], 'Cancel')) {
              modal_button_split('Modal', 'receive_document', 'Receive', 'fa-hand-holding-medical', 'success', 'Receive Document');
            }
            break;
          case 'Pending Documents':
            modal_button_split('Modal', 'forward_document', 'Forward', 'fa-share', 'info', 'Forward Document');
            modal_button_split('Modal', 'complete_document', 'Mark Completed', 'fa-check-circle', 'success', 'Mark Complete Document');
            break;
          case 'Outgoing Documents':
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
            <tr>
              <td class="align-middle"><?php echo $log['datetime']; ?></td>
              <td class="align-middle text-uppercase"><?php echo user_name($log['user']); ?></td>
              <td class="align-middle text-uppercase"><?php echo station_name($log['from']); ?></td>
              <td class="align-middle text-uppercase"><?php echo station_name($log['to']); ?></td>
              <td class="align-middle text-uppercase"><?php echo $log['status']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>