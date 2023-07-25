<?php
// include/function.php
// All custom made general function goes here.
require_once('config.php');

$onError = function ($level, $message, $file, $line) {
  throw new ErrorException($message, 0, $level, $file, $line);
};

function hashString($string) {
  return sha1($string);
}

function hashPassword($string) {
  return md5($string);
}

function cipher($string) {
  return base64_encode($string);
}

function decipher($string) {
  return base64_decode($string);
}

function encode($string) {
  return urlencode(cipher($string));
}

function decode($string) {
  return urldecode(decipher($string));
}

function root() {
  return $_SERVER['DOCUMENT_ROOT'];
}

function uri() {
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
  return $protocol . $_SERVER['HTTP_HOST'];
}

function restrictPublicAccess() {
  switch (strtolower($_SERVER['HTTP_HOST'])) {
    case DOMAIN:
    case PUBLIC_IP:
      redirect(uri() . '/error');
      break;
    default:
      break;
  }

  return false;
}

function customUri($page, $view, $id=null) {
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

function clientIp() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    return $_SERVER['REMOTE_ADDR'];
  }
}

function redirect($url=null) {
  if ($url !== null) {
    header("Location: {$url}");
    exit;
  }
}

function getDatetime() {
  return date('Y-m-d H:i:s');
}

function getDatetimeAsId() {
  return date('YmdHis');
}

function getSeconds($hours=1) {
  return $hours * 60 * 60;
}

function setActiveItem($reference, $value, $class='active') {
  return strtolower($reference) === strtolower($value) ? " {$class}" : '';
}

function setActiveNavigation($condition, $class='active') {
  return $condition ? " {$class}" : '';
}

function isValidEmail($email, $domain=null) {
  if ($domain === null) {
    return preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email);
  }

  return preg_match("/^[a-zA-Z0-9_.-]+@+" . $domain . "+$/", $email);
}

function setOptionSelected($reference, $value) {
  return strtolower($reference) === strtolower($value) ? ' selected' : '';
}

function setItemChecked($condition) {
  return $condition ? ' checked' : '';
}

function getAge($year, $month, $day) {
  $now = new DateTime();
  $bdate = new DateTime("{$year}-{$month}-{$day}");
  return $now->diff($bdate)->y;
}

require_once('initialization.php');
?>