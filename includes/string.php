<?php
// include/string.php
function to_string($string, $prefix=null, $suffix=null, $ischar=false) {
  if (empty($string)) return '';
  if (strtolower($string) === 'n/a') return '';
  if ($ischar) $string = $string[0];
  return $prefix . $string . $suffix;
}

function to_name($last_name, $first_name, $middle_name='', $extension='', $fname_first=false, $middle_initial=true) {
  if (strlen($middle_name) > 0 && $middle_name !== ' ' && strtoupper($middle_name) !== 'n/a') {
    $suffix = $middle_initial ? '.' : '';
    $middle_name = to_string($middle_name, ' ', $suffix, $middle_initial);
  } else {
    $middle_name = '';
  }
  if (!$fname_first) {
    return $last_name . to_string($first_name, ', ') . to_string($extension, ' ') . $middle_name;
  } else {
    return $first_name . to_string($middle_name, ' ') . to_string($last_name, ' ') . to_string($extension, ', ');
  }
}

function to_address($lot, $street, $subdivision, $barangay, $city, $province='') {
  return to_string($lot, '', ', ') . to_string($street, '', ', ') . to_string($subdivision, '', ', ') . to_string($barangay, '', ', ') . to_string($city) . to_string($province, ', ');
}

function to_handle_null($value, $default = '') {
  return !empty($value) ? $value : $default;
}

function to_age($birth_date) {
  return date_diff(date_create($birth_date), date_create(date('Y-m-d')))->format('%y');
}

function to_date($date, $format='m/d/Y', $default = '') {
  return strtotime($date) ? date($format, strtotime($date)) : $default;
}

function to_long_date($date, $default = '') {
  return to_date($date, 'F j, Y', $default);
}

function to_datetime($date) {
  return strtotime($date) ? date('F d, Y', strtotime($date)) . '<br>' . date('h:i:s A', strtotime($date)) : $date;
}

function to_currency($value) {
  return '&#8369; ' . number_format($value, 2);
}

function sanitize($input, $default = '') {
  return empty($input) ? $default : htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES);
}

function random_password($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}|:<>?-=[]\;,./';
  $char_length = strlen($characters);
  $random_string = '';
  for ($i = 0; $i < $length; $i++) {
    $random_string .= $characters[rand(0, $char_length - 1)];
  }
  return $random_string;
}

function check_password_strength($password) {
  $has_uppercase = preg_match('/[A-Z]/', $password);
  $has_lowercase = preg_match('/[a-z]/', $password);
  $has_number = preg_match('/\d/', $password);
  $has_special_character = preg_match('/[^a-zA-Z\d]/', $password);
  return !$has_uppercase || !$has_lowercase || !$has_number || !$has_special_character;
}
?>