<?php
# _includes_/string.php

function ToString($text, $prefix='', $suffix='', $isChar=false) {
  if (strlen($text) == 0) return '';

  if ($isChar) $text = $text[0];

  return $prefix . $text . $suffix;
}

function ToName($lname, $fname, $mname='', $ext='', $fnamefirst=false, $fullmname=false) {
  $suffix = $fullmname ? '' : '.';
  $mname = ToString($mname, ' ', $suffix, !$fullmname);
  return !$fnamefirst ? $lname . ToString($fname, ', ') . ToString($ext, ' ') . $mname : $fname . ToString($mname, ' ') . ToString($lname, ' ') . ToString($ext, ', ');
}

function ToAddress($lot, $street, $subdivision, $barangay, $city, $province='') {
  return ToString($lot, '', ', ') . ToString($street, '', ', ') . ToString($subdivision, '', ', ') . ToString($barangay, '', ', ') . ToString($city) . ToString($province, ', ');
}

function ToDateString($date, $string='') {
  if (strtotime($date)) {
    return date("m/d/Y", strtotime($date));
  } else {
    return $string;
  }
}

function ToLongDateString($date, $string='') {
  if (strtotime($date)) {
    return date("F j, Y", strtotime($date));
  } else {
    return $string;
  }
}
?>