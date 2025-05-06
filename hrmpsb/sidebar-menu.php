<?php
// hrmpsb/sidebar-menu.php
sidebarDivider();

$countActive = number_format(numRows(activeEmployees()));
$countRetirable = number_format(numRows(retirableEmployees()));
$countVacancy = number_format(numRows(vacancies()));
$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));

sidebarHeading('Employees');
sidebarMenuItem(customUri('hrmpsb', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);
sidebarMenuItem(customUri('hrmpsb', 'Retirable Employees'), 'Retirable', 'fa-user-clock', isset($url) && str_contains($url, 'Retirable'), $countRetirable);
sidebarDivider();
sidebarMenuItem(customUri('hrmpsb', 'Vacancies'), 'Vacancies', 'fa-users', isset($url) && str_contains($url, 'Vacancies'), $countVacancy);
sidebarDivider();
sidebarMenuItem(customUri('hrmpsb', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrmpsb', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
