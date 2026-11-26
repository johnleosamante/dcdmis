<?php
// primedx/sidebar-menu.php
sidebarDivider();

sidebarHeading('Submissions');

if ($canManageCfs) {
    sidebarMenuItem(
        customUri('primedx', 'Call for Submissions'),
        'Call for Submissions',
        'fa-inbox',
        isset($url) && (str_contains($url, 'Call for Submission') || str_contains($url, 'School Submission'))
    );
}

if ($isSchoolHead) {
    sidebarMenuItem(
        customUri('primedx', 'My Submissions'),
        'My Submissions',
        'fa-paper-plane',
        isset($url) && (str_contains($url, 'My Submissions') || (!$canManageCfs && str_contains($url, 'School Submission')))
    );
}
