<?php include_once('login-inc.php'); ?>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div id="login_page" class="row justify-content-center">
        <div class="col-lg-8">
          <?php include_once('online-services.php'); ?>
        </div>

        <div class="col-lg-4">
          <?php include_once('login-form.php'); ?>
        </div>
      </div>
    </div>

    <div id="layoutAuthentication_footer">
      <?php include_once('../_includes_/layout/footer.php'); ?>
    </div>
  </div>
</body>

</html>