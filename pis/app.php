<?php
// pis/app.php
if (!isset($userId)) {
  redirect(uri() . '/login');
}

$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';
$page = $appTitle = 'Personnel Information System';

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}
?>