<?php
// hrmis/app.php
$_SESSION[alias() . '_active_app'] = 'hrmis';

if (!isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/login');
}

// echo 'HRMIS Warning: Unauthorized Access';
// exit;

$show_prompt = false;
$message = null;
$type = 'success';
$align = 'left';
$page = $app_title = "Human Resource Management Information System";

if (isset($_POST['primary_search_button'])) {
  redirect(custom_uri('hrmis', 'Employee Search', real_escape_string($_POST['primary_search_text'])));
}

$user_id = $_SESSION[alias() . '_user_id'];
?>