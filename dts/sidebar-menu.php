<?php
// dts/sidebar-menu.php
sidebarDivider();

sidebarMenuItem(customUri('dts', 'Incoming Documents'), 'Incoming', 'fa-file-download', isset($url) && str_contains($url, 'Incoming'), number_format(numRows(incomingDocuments($station))));

sidebarMenuItem(customUri('dts', 'Pending Documents'), 'Pending', 'fa-history', isset($url) && str_contains($url, 'Pending'), number_format(numRows(pendingDocuments($station))));

sidebarMenuItem(customUri('dts', 'Outgoing Documents'), 'Outgoing', 'fa-file-upload', isset($url) && str_contains($url, 'Outgoing'), number_format(numRows(outgoingDocuments($station))));

sidebarDivider();

sidebarMenuItem(customUri('dts', 'Ongoing Documents'), 'Ongoing', 'fa-tasks', isset($url) && str_contains($url, 'Ongoing'), number_format(numRows(ongoingDocuments($station))));

sidebarDivider();

sidebarMenuItem(customUri('dts', 'Completed Documents'), 'Completed', 'fa-check-circle', isset($url) && str_contains($url, 'Completed'));

if (!$is_school_portal) {
  sidebarMenuItem(customUri('dts', 'Received Documents'), 'Received', 'fa-hand-holding-medical', isset($url) && str_contains($url, 'Received'));
}

sidebarMenuItem(customUri('dts', 'Canceled Documents'), 'Canceled', 'fa-trash-alt', isset($url) && str_contains($url, 'Canceled'));
?>