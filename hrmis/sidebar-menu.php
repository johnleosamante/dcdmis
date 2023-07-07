<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarHeading('Employees');

$countActive = number_format(numRows(activeEmployees()));
$countRetirable = number_format(numRows(retirableEmployees()));
$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));

sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);

sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable','fa-user-clock',isset($url) && str_contains($url, 'Retirable'), $countRetirable);

sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrant', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));

sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-user-lock', isset($url) && str_contains($url, 'Archived'));

sidebarDivider();

sidebarMenuItem(customUri('dmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'Districts'), $districtCount);

sidebarMenuItem(customUri('dmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);

sidebarMenuItem(customUri('dmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Sections'), $sectionCount);
?>