<?php
# index.php
include_once('_includes_/function.php');
include_once('_includes_/database/database.php');
include_once('_includes_/database/user.php');

if (isset($_COOKIE[GetSiteAlias() . '_administrator_email'])) {
	$users = GetUser($_COOKIE[GetSiteAlias() . '_administrator_email']);

	if (DBNumRows($users) === 1) {
		$user = DBFetchAssoc($users);
		$_SESSION[GetSiteAlias() . '_uid'] = $user['usercode'];
		$_SESSION[GetSiteAlias() . '_ucode'] = $user['position'];
		$_SESSION[GetSiteAlias() . '_station'] = $user['station'];
		$_SESSION[GetSiteAlias() . '_school_id'] = $user['station'];
		$_SESSION[GetSiteAlias() . '_portal'] = $user['link'];
	}
}

if (!isset($_SESSION[GetSiteAlias() . '_uid'])) {
	header('location:' . GetSiteURL() . '/login');
	exit;
} else {
	header('location:' . GetHashURL($_SESSION[GetSiteAlias() . '_portal'], 'dashboard'));
	exit;
}
?>