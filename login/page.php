<?php
// login/page.php
?>
<div class="col-xl-4 col-lg-5 col-md-8 col-sm-12">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-header">
      <h3 class="text-center text-gray-900 my-2"><?php echo $page; ?></h3>
    </div><!-- card-header -->

    <div class="card-body text-center">
      <?php
      displayLogo(120, 120, '3', uri(), title());

      messageAlert($showAlert, $message, $success);
      ?>

      <form action="" method="POST" class="text-left">
        <div class="form-group">
          <label for="email" class="text-gray-900 font-weight-bold mb-1">Email Address</label>
          <input class="form-control" id="email" name="email" type="email" placeholder="name@deped.gov.ph" autofocus required>
        </div><!-- .form-group -->

        <div class="form-group">
          <label for="password" class="text-gray-900 font-weight-bold mb-1">Password</label>
          <div class="input-group">
            <input class="form-control border-right-0" id="password" name="password" type="password" placeholder="Password" required>
            <div class="input-group-append">
              <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                <i id="eye" class="small fas fa-eye fa-sm"></i>
              </button>
            </div>
          </div>
        </div><!-- .form-group -->

        <div class="form-group">
          <div class="form-check small">
            <input class="form-check-input" id="remember" type="checkbox" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div><!-- .form-check-->
        </div><!-- .form-group -->

        <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
      </form>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div><!-- .col-xl-2 -->