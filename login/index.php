<?php
# login/index.php

include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');
include_once('../_includes_/layout/components.php');

if (isset($_SESSION['uid'])) {
  header('location:' . GetHashURL($_SESSION['portal'], 'dashboard'));
}

// $school_year = DBQuery("SELECT * FROM tbl_school_year_assign LIMIT 1");
// $rowschoolyear = DBFetchAssoc($school_year);
// $_SESSION['Sem'] = $rowschoolyear['Semester'];
// $_SESSION['sy'] = $rowschoolyear['SchoolYear'] . "-" . $rowschoolyear['SchoolYear'] + 1;
// $_SESSION['year'] = $rowschoolyear['SchoolYear'];
// $_SESSION['Quarter'] = $rowschoolyear['SchoolQuarter'];

DBNonQuery("UPDATE tbl_number_of_visitors SET No_of_visitors = No_of_visitors + 1 LIMIT 1");

$Err = false;

if (isset($_POST['login'])) {
  $dateposted = GetDateTime();
  $pass = GetHashPassword(DBRealEscapeString($_POST['password']));
  $userinfo = DBRealEscapeString($_POST['emailadd']);
  $sql = DBQuery("SELECT * FROM tbl_user WHERE username ='$userinfo' AND `password`='$pass' LIMIT 1;");

  if (DBNumRows($sql) === 1) {
    $rec = DBFetchAssoc($sql);

    if ($rec['Status'] === 'Default') {
      $_SESSION['activate_uid'] = $rec['usercode'];
      $_SESSION['activate_email'] = $rec['username'];

      header('location:' . GetSiteURL() . '/activate');
    } else {
      $_SESSION['email'] = $rec['username'];
      $_SESSION['station'] = $rec['Station'];
      $_SESSION['uid'] = $rec['usercode'];
      $_SESSION['ucode'] = $rec['position'];
      $_SESSION['school_id'] = $rec['Station'];
      $_SESSION['portal'] = $rec['Link'];
      $_SESSION['last_login_timestamp'] = time();
      setcookie('administrator_email', $userinfo, time() + 60 * 60 * 7);
      DBNonQuery("UPDATE tbl_user SET Last_login='$dateposted', Current_Status='Online' WHERE usercode='" . $_SESSION['uid'] . "' LIMIT 1;");

      $query = DBQuery("SELECT * FROM tbl_data_privacy_aggrement WHERE Emp_ID='" . $_SESSION['uid'] . "';");

      if (DBNumRows($query) == 0) {
        DBNonQuery("INSERT INTO tbl_data_privacy_aggrement (date_time_aggreement, Emp_ID, Type_of_aggrement, IPAddressess) VALUES ('$dateposted', '" . $_SESSION['uid'] . "', 'Login', '$IP');");
      }

      DBNonQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('" . $_SESSION['school_id'] . "', '" . $_SESSION['uid'] . "', '$dateposted', 'Login', '$IP');");
      header('location:' . GetHashURL($rec['Link'], 'dashboard'));
    }
  } else {
    $Err = true;
  }
}

$page = 'Administrator Login';

include_once('../_includes_/layout/header.php');
?>
</head>
<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="row justify-content-center">
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