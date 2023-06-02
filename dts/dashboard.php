<?php
// dts/dashboard.php
content_title_with_modal('Dashboard', uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus');
?>

<div class="row mt-4">
  <?php
  $is_school_portal = $portal === 'school_portal';

  card('Incoming Documents', custom_uri('dts', 'Incoming Documents'), 'fa-file-download', 'primary', num_rows(incoming_documents($station)));

  if (!$is_school_portal) {
    card('Pending Documents', custom_uri('dts', 'Pending Documents'), 'fa-history', 'success', num_rows(pending_documents($station)));
  }

  card('Outgoing Documents', custom_uri('dts', 'Outgoing Documents'), 'fa-file-upload', $is_school_portal ? 'success' : 'info', num_rows(outgoing_documents($station)));

  card('Ongoing Documents', custom_uri('dts', 'Ongoing Documents'), 'fa-tasks', $is_school_portal ? 'info' : 'warning', num_rows(ongoing_documents($station)));

  card('Completed Documents', custom_uri('dts', 'Completed Documents'), 'fa-check-circle', $is_school_portal ? 'warning' :'secondary');

  if (!$is_school_portal) {
    card('Received Documents', custom_uri('dts', 'Received Documents'), 'fa-hand-holding-medical', 'dark');
  }

  card('Canceled Documents', custom_uri('dts', 'Canceled Documents'), 'fa-trash-alt', 'danger');
  ?>
</div>