<?php
messageAlert($showAlert, $message, $success);

contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Districts', customUri('dmis', 'Districts'), 'fa-map-marked-alt', 'primary', number_format(numRows(districts())));

  card('Schools', customUri('dmis', 'Schools'), 'fa-school', 'success', number_format(numRows(schools())));

  card('Sections', customUri('dmis', 'Sections'), 'fa-map-signs', 'info', number_format(numRows(sections())));

  card('Users', customUri('dmis', 'Users'), 'fa-users', 'warning', number_format(numRows(users())));
  ?>
</div>