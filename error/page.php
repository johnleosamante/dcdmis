<?php
// login/page.php
?>
<div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-header text-center">
      <?php displayLogo(120, 120, '0', uri(), title()); ?>
    </div><!-- card-header -->

    <div class="card-body text-center">
      <?php require_once(root() . '/modules/error/' . $file . '.php'); ?>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div><!-- .col-xl-2 -->