<?php
// pis/page.php
messageAlert($showAlert, $message, $success);

contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Personal Data Sheet', customUri('pis', 'Personal Data Sheet', $userId), 'fa-user', 'primary');

  card('Service Record', customUri('pis', 'Service Record'), 'fa-file-alt', 'success');

  card('201 File', customUri('pis', '201 File'), 'fa-book-open', 'info');

  card('IPCRF', customUri('pis', 'IPCRF'), 'fa-tasks', 'warning');

  card('Certificates', customUri('pis', 'Certificates'), 'fa-certificate', 'danger');

  card('Trainings', customUri('pis', 'Trainings'), 'fa-chalkboard-teacher', 'secondary');

  card('Payslip', customUri('pis', 'Payslip'), 'fa-money-check', 'primary');

  card('DepEd Account Request', customUri('pis', 'DepEd Account Request'), 'fa-edit', 'success');

  card('Transfer Request', customUri('pis', 'Transfer Request'), 'fa-map', 'info');
  ?>
</div><!-- .row -->