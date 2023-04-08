<?php
// includes/layout/theme-page.php
include_once('app.php');
include_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once(root() . '/includes/layout/header.php'); ?>
</head>

<body id="page-top" class="background-cover">
  <div id="layout">
    <div id="layout_content" class="container">
      <div class="row justify-content-center">
        <?php include_once('page.php'); ?>
      </div>
    </div><!-- .row -->

    <div id="layout_footer">
      <?php include_once(root() . '/includes/layout/footer.php'); ?>
    </div>
  </div>

  <?php scroll_to('#page-top'); ?>

  <script src="<?php echo uri(); ?>/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo uri(); ?>/assets/js/script.js"></script>
</body>

</html>