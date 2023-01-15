<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['settingstab']) && $_SESSION['settingstab'] === 'security-login'); ?>" id="security-login">
  <form class="py-2" action="" Method="POST">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="inputEmail" class="mb-0">DepEd Email Address:</label>
          <input id="inputEmail" type="email" value="<?php echo $row_record['Emp_Email']; ?>" class="form-control" disabled>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="inputPassword" class="mb-0">New Password:</label>
          <input type="password" id="inputPassword" name="password" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="inputRetypePassword" class="mb-0">Retype New Password:</label>
          <input type="password" id="inputRetypePassword" name="confirm" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group form-check small">
          <input class="form-check-input" id="inputShowPassword" type="checkbox">
          <label class="form-check-label" for="inputShowPassword">Show password</label>
        </div><!-- .form-group -->
      </div><!-- .col-md-4 -->
    </div><!-- .row -->

    <?php ShowPassword('inputShowPassword', 'inputPassword', 'inputRetypePassword'); ?>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <input type="submit" name="UpdatePassword" value="Change" class="btn btn-primary btn-block btn-lg">
      </div>
    </div><!-- .col-sm-12 -->
  </form>
</div><!-- .tab-pane -->