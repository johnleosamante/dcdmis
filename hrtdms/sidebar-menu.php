<?php
// hrtdms/sidebar-menu.php
sidebarDivider();
sidebarHeading('Trainings');

$countScheduled = number_format(count(scheduledTrainings()));
$countActive = number_format(count(activeEmployees()));
$districtCount = number_format(count(districts()));
$schoolCount = number_format(count(schools()));
$sectionCount = number_format(count(sections()));

sidebarModalItem(uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
sidebarMenuItem(customUri('hrtdms', 'Scheduled Trainings'), 'Scheduled', 'fa-calendar-alt', isset($url) && str_contains($url, 'Scheduled'), $countScheduled);
sidebarMenuItem(customUri('hrtdms', 'Conducted Trainings'), 'Conducted', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Conducted'));
sidebarMenuItem(customUri('hrtdms', 'Program'), 'Program', 'fa-cogs', isset($url) && str_contains($url, 'Program'));
sidebarDivider();
sidebarMenuItem(customUri('hrtdms', 'Employees'), 'Employees', 'fa-users', isset($url) && str_contains($url, 'Employees'), $countActive);
sidebarMenuItem(customUri('hrtdms', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrtdms', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrtdms', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);