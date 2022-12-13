<?php
# _includes_/function.php

include_once('config.php');

if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
  $IP = $_SERVER["HTTP_CLIENT_IP"];
} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
  $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
  $IP = $_SERVER["REMOTE_ADDR"];
}

$PROTOCOL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$HOST_URL = $PROTOCOL . $_SERVER['HTTP_HOST'];
$URL = $HOST_URL . '/' . strtolower(GetSiteAlias());

session_start();
date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');

function GetHash($string) {
  return sha1($string);
}

function GetHashPassword($string) {
  return md5($string);
}

function GetEncoding($string) {
  return urlencode(base64_encode($string));
}

function GetDecoding($string) {
  return base64_decode(urldecode($string));
}

function GetSiteURL() {
  global $URL;
  return $URL;
}

function GetHashURL($portal, $view, $identifier='') {
  global $URL;

  if (strlen($identifier) > 0) $identifier = '&id=' . GetEncoding($identifier);

  return $URL . '/' . $portal . '/?' . GetHash(SITE_TITLE) . $identifier . '&v=' . GetEncoding($view); 
}

function GetSiteTitle($page='') {
  return (strlen($page) === 0) ? SITE_TITLE : $page . " | " . SITE_TITLE;
}

function GetSiteAlias() {
  return SITE_ALIAS;
}

function GetSiteDescription() {
  return SITE_DESCRIPTION;
}

function GetSiteAuthor() {
  return SITE_AUTHOR;
}

function GetDepartment() {
  return DEPARTMENT;
}

function GetDepartmentAlias() {
  return DEPARTMENT_ALIAS;
}

function GetRegion() {
  return REGION;
}

function GetRegionAlias() {
  return REGION_ALIAS;
}

function GetDivision() {
  return DIVISION;
}

function GetDivisionCode() {
  return DIVISION_CODE;
}

function GetAddress() {
  return ADDRESS;
}

function GetDateTime() {
  return date('Y-m-d H:i:s');
}

function SetOptionSelected($reference, $value) {
  return strtolower($reference) === strtolower($value) ? ' selected' : '';
}

function SetActiveNavigationItem($condition) {
  return $condition ? ' active' : '';
}

function SetActiveNavigationTab($condition) {
  return $condition ? ' show active' : '';
}

function SetRadioButtonChecked($condition) {
  return $condition ? ' checked' : '';
}

function GetHRMOHead() {
  return HRMO_HEAD;
}

function GetHRMOHeadPosition() {
  return HRMO_HEAD_POSTION;
}

function GetImageFileUploadStatus($name, $target_file, $uploadlimit=5) {
  $file = $_FILES[$name]["name"];
  $temp = $_FILES[$name]["tmp_name"];
  $ext = pathinfo($file, PATHINFO_EXTENSION);
 
  $target_file = $target_file . '.' . $ext;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $message = '';

  if (file_exists($target_file)) {
    $message = "File already exists.";
    $uploadOk = 0;
  }

  if ($_FILES[$name]["size"] > $uploadlimit * 1024 * 1024) {
    $message = "The selected file exceeds the allowable upload size limit ($uploadlimit MB).";
    $uploadOk = 0;
  }

  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    $message = "Only JPG, JPEG, PNG & GIF file formats are allowed.";
    $uploadOk = 0;
  }

  $upload["temp_name"] = $temp;
  $upload["target"] = $target_file;
  $upload["message"] = $message;
  $upload["status"] = $uploadOk;

  return $upload;
}