<?php
# _includes_/layout/error.php

include_once('../_includes_/function.php');
$code = http_response_code();
$error = '';

switch ($code) {
  case '400':
    $error = 'Bad Request';
    break;
  case '401':
    $error = 'Unauthorized Access';
    break;
  case '403':
    $error = 'Forbidden Access';
    break;
  case '404':
    $error = 'Page Not Found';
    break;
  case '408':
    $error = 'Request Timed Out';
    break;
  case '500':
    $error = 'Internal Server Error';
    break;
  default:
    $error = 'Ooops!';
}

$page = $error;
include_once('../_includes_/layout/header.php');
?>

<link href="<?php echo GetSiteURL(); ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="d-flex justify-content-center align-items-center">
      <div class="row">
        <div class="text-center">
          <h1 class="error mx-auto" data-text="<?php echo $code; ?>"><?php echo $code; ?></h1>
          <p class="lead text-gray-800 mb-4"><?php echo $error; ?></p>
          <p class="text-gray-500 mb-0 px-3">An error has been encountered.</p>
          <p class="text-gray-500 mb-3 px-3">Please go back to the home page instead.</p>
          <a class="btn btn-primary rounded" href="<?php echo GetSiteURL(); ?>" title="Go to DepEd Dipolog City Data Management System Home Page">Home</a>
        </div><!-- .text-center -->
      </div><!-- .row -->
    </div><!-- #layoutAuthentication_content -->

    <div id="layoutAuthentication_footer">
      <?php include_once('../_includes_/layout/footer.php'); ?>
    </div><!-- #layoutAuthenticaton_footer -->
  </div><!-- #layoutAuthentication -->
</body>

</html>