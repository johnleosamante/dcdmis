<?php
# personnel/login/index.php

include_once('../../_includes_/function.php');
include_once('../../_includes_/database/database.php');
include_once('../../_includes_/layout/components.php');

if (isset($_SESSION['activate_puid'])) {
  header('location:' . GetSiteURL() . '/personnel/activate');
}

if (isset($_SESSION['EmpID'])) {
  header('location:' . GetSiteURL() . '/personnel');
}

$school_year = DBQuery("SELECT * FROM tbl_school_year_assign;");
$rowschoolyear = DBFetchAssoc($school_year);
$_SESSION['Sem'] = $rowschoolyear['Semester'];
$_SESSION['sy'] = $rowschoolyear['SchoolYear'] . "-" . $rowschoolyear['SchoolYear'] + 1;
$_SESSION['year'] = $rowschoolyear['SchoolYear'];
$_SESSION['Quarter'] = $rowschoolyear['SchoolQuarter'];

DBNonQuery("UPDATE tbl_number_of_visitors SET No_of_visitors = No_of_visitors + 1 LIMIT 1;");

$Err = false;

if (isset($_POST['login'])) {
  $dateposted = GetDateTime();
  $pass = GetHashPassword(DBRealEscapeString($_POST['password']));
  $userinfo = DBRealEscapeString($_POST['emailadd']);
  $sql = DBQuery("SELECT * FROM tbl_teacher_account INNER JOIN tbl_employee ON tbl_teacher_account.Teacher_TIN = tbl_employee.Emp_Email WHERE tbl_teacher_account.Teacher_TIN ='$userinfo' AND tbl_teacher_account.Teacher_Password='$pass' LIMIT 1;");

  if (DBNumRows($sql) === 1) {
    $rec = DBFetchAssoc($sql);

    if ($rec['Pass_status'] == 'Default') {
      $_SESSION['activate_puid'] = $rec['Emp_ID'];
      $_SESSION['activate_pemail'] = $rec['Teacher_TIN'];

      header('location:' . GetSiteURL() . '/personnel/activate');
    } else {
      $_SESSION['Email'] = $rec['Teacher_TIN'];
      $_SESSION['EmpID'] = $rec['Emp_ID'];
      $_SESSION['Picture'] = $rec['Picture'];
      $_SESSION['last_login_timestamp'] = time();

      DBNonQuery("UPDATE tbl_teacher_account SET Last_login='$dateposted',Teacher_status='Online' WHERE Teacher_TIN='" . $_SESSION['Email'] . "' LIMIT 1;");

      header('location:' . GetSiteURL() . '/personnel');
    }
  } else {
    $Err = true;
  }
}

$page = 'Personnel Login';

include_once('../../_includes_/layout/header.php');
?>

<link href="<?php echo GetSiteURL(); ?>/assets/css/custom.css" rel="stylesheet">
<script src="<?php echo GetSiteURL(); ?>/assets/vendor/jquery/jquery.min.js"></script>
</head>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="row">
        <div class="col-lg-8">
          <?php include_once('../../login/online-services.php'); ?>
        </div>

        <div class="col-lg-4">
          <?php include_once('login-form-personnel.php'); ?>
        </div>
      </div>
    </div>

    <div id="layoutAuthentication_footer">
      <?php include_once('../../_includes_/layout/footer.php'); ?>
    </div>
  </div>
</body>

</html>