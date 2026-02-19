<?php
// hrmpsb/sidebar-menu.php
sidebarDivider();

$countActive = number_format(numRows(activeEmployees()));
$countRetirable = number_format(numRows(retirableEmployees()));
$countOpenVacancies = number_format(countVacanciesByStatus('open'));
$countVacantItems = number_format(numRows(vacantItems()));
$countPublications = number_format(countPublications());
$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));

sidebarHeading('Employees');
sidebarMenuItem(customUri('hrmpsb', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);
sidebarMenuItem(customUri('hrmpsb', 'Retirable Employees'), 'Retirable', 'fa-user-clock', isset($url) && str_contains($url, 'Retirable'), $countRetirable);

sidebarDivider();
sidebarHeading('Vacancy Management');
sidebarMenuItem(customUri('hrmpsb', 'Vacancies'), 'Open Vacancies', 'fa-door-open', isset($url) && $url === 'Vacancies', $countOpenVacancies);
sidebarMenuItem(customUri('hrmpsb', 'Publications'), 'Publications', 'fa-newspaper', isset($url) && str_contains($url, 'Publications'), $countPublications);

sidebarDivider();
sidebarHeading('Organizational Units');
sidebarMenuItem(customUri('hrmpsb', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrmpsb', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrmpsb', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
