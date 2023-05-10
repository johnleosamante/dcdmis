<?php
// hrmis/sidebar-menu.php
?>

<hr class="sidebar-divider d-none d-md-block my-0">

<div class="sidebar-heading mt-3">Employees</div>

<?php
sidebar_menu_item(isset($url) && str_contains($url, 'Active'), custom_uri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', number_format(num_rows(active_employees())));

sidebar_menu_item(isset($url) && str_contains($url, 'Retirable'), custom_uri('hrmis', 'Retirable Employees'), 'Retirable','fa-user-clock', number_format(num_rows(retirable_employees())));

sidebar_menu_item(isset($url) && str_contains($url, 'Celebrant'), custom_uri('hrmis', 'Celebrant Employees'), 'Celebrant', 'fa-birthday-cake');

sidebar_menu_item(isset($url) && str_contains($url, 'Archived'), custom_uri('hrmis', 'Archived Employees'), 'Archived', 'fa-user-lock');
?>