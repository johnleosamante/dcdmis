<?php
# _includes_/layout/header.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo GetSiteDescription(); ?>">
  <meta name="author" content="<?php echo GetSiteAuthor(); ?>">
  <title><?php echo GetSiteTitle($page); ?></title>
  <link href="<?php echo GetSiteURL(); ?>/assets/img/logo.png" rel="shortcut icon">
  <link href="<?php echo GetSiteURL(); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo GetSiteURL(); ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">