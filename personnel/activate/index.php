<?php
# personnel/activate/index.php

include_once('../../_includes_/function.php');

if (!isset($_SESSION[GetSiteAlias() . '_activate_puid'])) {
  header('location:' . GetSiteURL() . '/personnel/login');
  exit;
}

$page = 'Activate Personnel Account';

include_once('../../_includes_/database/database.php');
include_once('../../_includes_/layout/header.php');
include_once('../../_includes_/layout/components.php');
?>
</head>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
          <div class="card shadow-lg border-0 rounded-lg my-5">
            <div class="card-header">
              <h3 class="text-center font-weight-light my-4"><?php echo $page; ?></h3>
            </div><!-- .card-header -->

            <div class="card-body">
              <?php
              $success = false;
              $match = false;

              if (isset($_POST['activate'])) {
                if ($_POST['newpassword'] === $_POST['Confirmpassword']) {
                  $pass = GetHashPassword(DBRealEscapeString($_POST['newpassword']));

                  DBNonQuery("UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='$pass', tbl_teacher_account.Pass_status='Changed' WHERE tbl_teacher_account.Teacher_TIN='" . $_SESSION[GetSiteAlias() . '_activate_pemail'] . "' LIMIT 1");

                  $match = true;
                  $success = true;
                }
              }

              if ($success) {
                SuccessLogo('50%', '50%');
                session_destroy();
              ?>

                <div class="text-center">Your personnel account has been activated successfully. You can now <a href="<?php echo GetSiteURL(); ?>/personnel/login">login</a> using your DepEd email address and password.</div>

              <?php
              } else {
                SiteLogo(120, 120);
              ?>

                <p class="text-center">Enter your new password to activate your account.</p>

                <form class="user" method="POST" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputEmail" type="email" placeholder="DepEd email address" value="<?php echo $_SESSION['activate_pemail']; ?>" disabled>
                  </div><!-- .form-group -->

                  <?php
                  if (isset($_POST['activate']) && !$match) {
                    AlertBox('Password do not match! Try again.');
                  }
                  ?>

                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputPassword" name="newpassword" type="password" placeholder="Password" required >
                  </div><!-- .form-group -->

                  <div class="form-group">
                    <input class="form-control form-control-user" id="inputRetypePassword" name="Confirmpassword" type="password" placeholder="Password" required>
                  </div><!-- .form-group -->

                  <div class="form-group form-check small">
                    <input class="form-check-input" id="inputShowPassword" type="checkbox">
                    <label class="form-check-label" for="inputShowPassword">Show Password</label>
                  </div><!-- .form-group -->

                  <?php ShowPassword('inputShowPassword', 'inputPassword', 'inputRetypePassword'); ?>

                  <input type="submit" class="btn btn-primary btn-lg btn-block" name="activate" value="Activate">
                </form>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="layoutAuthentication_footer">
      <?php include_once('../../_includes_/layout/footer.php'); ?>
    </div>
  </div>
</body>

</html>