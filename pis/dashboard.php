<?php
// pis/page.php
messageAlert($showAlert, $message, $success);

contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Personal Data Sheet', customUri('pis', 'Personal Data Sheet', $userId), 'fa-user', 'primary');

  card('Service Record', customUri('pis', 'Service Record', $userId), 'fa-file-alt', 'success');

  card('201 File', customUri('pis', '201 File', $userId), 'fa-folder-open', 'info');

  card('IPCRF', customUri('pis', 'IPCRF', $userId), 'fa-tasks', 'warning');

  card('Certificates', customUri('pis', 'Certificates', $userId), 'fa-certificate', 'danger');

  card('Trainings', customUri('pis', 'Trainings', $userId), 'fa-chalkboard-teacher', 'secondary');

  card('Payslip', customUri('pis', 'Payslip', $userId), 'fa-money-check', 'primary');

  card('DepEd Account Request', customUri('pis', 'DepEd Account Request', $userId), 'fa-edit', 'success');

  card('Transfer Request', customUri('pis', 'Transfer Request', $userId), 'fa-map', 'info');
  ?>
</div><!-- .row -->