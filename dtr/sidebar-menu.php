<?php
// hrmis/sidebar-menu.php
sidebarDivider();

sidebarHeading('Daily Time Record');
sidebarMenuItem(customUri('dtr', 'Daily Time Record', $userId), 'Daily Time Record', 'fa-clock', isset($url) && str_contains($url, 'Daily Time Record'));
