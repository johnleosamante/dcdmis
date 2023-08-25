<?php
// pis/app.php
if (isPublicDomain()) {
  redirect(uri() . '/error?e=403');
}

restrictPublicAccess(hasHoliday());

$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';
$page = $appTitle = 'Personnel Information System';
$isPis = true;

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}
?>