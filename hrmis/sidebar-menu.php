<?php
// hrmis/sidebar-menu.php
sidebarDivider();
sidebarHeading('Employees');

$countActive = number_format(countActiveEmployees());
$countRetirable = number_format(countRetirableEmployees());
$countVacancy = number_format(countVacantItems());
$countPublications = number_format(countPublications());
$districtCount = number_format(countDistricts());
$schoolCount = number_format(countSchools());
$sectionCount = number_format(countSections());
$countPendingTransfers = number_format(countPendingTransferRequests());

sidebarModalItem(uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-user-plus');
sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);
sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable', 'fa-user-clock', isset($url) && str_contains($url, 'Retirable'), $countRetirable);
sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrants', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));
sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-archive', isset($url) && str_contains($url, 'Archived'));
if ($isHrmis && ($isPersonnel || $isICT)) {
    sidebarDivider();
    sidebarMenuItem(customUri('hrmis', 'Transfer Requests'), 'Transfer Requests', 'fa-exchange-alt', isset($url) && str_contains($url, 'Transfer'), $countPendingTransfers);
    sidebarDivider();
    sidebarHeading('Diversity');
    sidebarMenuItem(customUri('hrmis', 'Workforce Diversity - Gender'), 'Workforce', 'fa-chart-pie', isset($url) && str_contains($url, 'Workforce Diversity'));
    sidebarMenuItem(customUri('hrmis', 'Talent Pool Diversity - Gender'), 'Talent Pool', 'fa-chart-bar', isset($url) && str_contains($url, 'Talent Pool'));
}
sidebarDivider();
if ($isHrmis && ($isPersonnel || $isICT)) {
    sidebarMenuItem(customUri('hrmis', 'Positions'), 'Positions', 'fa-user-tie', isset($url) && str_contains($url, 'Positions'));
    sidebarMenuItem(customUri('hrmis', 'Plantilla Items'), 'Plantilla Items', 'fa-list', isset($url) && str_contains($url, 'Plantilla Items'));
    sidebarDivider();
    sidebarMenuItem(customUri('hrmis', 'Vacancies'), 'Vacancies', 'fa-user-times', isset($url) && str_contains($url, 'Vacancies'), $countVacancy);
}
sidebarMenuItem(customUri('hrmis', 'Call for Applications'), 'Call for Applications', 'fa-bullhorn', isset($url) && str_contains($url, 'Call for Applications'), $countPublications);
sidebarDivider();
sidebarMenuItem(customUri('hrmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
