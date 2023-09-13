<?php
// pis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

$page = $appTitle = 'Personnel Information System';

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}
?>