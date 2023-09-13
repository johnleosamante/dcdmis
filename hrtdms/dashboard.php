<?php
// hrtdms/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
?>

<div class="row mt-4">
  <?php
  card('Scheduled Trainings', customUri('hrtdms', 'Scheduled Trainings'), 'fa-calendar-alt', 'primary', $countScheduled);
  card('Conducted Trainings', customUri('hrtdms', 'Conducted Trainings'), 'fa-chalkboard-teacher', 'success');
  ?>
</div>