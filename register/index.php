<?php
# register/index.php

include_once('../_includes_/function.php');

if (isset($_SESSION['uid'])) {
  header('location:' . GetHashURL($_SESSION['portal'], 'dashboard'));
}

$page = 'Data Privacy Policy Agreement';

foreach ($_GET as $key => $data) {
  $link = $_GET[$key] = GetDecoding($data);
  $page = $link;
}

include_once('../_includes_/layout/header.php');
include_once('../_includes_/layout/components.php');
?>
</head>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="row justify-content-center">
        <?php
        if (isset($link) && $link === 'Register Account') {
          include_once('register.php');
        } else {
          include_once('agreement.php');
        }
        ?>
      </div>
    </div>

    <div id="layoutAuthentication_footer">
      <?php include_once('../_includes_/layout/footer.php'); ?>
    </div>
  </div>
</body>

</html>