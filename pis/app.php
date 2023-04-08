<?php
// pis/app.php
$_SESSION[alias() . '_active_app'] = 'pis';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app = "Personnel Information System";
?>