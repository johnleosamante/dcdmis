<?php
// pis/sidebar-menu.php
$isNonDivision = $stationId !== DIVISION_ID;
$schoolInfo = schoolByHead($userId, DIVISION_ID);
$isSchoolHead = (bool) $schoolInfo;

sidebarDivider();

sidebarMenuItem(customUri('pis', 'Employee Information', $userId), 'Employee Information', 'fa-user-tie', isset($url) && str_contains($url, 'Employee Information'));
sidebarMenuItem(customUri('pis', 'Service Record', $userId), 'Service Record', 'fa-file-alt', isset($url) && str_contains($url, 'Service Record'));
sidebarMenuItem(customUri('pis', '201 Files', $userId), '201 Files', 'fa-folder-open', isset($url) && str_contains($url, '201 Files'));
sidebarMenuItem(customUri('pis', 'Trainings', $userId), 'Trainings', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Trainings'));
sidebarMenuItem(customUri('pis', 'Payslips', $userId), 'Payslips', 'fa-money-check', isset($url) && str_contains($url, 'Payslips'));

if (!$isNonDivision) {
    sidebarMenuItem(customUri('pis', 'IPCRF', $userId), 'IPCRF', 'fa-chart-line', isset($url) && (str_contains($url, 'IPCRF') || str_contains($url, 'Performance') || str_contains($url, 'Phase') || str_contains($url, 'Objective') || str_contains($url, 'MOV')));
    sidebarMenuItem(customUri('pis', 'Purchase Requests'), 'Purchase Requests', 'fa-shopping-cart', isset($url) && str_contains($url, 'Purchase Request'));
    sidebarMenuItem(customUri('bsa', 'Booking & Schedule'), 'Booking & Schedule', 'fa-calendar-check');
}

if ($isNonDivision) {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Request Transfer'), 'Request Transfer', 'fa-exchange-alt', isset($url) && str_contains($url, 'Request Transfer'));
}

$showMonitoringTools = (dtsUser($userId) && (station($userId)['station_id'] ?? null) === DIVISION_ID) || $isSchoolHead;
$userPositionId = position($userId)['position_id'] ?? null;
$showOverview = in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT;
$showCfsManagement = canManageCallForSubmissions($userId, $stationId, $code);

if ($showMonitoringTools || $showOverview || $showCfsManagement) {
    sidebarDivider();

    if ($showCfsManagement) {
        sidebarMenuItem(
            customUri('primedx', 'Call for Submissions'),
            'Call for Submissions',
            'fa-inbox'
        );
    }

    if ($isSchoolHead) {
        sidebarMenuItem(
            customUri('primedx', 'My Submissions'),
            'My Submissions',
            'fa-paper-plane'
        );
        sidebarMenuItem(
            customUri('pis', 'School Employees'),
            'School Employees',
            'fa-users',
            isset($url) && ($url === 'Employees' || $url === 'Active Employees' || $url === 'School Employees')
        );
    }

    if ($showMonitoringTools) {
        sidebarMenuItem(customUri('pis', 'Monitoring Tools'), 'Monitoring Tools', 'fa-binoculars', isset($url) && str_contains($url, 'Monitoring Tools'));
    }

    if ($showOverview) {
        sidebarMenuItem(uri() . '/hrmsuite', 'HRM Suite', 'fa-network-wired');
    }
}
