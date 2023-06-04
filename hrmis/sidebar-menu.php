<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarHeading('Employees');

sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), number_format(numRows(activeEmployees())));

sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable','fa-user-clock',isset($url) && str_contains($url, 'Retirable'), number_format(numRows(retirableEmployees())));

sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrant', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));

sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-user-lock', isset($url) && str_contains($url, 'Archived'));
?>