<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarMenuItem(customUri('pis', 'Employee Information', $userId), 'Employee Information', 'fa-user-tie', isset($url) && str_contains($url, 'Employee Information'));
sidebarMenuItem(customUri('pis', 'Service Record', $userId), 'Service Record', 'fa-file-alt', isset($url) && str_contains($url, 'Service Record'));
sidebarMenuItem(customUri('pis', '201 Files', $userId), '201 Files', 'fa-folder-open', isset($url) && str_contains($url, '201 Files'));
sidebarMenuItem(customUri('pis', 'Trainings', $userId), 'Trainings', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Trainings'));
sidebarMenuItem(customUri('pis', 'Payslips', $userId), 'Payslips', 'fa-money-check', isset($url) && str_contains($url, 'Payslips'));

$isNonDivision = $stationId !== DIVISION_ID;

if (!$isNonDivision) {
    sidebarMenuItem(customUri('pis', 'Performance Evaluation', $userId), 'Performance Evaluation', 'fa-chart-line', isset($url) && str_contains($url, 'Performance Evaluation'));
}

if ($isSchoolPortal || $isNonDivision) {
    sidebarMenuItem(customUri('pis', 'Request Transfer'), 'Request Transfer', 'fa-exchange-alt', isset($url) && str_contains($url, 'Request Transfer'));
}

$schoolInfo = schoolByHead($userId);
if ($schoolInfo) {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Employees'), 'School Employees', 'fa-users', isset($url) && ($url === 'Employees' || $url === 'Active Employees'));
}

$showMonitoringTools = dtsUser($userId) && station($userId)['station_id'] === DIVISION_ID;

if ($showMonitoringTools) {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Monitoring Tools'), 'Monitoring Tools', 'fa-binoculars', isset($url) && str_contains($url, 'Monitoring Tools'));
}

$userPositionId = position($userId)['position_id'];
$showOverview = in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT;
if ($showOverview) {
    $primeHrmPillars = [
        'Recruitment, Selection and Placement',
        'Learning and Development',
        'Performance Management',
        'Rewards and Recognition'
    ];

    if (!$showMonitoringTools) {
        sidebarDivider();
    }

    sidebarMenuItem(customUri('pis', 'System Overview'), 'System Overview', 'fa-network-wired', isset($url) && (str_contains($url, 'System Overview') || in_array($url, $primeHrmPillars, true)));
}