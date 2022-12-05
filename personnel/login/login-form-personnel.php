<?php
# personnel/login/login-form.php
?>

<div class="card shadow-lg border-0 rounded-lg my-5">
  <div class="card-header">
    <h3 class="text-center fw-light my-2"><?php echo $page; ?></h3>
  </div><!-- .card-header -->

  <div class="card-body">
    <?php
    SiteLogo(120, 120);

    if ($Err) {
      AlertBox('Invalid DepEd email address and password! Try again.');
    }
    ?>

    <form class="user" action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <input class="form-control form-control-user" id="inputEmail" name="emailadd" type="email" placeholder="name@deped.gov.ph">
      </div><!-- .form-group -->

      <div class="form-group">
        <input class="form-control form-control-user" id="inputPassword" name="password" type="password" placeholder="Password">
      </div><!-- .form-group -->

      <div class="form-check form-check small">
        <input class="form-check-input" id="inputShowPassword" type="checkbox">
        <label class="form-check-label" for="inputShowPassword">Show password</label>
      </div><!-- .form-group -->

      <?php ShowPassword('inputShowPassword', 'inputPassword'); ?>

      <div class="small my-3">
        People who use our service may have uploaded your contact information to <?php echo GetSiteAlias(); ?>. By clicking login, you agree to our <a href="<?php echo GetSiteURL(); ?>/about/privacy" target="_blank">Data Privacy Policy Guidelines.</a>
      </div><!-- .small -->

      <input type="submit" class="btn btn-primary mb-0 btn-lg w-100" value="Login" name="login">
    </form>
  </div><!-- .card-body -->

  <div class="card-footer text-center py-3">
    <a class="small" href="<?php echo GetSiteURL(); ?>/login">Go to Administrator Login</a>
  </div><!-- .card-footer -->
</div><!-- .card -->