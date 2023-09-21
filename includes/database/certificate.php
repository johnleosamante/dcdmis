<?php
// includes/database/certificate.php
// tbl_certificate_archive
function certificates($id) {
  return query("SELECT `No` AS `no`, `Certificate_details` AS `title`, `date_awarded`, `Certificate_category` AS `category`, `Certificate_Level` AS `level`, `date_time_upload` AS `datetime`,  `location` FROM tbl_certificate_archive WHERE Emp_ID='{$id}' ORDER BY `date_awarded` DESC;");
}

function certificate($id, $no) {
  return query("SELECT `No` AS `no`, `Certificate_details` AS `title`, `date_awarded`, `Certificate_category` AS `category`, `Certificate_Level` AS `level`, `date_time_upload` AS `datetime`,  `location` FROM tbl_certificate_archive WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createCertificate($title, $dateAwarded, $category, $level, $location, $id) {
  nonQuery("INSERT INTO tbl_certificate_archive (`Certificate_details`, `date_awarded`, `Certificate_category`, `Certificate_Level`, `date_time_upload`, `localtion`, Emp_ID) VALUES ('{$title}', '{$dateAwarded}', '{$category}', '{$level}', NOW(), '{$location}', '{$id}');");
}

function updateCertificate($title, $dateAwarded, $category, $level, $location, $id, $no) {
  nonQuery("UPDATE tbl_certificate_archive SET `Certificate_details`='{$title}', `date_awarded`='{$dateAwarded}', `Certificate_category`='{$category}', `Certificate_Level`='{$level}', `date_time_upload`=NOW(), `location`='{$location}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>