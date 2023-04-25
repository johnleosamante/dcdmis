<?php
// dts/dashboard.php
content_title('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Active Employees', custom_uri('hrmis', 'Active Employees'), 'fa-user-check', 'primary', number_format(num_rows(active_employees())));

  card('Retirable Employees', custom_uri('hrmis', 'Retirable Employees'), 'fa-user-clock', 'success', number_format(num_rows(retirable_employees())));

  card('Archived Employees', custom_uri('hrmis', 'Archived Employees'), 'fa-user-lock', 'danger');
  ?>
</div>