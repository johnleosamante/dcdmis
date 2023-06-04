<?php
// modules/settings/app.php
$pageTitle = 'Settings';

if (isset($_POST['change-password'])) {
  $message = 'Password changed';
  $showPrompt = true;
}
?>