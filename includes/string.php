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

function to_long_date($date, $string='') {
  if (strtotime($date)) {
    return date("F j, Y", strtotime($date));
  } else {
    return $string;
  }
}
?>