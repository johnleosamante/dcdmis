<?php
// dts/dashboard.php
contentTitleWithModal('Dashboard', uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus');
?>

<div class="row mt-4">
  <?php
  card('Incoming Documents', customUri('dts', 'Incoming Documents'), 'fa-file-download', 'primary', number_format(numRows(incomingDocuments($station))));

  card('Pending Documents', customUri('dts', 'Pending Documents'), 'fa-history', 'success', number_format(numRows(pendingDocuments($station))));

  card('Outgoing Documents', customUri('dts', 'Outgoing Documents'), 'fa-file-upload', 'info', number_format(numRows(outgoingDocuments($station))));

  card('Ongoing Documents', customUri('dts', 'Ongoing Documents'), 'fa-tasks', 'warning', number_format(numRows(ongoingDocuments($station))));

  card('Completed Documents', customUri('dts', 'Completed Documents'), 'fa-check-circle', 'secondary');

  if (!$isSchoolPortal) {
    card('Received Documents', customUri('dts', 'Received Documents'), 'fa-hand-holding-medical', 'dark');
  }

  card('Canceled Documents', customUri('dts', 'Canceled Documents'), 'fa-trash-alt', 'danger');
  ?>
</div>