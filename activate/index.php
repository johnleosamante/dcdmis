<?php
# activate/index.php
include_once('../_includes_/function.php');

if (!isset($_SESSION[GetSiteAlias() . '_activate_uid'])) {
  header('location:' . GetSiteURL() . '/login');
  exit;
}

$page = 'Activate Administrator Account';

include_once('../_includes_/database/database.php');
include_once('../_includes_/layout/header.php');
include_once('../_includes_/layout/components.php');
?>
</head>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
          <div class="card shadow-lg border-0 rounded-lg my-5">
            <div class="card-header">
              <h3 class="text-center font-weight-light my-2"><?php echo $page; ?></h3>
            </div><!-- .card-header -->

            <div class="card-body">
              <?php
              $success = false;
              $match = false;

              if (isset($_POST['activate'])) {
                if ($_POST['newpassword'] === $_POST['Confirmpassword']) {
                  $pass = GetHashPassword(DBRealEscapeString($_POST['newpassword']));

                  DBQuery("UPDATE tbl_user SET tbl_user.password='$pass', tbl_user.Status='Changed' WHERE tbl_user.usercode='" . $_SESSION[GetSiteAlias() . '_activate_uid'] . "' LIMIT 1;");
                  DBQuery("UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='$pass',tbl_teacher_account.Pass_status='Changed' WHERE tbl_teacher_account.Teacher_TIN='" . $_SESSION[GetSiteAlias() . '_activate_email'] . "' LIMIT 1;");

                  $match = true;
                  $success = true;
                }
              }

              if ($success) {
                SuccessLogo('50%', '50%');
                session_destroy();
              ?>

                <div class="text-center">Your administrator account has been activated successfully. You can now <a href="<?php echo GetSiteURL(); ?>/login">login</a> using your DepEd email address and password.</div>

              <?php
              } else {
                SiteLogo(120, 120);
              ?>

                <p class="text-center">Enter your new password to activate your account.</p>

                <form class="user" method="POST" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputEmail" type="email" placeholder="name@deped.gov.ph" value="<?php echo $_SESSION[GetSiteAlias() . '_activate_email']; ?>" disabled>
                  </div><!-- .form-group -->

                  <?php
                  if (isset($_POST['activate']) && !$match) {
                    AlertBox('Password do not match! Try again.');
                  }
                  ?>

                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputPassword" name="newpassword" type="password" placeholder="New Password" required>
                  </div><!-- .form-group -->

                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputRetypePassword" name="Confirmpassword" type="password" placeholder="Retype New Password" required>
                  </div><!-- .form-group -->

                  <div class="form-group form-check small">
                    <input class="form-check-input" id="inputShowPassword" type="checkbox">
                    <label class="form-check-label" for="inputShowPassword">Show password</label>
                  </div><!-- .form-group -->

                  <?php ShowPassword('inputShowPassword', 'inputPassword', 'inputRetypePassword'); ?>

                  <input type="submit" class="btn btn-primary btn-block" name="activate" value="Activate">
                </form>
              <?php } ?>
            </div><!-- .card-body -->
          </div><!-- .card -->
        </div><!-- .col-lg-5 -->
      </div><!-- .row -->
    </div><!-- #layoutAuthentication_content -->

    <div id="layoutAuthentication_footer">
      <?php include_once('../_includes_/layout/footer.php'); ?>
    </div><!-- #layoutAuthentication_footer -->
  </div><!-- #layoutAuthentication -->
</body>

</html>