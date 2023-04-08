<?php
// dmis/app.php
$_SESSION[alias() . '_active_app'] = 'dmis';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

echo 'DMIS Warning: Unauthorized Access';
exit;

$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app = "Data Management Information System";
?>