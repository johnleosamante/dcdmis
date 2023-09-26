<?php
// modules/documents/document-information.php
$documentId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = $isSchoolPortal ? documentFrom($documentId, $station) : document($documentId);
$documentType = null;

messageAlert($showAlert, $message, $success);

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
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle("Document Information: " . strtoupper($documentId)); ?>
  </div>

  <div class="card-body">
    <table cellspacing="0">
      <tr>
        <th class="align-top pr-3" scope="row">Description:</th>
        <td class="text-uppercase"><?php echo $document['description']; ?></td>
      </tr>
      <tr>
        <th class="align-top pr-3" scope="row">Created on:</th>
        <td class="text-uppercase"><?php echo toDate($document['datetime'], 'F d, Y h:i:s A'); ?></td>
      </tr>
      <tr>
        <th class="align-top pr-3" scope="row">From:</th>
        <td class="text-uppercase"><?php echo stationName($document['from']); ?></td>
      </tr>
      <tr>
        <th class="align-top pr-3" scope="row">Status:</th>
        <td class="text-uppercase">
          <?php
          echo strlen($document['details']) === 0 ? $document['status'] : $document['status'] . ' - ' . $document['details'];
          ?>
        </td>
      </tr>
    </table>

    <div class="d-flex align-items-center flex-row-reverse mt-2 mb-3">
      <div class="d-inline-block">
        <?php
        if ($station === $document['from']) {
          linkButtonSplit(customUri('print', 'Document Tracking Slip', $documentId), 'Print', 'fa-print', 'Print Document Tracking Slip', 'primary', true);
        }

        switch ($documentType) {
          case 'Incoming Documents':
            if (!isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() . '/modules/documents/receive-document-dialog.php?id=' . cipher($documentId), 'Receive', 'fa-hand-holding-medical', 'Receive Document', 'success');
            }
            break;
          case 'Pending Documents':
            if (!$isSchoolPortal) {
              modalButtonSplit(uri() . '/modules/documents/forward-document-dialog.php?id=' . cipher($documentId), 'Forward', 'fa-share', 'Forward Document', 'info');
            }
            modalButtonSplit(uri() . '/modules/documents/complete-document-dialog.php?id=' . cipher($documentId), 'Mark Completed', 'fa-check-circle', 'Mark Complete Document', 'success');
            break;
          case 'Outgoing Documents':
            if (!isDocument($documentId, 'Complete') && !isDocument($documentId, 'Cancel')) {
              modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php?id=' . cipher($documentId), 'Edit', 'fa-edit', 'Edit Document', 'info');
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
              modalButtonSplit(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($documentId), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
            }
            break;
          default:
            break;
        }
        ?>
      </div>
    </div>

    <div class="timeline">
      <?php
      $logs = documentLogs($documentId);
      $totalLogs = numRows($logs);
      $logCount = 0;

      while ($log = fetchAssoc($logs)) {
        $logCount++;
        $from = stationName($log['from']);
        $to = stationName($log['to']);
        $icon = 'flag';
        $hasDestination = !empty($to) && $to !== '-';
        $status = $log['status'];
        $details = $log['details'];
        $isCompleted = str_contains(strtolower($status), 'complete');
        $isCanceled = str_contains(strtolower($status), 'cancel');
        $bgColor = '';

        if ($logCount === 1) {
          $bgColor = 'bg-success';
        }

        if ($logCount === 1 && $hasDestination) {
          $icon = 'truck';
        }

        if ($logCount > 1 && $hasDestination) {
          $icon = 'flag';
        }

        if ($logCount >= 1  && !$hasDestination) {
          $icon = 'check';
        }

        if ($logCount === 1 && $isCompleted) {
          $icon = 'trophy';
        }

        if ($logCount === 1 && $isCanceled) {
          $icon = 'times';
          $bgColor = 'bg-danger';
        }
      ?>
        <div class="timeline-item">
          <div class="timeline-item-marker">
            <div class="timeline-item-marker-text text-uppercase">
              <?php echo date('M d, Y', strtotime($log['datetime'])) . '<br>' . date('h:i:s A', strtotime($log['datetime']));?>
            </div>
            <div class="timeline-item-marker-indicator <?php echo $bgColor; ?>">
              <i class="fas fa-<?php echo $icon; ?>"></i>
            </div>
          </div>
          <div class="timeline-item-content pt-0">
            <div class="card">
              <div class="card-body p-3">
                <h5 class="timeline-item-content-header-text font-weight-bold text-uppercase">
                  <?php echo $from; ?>
                </h5>
                <?php echo $hasDestination ? '<div>Forwarded to ' . strtoupper($to) . '</div>' : ''; ?>
                <div><?php echo $status; ?></div>
                <?php echo !empty($details) ? '<div>' . $details . '</div>' : ''; ?>
                <div class="text-uppercase"><?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($log['user']), userName($log['user'])); ?></div>
                <div class="text-uppercase small"><?php echo fetchAssoc(position($log['user']))['position']; ?></div> 
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>