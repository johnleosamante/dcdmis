<?php
// logout/index.php
require_once('../includes/function.php');

if (isset($_SESSION[alias() . '_user_id'])) {
  // TODO: log out user
}

session_destroy();
setcookie(alias() . '_login', '', time() - get_seconds(8), '/', uri(), false, true);
redirect(uri());
?>