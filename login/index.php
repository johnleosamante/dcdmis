<?php
include_once('../_includes_/function.php');

if (isset($_SESSION[GetSiteAlias() . '_uid'])) {
  header('location:' . GetHashURL($_SESSION[GetSiteAlias() . '_portal'], 'dashboard'));
}

include_once('../_includes_/database/database.php');
include_once('../_includes_/layout/components.php');

$hasError = false;

if (isset($_POST['login'])) {
  $dateposted = GetDateTime();
  $password = GetHashPassword(DBRealEscapeString($_POST['password']));
  $username = DBRealEscapeString($_POST['emailadd']);
  $users = DBQuery("SELECT * FROM tbl_user WHERE username ='$username' AND `password`='$password' LIMIT 1;");

  if (DBNumRows($users) === 1) {
    $user = DBFetchAssoc($users);

    if ($user['Status'] === 'Default') {
      $_SESSION[GetSiteAlias() . '_activate_uid'] = $user['usercode'];
      $_SESSION[GetSiteAlias() . '_activate_email'] = $user['username'];

      header('location:' . GetSiteURL() . '/activate');
    } else {
      $_SESSION[GetSiteAlias() . '_email'] = $user['username'];
      $_SESSION[GetSiteAlias() . '_station'] = $user['Station'];
      $_SESSION[GetSiteAlias() . '_uid'] = $user['usercode'];
      $_SESSION[GetSiteAlias() . '_ucode'] = $user['position'];
      $_SESSION[GetSiteAlias() . '_school_id'] = $user['Station'];
      $_SESSION[GetSiteAlias() . '_portal'] = $user['Link'];
      $_SESSION[GetSiteAlias() . '_last_login_timestamp'] = time();

      include_once('../_includes_/database/user.php');
      UserLogin($_SESSION[GetSiteAlias() . '_uid'], $dateposted);

      $query = DBQuery("SELECT * FROM tbl_data_privacy_aggrement WHERE Emp_ID='" . $_SESSION['uid'] . "';");

      if (DBNumRows($query) == 0) {
        DBNonQuery("INSERT INTO tbl_data_privacy_aggrement (date_time_aggreement, Emp_ID, Type_of_aggrement, IPAddressess) VALUES ('$dateposted', '" . $_SESSION['uid'] . "', 'Login', '" . GetClientIP() . "');");
      }

      DBNonQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('" . $_SESSION[GetSiteAlias() . '_school_id'] . "', '" . $_SESSION['uid'] . "', '$dateposted', 'Login', '" . GetClientIP() . "');");
      setcookie('administrator_email', $userinfo, time() + 60 * 60 * 24 * 3);
      header('location:' . GetHashURL($_SESSION[GetSiteAlias() . '_portal'], 'dashboard'));
    }
  } else {
    $hasError = true;
  }
}

$page = 'Administrator Login';

include_once('../_includes_/layout/header.php');
?>
</head>

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