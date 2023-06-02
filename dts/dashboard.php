<?php
// dts/dashboard.php
messagePrompt($showPrompt, $message, $success);

contentTitleWithModal('Dashboard', uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus');
?>

<div class="row mt-4">
  <?php
  $is_school_portal = $portal === 'school_portal';

  card('Incoming Documents', customUri('dts', 'Incoming Documents'), 'fa-file-download', 'primary', numRows(incomingDocuments($station)));

  card('Pending Documents', customUri('dts', 'Pending Documents'), 'fa-history', 'success', numRows(pendingDocuments($station)));

  card('Outgoing Documents', customUri('dts', 'Outgoing Documents'), 'fa-file-upload', 'info', numRows(outgoingDocuments($station)));

  card('Ongoing Documents', customUri('dts', 'Ongoing Documents'), 'fa-tasks', 'warning', numRows(ongoingDocuments($station)));

  card('Completed Documents', customUri('dts', 'Completed Documents'), 'fa-check-circle', 'secondary');

  if (!$is_school_portal) {
    card('Received Documents', customUri('dts', 'Received Documents'), 'fa-hand-holding-medical', 'dark');
  }

  card('Canceled Documents', customUri('dts', 'Canceled Documents'), 'fa-trash-alt', 'danger');
  ?>
</div>