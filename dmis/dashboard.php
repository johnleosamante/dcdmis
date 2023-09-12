<?php
// dmis/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Districts', customUri('dmis', 'Districts'), 'fa-map-marked-alt', 'primary', $districtCount);
  card('Schools', customUri('dmis', 'Schools'), 'fa-school', 'success', $schoolCount);
  card('Sections', customUri('dmis', 'Sections'), 'fa-map-signs', 'info', $sectionCount);
  card('Users', customUri('dmis', 'Users'), 'fa-user-friends', 'warning', $userCount);
  card('Employees', customUri('dmis', 'Active Employees'), 'fa-users', 'danger', $employeeCount);
  ?>
</div>