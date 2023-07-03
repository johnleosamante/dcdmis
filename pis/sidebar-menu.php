<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarMenuItem(customUri('pis','Personal Data Sheet', $userId), 'Personal Data Sheet', 'fa-user');

sidebarMenuItem(customUri('pis', 'Service Record'), 'Service Record','fa-file-alt');

sidebarMenuItem(customUri('pis', '201 File'), '201 File', 'fa-book-open');

sidebarMenuItem(customUri('pis', 'IPCRF'), 'IPCRF', 'fa-tasks');

sidebarDivider();

sidebarMenuItem(customUri('pis', 'Certificates'), 'Certificates', 'fa-certificate');

sidebarMenuItem(customUri('pis', 'Trainings'), 'Trainings', 'fa-chalkboard-teacher');

sidebarMenuItem(customUri('pis', 'Payslip'), 'Payslip', 'fa-money-check');

sidebarDivider();

sidebarHeading('Requests');

sidebarMenuItem(customUri('pis', 'DepEd Account Request'), 'DepEd Account', 'fa-edit');

sidebarMenuItem(customUri('pis', 'Transfer Request'), 'Transfer', 'fa-map');