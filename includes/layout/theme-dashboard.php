<?php
// includes/layout/header.php
include_once('app.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = base64_decode(urldecode($data));
  $page = real_escape_string($url) . ' | ' . $app_title;
}

include_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once(root() . '/includes/layout/header.php'); ?>
  <link rel="stylesheet" href="<?php echo uri(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css">
</head>

<body id="page-top">
  <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo uri(); ?>">
        <img class="sidebar-brand-icon" src="<?php echo uri(); ?>/assets/img/division.png" title="<?php echo title(); ?>" width="60">
      </a>

      <hr class="sidebar-divider my-0">

      <?php
      sidebar_menu_item(!isset($url), uri() . '/' . $_SESSION[alias() . '_active_app'], 'Dashboard', 'fa-tachometer-alt');

      include_once('sidebar-menu.php'); ?>

      <hr class="sidebar-divider">

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include_once(root() . '/includes/layout/header-menu.php'); ?>

        <div class="container-fluid mb-4">
          <?php include_once(root() . '/includes/layout/content.php'); ?>
        </div><!-- .container-fluid -->
      </div><!-- #content -->

      <?php include_once(root() . '/includes/layout/footer.php'); ?>
    </div><!-- #content-wrapper -->
  </div><!-- #wrapper -->

  <?php
  scroll_to('#page-top');
  modal('Modal');
  ?>

  <script src="<?php echo uri(); ?>/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/js/sb-admin-2.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/js/script.js"></script>
</body>

</html>