<?php
// includes/layout/theme-page.php
require_once('app.php');
require_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once(root() . '/includes/layout/header.php'); ?>
  </head>

  <body id="page-top" class="background-cover">
    <div id="layout">
      <div id="layout-content" class="container-xl">
        <div id="main-content" class="row justify-content-center">
          <?php require_once('page.php'); ?>
        </div>
      </div>
      
      <div id="layout-footer">
        <?php require_once(root() . '/includes/layout/footer.php'); ?>
      </div>
    </div>

    <?php scrollToTop(); ?>

    <script src="<?php echo uri(); ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo uri(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo uri(); ?>/assets/js/script.js"></script>
  </body>
</html>