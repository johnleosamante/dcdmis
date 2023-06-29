<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarHeading('Employees');

$countActive = number_format(numRows(activeEmployees()));
$countRetirable = number_format(numRows(retirableEmployees()));

sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);

sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable','fa-user-clock',isset($url) && str_contains($url, 'Retirable'), $countRetirable);

sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrant', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));

sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-user-lock', isset($url) && str_contains($url, 'Archived'));
?>