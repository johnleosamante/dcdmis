<?php
// pis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';
$page = $appTitle = 'Personnel Information System';
$isPis = true;

if (!isset($userId)) {
  redirect(uri() . '/login');
}
?>