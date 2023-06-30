<?php
// hrtdms/sidebar-menu.php
sidebarDivider();

sidebarHeading('Trainings');

$countScheduled = '0';

sidebarMenuItem(customUri('hrtdms', 'Scheduled Trainings'), 'Scheduled', 'fa-calendar-alt', isset($url) && str_contains($url, 'Scheduled'), $countScheduled);

sidebarMenuItem(customUri('hrtdms', 'Conducted Trainings'), 'Conducted', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Conducted'));
?>