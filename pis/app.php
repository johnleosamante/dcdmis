<?php
// pis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';
$page = $appTitle = "Personnel Profile";

if (!isset($userId)) {
  redirect(uri() . '/login');
}
?>