<?php
// hrmis/sidebar-menu.php
sidebarDivider();
sidebarMenuItem(customUri('pis','Personal Data Sheet', $userId), 'Personal Data Sheet', 'fa-user', isset($url) && str_contains($url, 'Personal Data Sheet'));
sidebarMenuItem(customUri('pis', 'Service Record', $userId), 'Service Record','fa-file-alt', isset($url) && str_contains($url, 'Service Record'));
sidebarMenuItem(customUri('pis', '201 File', $userId), '201 File', 'fa-folder-open', isset($url) && str_contains($url, '201 File'));
sidebarMenuItem(customUri('pis', 'IPCRF', $userId), 'IPCRF', 'fa-tasks', isset($url) && str_contains($url, 'IPCRF'));
sidebarDivider();
sidebarMenuItem(customUri('pis', 'Certificates', $userId), 'Certificates', 'fa-certificate', isset($url) && str_contains($url, 'Certificates'));
sidebarMenuItem(customUri('pis', 'Trainings', $userId), 'Trainings', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Trainings'));
sidebarMenuItem(customUri('pis', 'Payslip', $userId), 'Payslip', 'fa-money-check', isset($url) && str_contains($url, 'Payslip'));
sidebarDivider();
sidebarHeading('Requests');
sidebarMenuItem(customUri('pis', 'DepEd Account Request', $userId), 'DepEd Account', 'fa-edit', isset($url) && str_contains($url, 'DepEd Account'));
sidebarMenuItem(customUri('pis', 'Transfer Request', $userId), 'Transfer', 'fa-map', isset($url) && str_contains($url, 'Transfer'));
?>