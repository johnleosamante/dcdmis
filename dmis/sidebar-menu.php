<?php
// dmis/sidebar-menu.php
sidebarDivider();

$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));
$userCount = number_format(numRows(users()));
$employeeCount = number_format(numRows(activeEmployees()));

sidebarMenuItem(customUri('dmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'Districts'), $districtCount);

sidebarMenuItem(customUri('dmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);

sidebarMenuItem(customUri('dmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Sections'), $sectionCount);

sidebarMenuItem(customUri('dmis', 'Users'), 'Users', 'fa-user-friends', isset($url) && str_contains($url, 'Users'), $userCount);

sidebarMenuItem(customUri('dmis', 'Active Employees'), 'Employees', 'fa-users', isset($url) && str_contains($url, 'Employees'), $employeeCount);
?>