<?php
// include/function.php
// All custom made general function goes here.

include_once('config.php');

function hash_string($string) {
  return sha1($string);
}

function hash_password($string) {
  return md5($string);
}

function encode($string) {
  return urlencode(base64_encode($string));
}

function decode($string) {
  return urldecode(base64_decode($string));
}

function root() {
  return $_SERVER['DOCUMENT_ROOT'];
}

function uri() {
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
  return $protocol . $_SERVER['HTTP_HOST'];
}

function custom_uri($page, $view, $id=null) {
  $value = ($id !== null) ? '&id=' . encode($id) : '';

  return uri() . "/{$page}?{$value}&v=" . encode($view);
}

function title($page=null) {
  return $page === null ? SITE_TITLE : $page . ' | ' . SITE_TITLE;
}

function alias() {
  return SITE_ALIAS;
}

function description() {
  return SITE_DESCRIPTION;
}

function author() {
  return SITE_AUTHOR;
}

function client_ip() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    return $_SERVER['REMOTE_ADDR'];
  }
}

function redirect($url = null) {
  if ($url !== null) {
    header("Location: {$url}");
    exit;
  }
}

function get_datetime() {
  return date('Y-m-d H:i:s');
}

function get_datetime_as_id() {
  return date('YmdHis');
}

function get_seconds($hours=1) {
  return $hours * 60 * 60;
}

function set_active_item($reference, $value, $class='active') {
  return strtolower($reference) === strtolower($value) ? " {$class}" : '';
}

function set_active_navigation($condition, $class='active') {
  return $condition ? " {$class}" : '';
}

function is_valid_email($email, $domain = null) {
  if ($domain === null) {
    return preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email);
  }

  return preg_match("/^[a-zA-Z0-9_.-]+@+" . $domain . "+$/", $email);
}

function set_option_selected($reference, $value) {
  return strtolower($reference) === strtolower($value) ? ' selected' : '';
}

function get_age($year, $month, $day) {
  $now = new DateTime();
  $bdate = new DateTime("{$year}-{$month}-{$day}");
  return $now->diff($bdate)->y;
}

include_once('initialization.php');
?>