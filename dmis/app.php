<?php
// dmis/app.php
restrictPublicAccess();

$activeApp = $_SESSION[alias() . '_activeApp'] = 'dmis';
$page = $appTitle = "Division Management Information System";

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, 'ICT')) === 0) {
  redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('dmis', 'Search', sanitize($_POST['primary-search-text'])));
}


?>