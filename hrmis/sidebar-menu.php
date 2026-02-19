<?php
// hrmis/sidebar-menu.php
sidebarDivider();
sidebarHeading('Employees');

$countActive = number_format(count(activeEmployees()));
$countRetirable = number_format(count(retirableEmployees()));
$countStepIncrement = number_format(count(employeeStepIncrement()));
$countLoyaltyAward = number_format(count(employeeLoyaltyAward()));
$countVacancy = number_format(count(vacancies()));
$districtCount = number_format(count(districts()));
$schoolCount = number_format(count(schools()));
$sectionCount = number_format(count(sections()));

sidebarModalItem(uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-user-plus');
sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);
sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable', 'fa-user-clock', isset($url) && str_contains($url, 'Retirable'), $countRetirable);
sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrants', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));
sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-archive', isset($url) && str_contains($url, 'Archived'));
sidebarDivider();
sidebarMenuItem(customUri('hrmis', 'Step Increment'), 'Step', 'fa-plus', isset($url) && str_contains($url, 'Step'), $countStepIncrement);
sidebarMenuItem(customUri('hrmis', 'Loyalty Award'), 'Loyalty', 'fa-award', isset($url) && str_contains($url, 'Loyalty'), $countLoyaltyAward);
sidebarMenuItem(customUri('hrmis', 'Vacancies'), 'Vacancies', 'fa-users', isset($url) && str_contains($url, 'Vacancies'), $countVacancy);
sidebarDivider();
sidebarMenuItem(customUri('hrmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
