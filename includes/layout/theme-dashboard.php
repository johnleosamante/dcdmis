<?php
// includes/layout/header.php
include_once('app.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = sanitize($url) . ' | ' . $appTitle;
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
      <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <a href="<?php echo uri(); ?>" title="<?php echo title(); ?>">
          <img class="sidebar-brand-icon" src="<?php echo uri(); ?>/assets/img/division.png" alt="<?php echo title(); ?>" width="60">
        </a>
      </div>
      
      <?php
      sidebarDivider();
      sidebarMenuItem(uri() . '/' . $activeApp, 'Dashboard', 'fa-tachometer-alt', !isset($url));
      include_once('sidebar-menu.php');
      sidebarDivider('3', true);
      sidebarToggle();
      ?>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include_once(root() . '/includes/layout/header-menu.php'); ?>

        <div class="container-fluid my-4">
          <?php include_once(root() . '/includes/layout/content.php'); ?>
        </div><!-- .container-fluid -->
      </div><!-- #content -->

      <?php include_once(root() . '/includes/layout/footer.php'); ?>
    </div><!-- #content-wrapper -->
  </div><!-- #wrapper -->

  <?php
  scrollToTop();
  modal();
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