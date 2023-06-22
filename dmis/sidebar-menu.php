<?php
// dmis/sidebar-menu.php
sidebarDivider();

sidebarMenuItem(customUri('dmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'Districts'), number_format(numRows(districts())));

sidebarMenuItem(customUri('dmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), number_format(numRows(schools())));

sidebarMenuItem(customUri('dmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Sections'), number_format(numRows(sections())));

sidebarMenuItem(customUri('dmis', 'Users'), 'Users', 'fa-users', isset($url) && str_contains($url, 'Users'), number_format(numRows(users())));
?>