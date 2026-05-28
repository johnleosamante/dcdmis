<?php
// dts/track/app.php
$appTitle = $page = !MAINTENANCE_MODE ? 'Document Tracking System' : 'System Maintenance';
$searchText = '';

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('dts/track', 'Document Information', sanitize($_POST['primary-search-text'])));
}