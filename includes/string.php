<?php
// include/string.php

function to_string($string, $prefix=null, $suffix=null, $ischar=false) {
  if (strlen($string) === 0) return '';

  if ($ischar) $string = $string[0];

  return $prefix . $string . $suffix;
}

function to_name($last_name, $first_name, $middle_name='', $extension='', $fname_first=false, $middle_initial=true) {
  $suffix = $middle_initial ? '.' : '';

  $middle_name = to_string($middle_name, ' ', $suffix, $middle_initial);

  if (!$fname_first) {
    return $last_name . to_string($first_name, ', ') . to_string($extension, ' ') . $middle_name;
  } else {
    return $first_name . to_string($middle_name, ' ') . to_string($last_name, ' ') . to_string($extension, ', ');
  }
}

function to_address($lot, $street, $subdivision, $barangay, $city, $province='') {
  return to_string($lot, '', ', ') . to_string($street, '', ', ') . to_string($subdivision, '', ', ') . to_string($barangay, '', ', ') . to_string($city) . to_string($province, ', ');
}

function to_handle_null($value, $string='') {
  switch ($value) {
    case null:
    case 0:
    case '0':
    case '':
    case ' ':
      return $string;
      break;
    default:
      return $value;
  }
}

function to_date($date, $string='', $format='m/d/Y') {
  if (strtotime($date)) {
    return date($format, strtotime($date));
  } else {
    return $string;
  }
}

function to_age($birth_date) {
  $current_date = date_create(date('Y-m-d'));
  $date = date_create($birth_date);
  $difference = date_diff($date, $current_date);
  return $difference->format('%y');
}

function to_long_date($date, $string='') {
  if (strtotime($date)) {
    return date("F j, Y", strtotime($date));
  } else {
    return $string;
  }
}

function to_datetime($date) {
  if (strtotime($date)) {
    return date('F d, Y', strtotime($date)) . '<br>' . date('h:i:s A', strtotime($date));
  } else {
    return $date;
  }
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
  if (!$has_uppercase || !$has_lowercase || !$has_number || !$has_special_character) {
    return false;
  }
  return true;
}
?>