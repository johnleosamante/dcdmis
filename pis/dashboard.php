<?php
// pis/page.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Personal Data Sheet', customUri('pis', 'Personal Data Sheet', $userId), 'fa-user-tie', 'primary');
  card('Service Record', customUri('pis', 'Service Record', $userId), 'fa-file-alt', 'success');
  card('201 Files', customUri('pis', '201 Files', $userId), 'fa-folder-open', 'info');
  card('Certificates', customUri('pis', 'Certificates', $userId), 'fa-certificate', 'warning');
  card('Trainings', customUri('pis', 'Trainings', $userId), 'fa-chalkboard-teacher', 'danger');
  ?>
</div>