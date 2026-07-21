<?php
// hrtdms/sidebar-menu.php
sidebarDivider();
sidebarHeading('Trainings');

$countScheduled = number_format(count(scheduledTrainings()));
$countActive = number_format(count(activeEmployees()));
$districtCount = number_format(count(districts(true)));
$schoolCount = number_format(count(schools(true)));
$sectionCount = number_format(count(sections()));

sidebarModalItem(uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
sidebarMenuItem(customUri('hrtdms', 'Scheduled Trainings'), 'Scheduled', 'fa-calendar-alt', isset($url) && str_contains($url, 'Scheduled'), $countScheduled);
sidebarMenuItem(customUri('hrtdms', 'Conducted Trainings'), 'Conducted', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Conducted'));
sidebarDivider();
sidebarMenuItem(customUri('hrtdms', 'Programs'), 'Programs', 'fa-cogs', isset($url) && str_contains($url, 'Programs'));
sidebarDivider();
sidebarMenuItem(customUri('hrtdms', 'Employees'), 'Employees', 'fa-users', isset($url) && str_contains($url, 'Employees'), $countActive);
sidebarMenuItem(customUri('hrtdms', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrtdms', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrmis', 'Division Office Information', DIVISION_ID), 'Division Office', 'fa-building', isset($url) && $url === 'School Information' && isset($_GET['id']) && decode($_GET['id']) === DIVISION_ID);
sidebarMenuItem(customUri('hrtdms', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);