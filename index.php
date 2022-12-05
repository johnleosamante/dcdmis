<?php
# index.php

include_once('_includes_/function.php');
include_once('_includes_/database/database.php');

if (!empty($_COOKIE['administrator_email'])) {
	$sql = DBQuery("SELECT * FROM tbl_user WHERE user='" . $_COOKIE['email'] . "' LIMIT 1;");

	if (DBNumRows($sql) === 1) {
		$rec = DBFetchAssoc($sql);
		$_SESSION['station'] = $rec['Station'];
		$_SESSION['uid'] = $rec['usercode'];
		$_SESSION['ucode'] = $rec['position'];
		$_SESSION['school_id'] = $rec['Station'];
		$_SESSION['portal'] = $rec['Link'];
	}
}

if (!isset($_SESSION['uid'])) {
	header('location:' . GetSiteURL() . '/login');
} else {
	header('location:' . GetHashURL($_SESSION['portal'], 'dashboard'));
}
?>