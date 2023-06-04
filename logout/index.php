<?php
// logout/index.php
require_once('../includes/function.php');

session_destroy();
setcookie(alias() . '_login', '', time() - getSeconds(8), '/', uri(), false, true);
redirect(uri());
?>