<?php
// dmis/sidebar-menu.php
sidebarDivider();

$employeeCount = number_format(count(activeEmployees()));
$districtCount = number_format(count(districts()));
$schoolCount = number_format(count(schools()));
$sectionCount = number_format(count(sections()));
$userCount = number_format(count(users()));

sidebarMenuItem(customUri('dmis', 'Employees'), 'Employees', 'fa-users', isset($url) && str_contains($url, 'Employees'), $employeeCount);
sidebarMenuItem(customUri('dmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('dmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('dmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
sidebarMenuItem(customUri('dmis', 'Users'), 'Users', 'fa-user-friends', isset($url) && str_contains($url, 'Users'), $userCount);

sidebarDivider();

sidebarMenuItem(customUri('dmis', 'Transactions'), 'Transactions', 'fa-exchange-alt', isset($url) && str_contains($url, 'Transactions'));

sidebarMenuItem(customUri('dmis', 'System Logs'), 'System Logs', 'fa-file-alt', isset($url) && str_contains($url, 'System'));
