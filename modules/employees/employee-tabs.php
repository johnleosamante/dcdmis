<?php
// modules/employees/employee-tabs.php
?>

<div class="row">
  <?php
  cardMini('Personal Data Sheet', customUri('hrmis', 'Personal Data Sheet', $employeeId), 'fa-user-tie', 'primary');
  cardMini('Service Record', customUri('hrmis', 'Service Record', $employeeId), 'fa-file-alt', 'success');
  cardMini('201 Files', customUri('hrmis', '201 Files', $employeeId), 'fa-folder-open', 'info');
  cardMini('Certificates', customUri('hrmis', 'Certificates', $employeeId), 'fa-certificate', 'warning');
  cardMini('Trainings', customUri('hrmis', 'Trainings', $employeeId), 'fa-chalkboard-teacher', 'danger');
  cardMini('PSIPOP', customUri('hrmis', 'PSIPOP', $employeeId), 'fa-file-contract', 'secondary');
  ?>
</div>