<?php
// modules/settings/app.php
$page_title = 'Settings';

if (isset($_POST['change-password'])) {
  $message = 'Password changed';
  $show_prompt = true;
}
?>