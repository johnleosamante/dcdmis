<?php
// hrmis/sidebar-menu.php
sidebarDivider();
sidebarMenuItem(customUri('pis','Personal Data Sheet', $userId), 'Personal Data Sheet', 'fa-user-tie', isset($url) && str_contains($url, 'Personal Data Sheet'));
sidebarMenuItem(customUri('pis', 'Service Record', $userId), 'Service Record','fa-file-alt', isset($url) && str_contains($url, 'Service Record'));
sidebarMenuItem(customUri('pis', '201 Files', $userId), '201 Files', 'fa-folder-open', isset($url) && str_contains($url, '201 Files'));
sidebarDivider();
sidebarMenuItem(customUri('pis', 'Certificates', $userId), 'Certificates', 'fa-certificate', isset($url) && str_contains($url, 'Certificates'));
sidebarMenuItem(customUri('pis', 'Trainings', $userId), 'Trainings', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Trainings'));
sidebarMenuItem(customUri('pis', 'Payslip', $userId), 'Payslip', 'fa-money-check', isset($url) && str_contains($url, 'Payslip'));
?>