<?php
// modules/documents/document-information.php
$documentId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = documentFrom($documentId, $station);
$documentType = null;

if (numRows($documents) > 0) {
  $document = fetchAssoc($documents);
  $documentId = $document['id'];

  if (isIncomingDocument($documentId, $station)) {
    $documentType = 'Incoming Documents';
  } elseif (isPendingDocument($documentId, $station)) {
    $documentType = 'Pending Documents';
  } elseif (isOutgoingDocument($documentId, $station)) {
    $documentType = 'Outgoing Documents';
  } elseif (isOngoingDocument($documentId, $station)) {
    $documentType = 'Ongoing Documents';
  } elseif (isCompletedDocument($documentId, $station)) {
    $documentType = 'Completed Documents';
  } elseif (isReceivedDocument($documentId, $station)) {
    $documentType = 'Received Documents';
  } elseif (isCanceledDocument($documentId, $station)) {
    $documentType = 'Canceled Documents';
  } else {
    $documentType = null;
  }
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

messageAlert($showPrompt, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle("Document Information : " . strtoupper($documentId)); ?>
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
          <td class="text-uppercase"><?php echo toDate($document['datetime'], 'F d, Y h:i:s A'); ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">From:</th>
          <td class="text-uppercase"><?php echo stationName($document['from']); ?></td>
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
          linkButtonSplit(customUri('print', 'Document Tracking Slip', $documentId), 'Print', 'fa-print', 'Print Document Tracking Slip', 'primary', true);
        }

        switch ($documentType) {
          case 'Incoming Documents':
            if (!isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() . '/modules/documents/receive-document-dialog.php?id=' . cipher($documentId), 'Receive', 'fa-hand-holding-medical','Receive Document', 'success');
            }
            break;
          case 'Pending Documents':
            if (!$isSchoolPortal) {
              modalButtonSplit(uri() . '/modules/documents/forward-document-dialog.php?id=' . cipher($documentId), 'Forward', 'fa-share', 'Forward Document', 'info');
            }
            modalButtonSplit(uri() .'/modules/documents/complete-document-dialog.php?id=' . cipher($documentId), 'Mark Completed', 'fa-check-circle', 'Mark Complete Document', 'success');
            break;
          case 'Outgoing Documents':
            if (!isDocument($documentId, 'Complete') && !isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() .'/modules/documents/save-document-dialog.php?id=' . cipher($documentId), 'Edit', 'fa-edit','Edit Document', 'info');
            }
            break;
          default:
            break;
        }

        switch ($documentType) {
          case 'Pending Documents':
            if ($isSchoolPortal) {
              break;
            }
            
            if (isDocumentFrom($documentId, $station) && $document['from'] === $station && !isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($documentId), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
            }
            break;
          case 'Outgoing Documents':
            if (isDocumentFrom($documentId, $station) && $document['from'] === $station && !isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() .'/modules/documents/cancel-document-dialog.php?id=' . cipher($documentId), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
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
          $logs = documentLogs($documentId);
          while ($log = fetchArray($logs)) {
          ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo toDatetime($log['datetime']); ?></td>
              <td class="align-middle"><?php echo userName($log['user']); ?></td>
              <td class="align-middle"><?php echo stationName($log['from']); ?></td>
              <td class="align-middle"><?php echo stationName($log['to']); ?></td>
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