<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarMenuItem(customUri('pis', 'Employee Information', $userId), 'Employee Information', 'fa-user-tie', isset($url) && str_contains($url, 'Employee Information'));
sidebarMenuItem(customUri('pis', 'Service Record', $userId), 'Service Record', 'fa-file-alt', isset($url) && str_contains($url, 'Service Record'));
sidebarMenuItem(customUri('pis', '201 Files', $userId), '201 Files', 'fa-folder-open', isset($url) && str_contains($url, '201 Files'));
sidebarMenuItem(customUri('pis', 'Trainings', $userId), 'Trainings', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Trainings'));
sidebarMenuItem(customUri('pis', 'Payslips', $userId), 'Payslips', 'fa-money-check', isset($url) && str_contains($url, 'Payslips'));

$isNonDivision = $stationId !== '143';
if ($isSchoolPortal || $isNonDivision) {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Request Transfer'), 'Request Transfer', 'fa-exchange-alt', isset($url) && str_contains($url, 'Request Transfer'));
}

$schoolInfo = schoolByHead($userId);
if ($schoolInfo) {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Employees'), 'School Employees', 'fa-users', isset($url) && ($url === 'Employees' || $url === 'Active Employees'));
}

if (dtsUser($userId) && station($userId)['station_id'] === '143') {
    sidebarDivider();
    sidebarMenuItem(customUri('pis', 'Monitoring Tools'), 'Monitoring Tools', 'fa-binoculars', isset($url) && str_contains($url, 'Monitoring Tools'));
}

sidebarMenuItem(customUri('pis', 'Performance Management', $userId), 'Performance Management', 'fa-chart-line', isset($url) && str_contains($url, 'Performance Management'));
sidebarMenuItem(customUri('pis', 'Daily Time Record', $userId), 'Daily Time Record', 'fa-clock', isset($url) && str_contains($url, 'Daily Time Record'));
