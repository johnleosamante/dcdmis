<?php
// dts/sidebar-menu.php
sidebar_divider();

$is_school_portal = $_SESSION[alias() . '_portal'] === 'school_portal';

sidebar_menu_item(custom_uri('dts', 'Incoming Documents'), 'Incoming', 'fa-file-download', isset($url) && str_contains($url, 'Incoming'), number_format(num_rows(incoming_documents($_SESSION[alias() . '_station']))));

if (!$is_school_portal) {
  sidebar_menu_item(custom_uri('dts', 'Pending Documents'), 'Pending', 'fa-history', isset($url) && str_contains($url, 'Pending'), number_format(num_rows(pending_documents($_SESSION[alias() . '_station']))));
}

sidebar_menu_item(custom_uri('dts', 'Outgoing Documents'), 'Outgoing', 'fa-file-upload', isset($url) && str_contains($url, 'Outgoing'), number_format(num_rows(outgoing_documents($_SESSION[alias() . '_station']))));

sidebar_divider();

sidebar_menu_item(custom_uri('dts', 'Ongoing Documents'), 'Ongoing', 'fa-tasks', isset($url) && str_contains($url, 'Ongoing'), number_format(num_rows(ongoing_documents($_SESSION[alias() . '_station']))));

sidebar_divider();

sidebar_menu_item(custom_uri('dts', 'Completed Documents'), 'Completed', 'fa-check-circle', isset($url) && str_contains($url, 'Completed'));

if (!$is_school_portal) {
  sidebar_menu_item(custom_uri('dts', 'Received Documents'), 'Received', 'fa-hand-holding-medical', isset($url) && str_contains($url, 'Received'));
}

sidebar_menu_item(custom_uri('dts', 'Canceled Documents'), 'Canceled', 'fa-trash-alt', isset($url) && str_contains($url, 'Canceled'));
?>