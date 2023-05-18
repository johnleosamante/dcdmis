<?php
// hrmis/sidebar-menu.php
?>

<hr class="sidebar-divider d-none d-md-block my-0">

<div class="sidebar-heading mt-3">Employees</div>

<?php
sidebar_menu_item(custom_uri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), number_format(num_rows(active_employees())));

sidebar_menu_item(custom_uri('hrmis', 'Retirable Employees'), 'Retirable','fa-user-clock',isset($url) && str_contains($url, 'Retirable'), number_format(num_rows(retirable_employees())));

sidebar_menu_item(custom_uri('hrmis', 'Celebrant Employees'), 'Celebrant', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));

sidebar_menu_item(custom_uri('hrmis', 'Archived Employees'), 'Archived', 'fa-user-lock', isset($url) && str_contains($url, 'Archived'));
?>