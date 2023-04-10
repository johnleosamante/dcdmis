<?php
// dts/sidebar-menu.php
?>

<hr class="sidebar-divider d-none d-md-block my-0">

<?php
$is_school_portal = $_SESSION[alias() . '_portal'] === 'school_portal';

sidebar_menu_item(isset($url) && str_contains($url, 'Incoming'), custom_uri('dts', 'Incoming Documents'), 'Incoming', 'fa-file-download', num_rows(incoming_documents($_SESSION[alias() . '_station'])));

if (!$is_school_portal) {
  sidebar_menu_item(isset($url) && str_contains($url, 'Pending'), custom_uri('dts', 'Pending Documents'), 'Pending', 'fa-history', num_rows(pending_documents($_SESSION[alias() . '_station'])));
}

sidebar_menu_item(isset($url) && str_contains($url, 'Outgoing'), custom_uri('dts', 'Outgoing Documents'), 'Outgoing', 'fa-file-upload', num_rows(outgoing_documents($_SESSION[alias() . '_station'])));
?>

<hr class="sidebar-divider my-0">

<?php
sidebar_menu_item(isset($url) && str_contains($url, 'Ongoing'), custom_uri('dts', 'Ongoing Documents'), 'Ongoing', 'fa-tasks', num_rows(ongoing_documents($_SESSION[alias() . '_station'])));
?>

<hr class="sidebar-divider my-0">

<?php
sidebar_menu_item(isset($url) && str_contains($url, 'Completed'), custom_uri('dts', 'Completed Documents'), 'Completed', 'fa-check-circle');

if (!$is_school_portal) {
  sidebar_menu_item(isset($url) && str_contains($url, 'Received'), custom_uri('dts', 'Received Documents'), 'Received', 'fa-hand-holding-medical');
}

sidebar_menu_item(isset($url) && str_contains($url, 'Canceled'), custom_uri('dts', 'Canceled Documents'), 'Canceled', 'fa-trash-alt');
?>