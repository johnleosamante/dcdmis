<?php
// hrmsuite/sidebar-menu.php
sidebarDivider();

sidebarHeading('PRIME-HRM Pillars');

$rspViews = [
    'Recruitment, Selection and Placement',
    'Active Employees',
    'Retirable Employees',
    'Employee Information',
    'Service Record',
    '201 Files',
    'Trainings',
    'Vacancies',
    'Call for Applications',
    'Call for Application Details',
    'Positions',
    'Plantilla Items',
];
$isRspActive = isset($url) && (
    in_array($url, $rspViews, true)
    || str_contains($url, 'Workforce Diversity')
    || str_contains($url, 'Talent Pool Diversity')
);

$lndViews = [
    'Learning and Development',
    'Scheduled Trainings',
    'Conducted Trainings',
    'Trained Employees',
    'Programs',
    'Program Detail',
    'Project Detail',
    'Training Details',
];
$isLndActive = isset($url) && in_array($url, $lndViews, true);

$isPmActive = isset($url) && $url === 'Performance Management';

$rnrViews = [
    'Rewards and Recognition',
    'Event Schedules',
    'Awards List',
    'Nominees List',
    'Winners Lookup',
    'Ranking',
];
$isRnrActive = isset($url) && in_array($url, $rnrViews, true);

sidebarMenuItem(customUri('hrmsuite', 'Recruitment, Selection and Placement'), 'Recruitment, Selection & Placement', 'fa-user-check', $isRspActive);
sidebarMenuItem(customUri('hrmsuite', 'Learning and Development'), 'Learning & Development', 'fa-chalkboard-teacher', $isLndActive);
sidebarMenuItem(customUri('hrmsuite', 'Performance Management'), 'Performance Management', 'fa-chart-line', $isPmActive);
sidebarMenuItem(customUri('hrmsuite', 'Rewards and Recognition'), 'Rewards & Recognition', 'fa-trophy', $isRnrActive);
