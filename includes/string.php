<?php
// include/string.php
function toString($string, $prefix=null, $suffix=null, $ischar=false) {
  if (empty($string)) return '';
  if (strtolower($string) === 'n/a') return '';
  if ($ischar) $string = $string[0];
  return $prefix . $string . $suffix;
}

function toName($lastName, $firstName, $middleName='', $extension='', $fnameFirst=false, $middleInitial=true) {
  if (strlen($middleName) > 0 && $middleName !== ' ' && strtoupper($middleName) !== 'n/a') {
    $suffix = $middleInitial ? '.' : '';
    $middleName = toString($middleName, ' ', $suffix, $middleInitial);
  } else {
    $middleName = '';
  }
  if (!$fnameFirst) {
    return $lastName . toString($firstName, ', ') . toString($extension, ' ') . $middleName;
  } else {
    return $firstName . toString($middleName) . toString($lastName, ' ') . toString($extension, ', ');
  }
}

function toAddress($lot, $street, $subdivision, $barangay, $city, $province='') {
  return toString($lot, '', ', ') . toString($street, '', ', ') . toString($subdivision, '', ', ') . toString($barangay, '', ', ') . toString($city) . toString($province, ', ');
}

function toHandleNull($value, $default='') {
  return !empty($value) ? $value : $default;
}

function toAge($birthDate) {
  return date_diff(date_create($birthDate), date_create(date('Y-m-d')))->format('%y');
}

function toDate($date, $format='m/d/Y', $default='') {
  return strtotime($date) ? date($format, strtotime($date)) : $default;
}

function toLongDate($date, $default = '') {
  return toDate($date, 'F j, Y', $default);
}

function toDatetime($date) {
  return strtotime($date) ? date('F j, Y', strtotime($date)) . '<br>' . date('h:i:s A', strtotime($date)) : $date;
}

function toCurrency($value, $currency='&#8369;') {
  $number = is_numeric($value) ? $value : 0;
  return $currency . ' ' . number_format(floatval($number), 2);
}

function sanitize($input) {
  return isset($input) ? htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES) : '';
}

function randomPassword($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>?-=[]\;,./';
  $charLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charLength - 1)];
  }
  return $randomString;
}

function checkPasswordStrength($password) {
  $hasUppercase = preg_match('/[A-Z]/', $password);
  $hasLowercase = preg_match('/[a-z]/', $password);
  $hasNumber = preg_match('/\d/', $password);
  $hasSpecialCharacter = preg_match('/[^a-zA-Z\d]/', $password);
  return $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialCharacter;
}

function generateStrongRandomPassword() {
  $strongPassword = false;
  $randomPassword = '';
  $length = rand(10, 16);

  while (!$strongPassword) {
    $randomPassword = randomPassword($length);
    $strongPassword = checkPasswordStrength($randomPassword);
  }
}
?>