<?php
# index.php
include_once('_includes_/function.php');
include_once('_includes_/database/database.php');
include_once('_includes_/database/user.php');

if (isset($_COOKIE['administrator_email'])) {
	$users = GetUser($_COOKIE['administrator_email']);

	if (DBNumRows($users) === 1) {
		$user = DBFetchAssoc($users);
		$_SESSION['uid'] = $user['usercode'];
		$_SESSION['ucode'] = $user['position'];
		$_SESSION['station'] = $user['station'];
		$_SESSION['school_id'] = $user['station'];
		$_SESSION['portal'] = $user['link'];
	}
}

if (!isset($_SESSION['uid'])) {
	header('location:' . GetSiteURL() . '/login');
	exit;
} else {
	header('location:' . GetHashURL($_SESSION['portal'], 'dashboard'));
	exit;
}
?>