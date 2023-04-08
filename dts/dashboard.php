<?php
// dts/dashboard.php
content_title('Dashboard', true, custom_uri('dts', 'New Document'), 'New Document', 'fa-plus');
?>

<div class="row mt-4">
  <?php
  card('Incoming Documents', custom_uri('dts', 'Incoming Documents'), 'fa-file-download', 'success', num_rows(incoming_documents($_SESSION[alias() . '_station'], $_SESSION[alias() . '_station_is_school'])));

  card('Pending Documents', custom_uri('dts', 'Pending Documents'), 'fa-history', 'info', num_rows(pending_documents($_SESSION[alias() . '_station'], $_SESSION[alias() . '_station_is_school'])));

  card('Outgoing Documents', custom_uri('dts', 'Outgoing Documents'),'fa-file-upload', 'warning', num_rows(outgoing_documents($_SESSION[alias() . '_station'], $_SESSION[alias() . '_station_is_school'])));

  card('Ongoing Documents', custom_uri('dts', 'Ongoing Documents'),'fa-tasks', 'danger', num_rows(ongoing_documents($_SESSION[alias() . '_station'], $_SESSION[alias() . '_station_is_school'])));

  card('Completed Documents', custom_uri('dts', 'Completed Documents'), 'fa-check-circle', 'secondary');

  card('Received Documents', custom_uri('dts', 'Received Documents'), 'fa-hand-holding-medical', 'primary');
  ?>
</div>