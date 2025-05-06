<?php
// hrmpsb/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmpsb';
$page = $appTitle = 'Human Resource Management Personnel Selection Board';

if (!isset($userId)) {
    redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
    redirect(uri() . '/pis');
}
