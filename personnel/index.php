<?php
# personnel/index.php

include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');
include_once('../_includes_/string.php');

if ($_SESSION['EmpID'] == "") {
  header('location:' . GetSiteURL() . '/personnel/login');
} else {
  if ((time() - $_SESSION['last_login_timestamp']) > 14400) {
    header('location:' . GetSiteURL() . '/personnel/logout');
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }
}

$page = '';

foreach ($_GET as $key => $data) {
  $link = $_GET[$key] = GetDecoding($data);
  $page = $link;
}

include_once('../_includes_/string.php');
include_once('../_includes_/layout/header.php');
include_once('../_includes_/layout/components.php');

$result = DBQuery("SELECT * FROM tbl_employee INNER JOIN tbl_station  ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='" . $_SESSION['EmpID'] . "' LIMIT 1;");
$row = DBFetchAssoc($result);
$_SESSION['SchoolID'] = $row['SchoolID'];
$_SESSION['Category'] = $row['School_Category'];
$_SESSION['Job-Cat'] = $row['Job_Category'];
$_SESSION['Station'] = $row['Abraviate'];
$mydistrict = DBQuery("SELECT * FROM tbl_district WHERE District_code='" . $row['District_code'] . "' LIMIT 1");
$rowdistrict = DBFetchAssoc($mydistrict);
$_SESSION['SchoolName']  = $row['SchoolName'];
$_SESSION['SchoolAddress']  = $row['Address'];
$_SESSION['schoolLogo']  = '../' . $row['SchoolLogo'];

$image = ($row['SchoolLogo'] === NULL) ? '../assets/img/logo.png' : '../' . $row['SchoolLogo'];
?>

<link href="<?php echo GetSiteURL(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include_once('menu-sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include_once('menu-header.php'); ?>

        <div class="container-fluid">
          <?php
          if (!isset($link)) {
            include("dashboard.php");
          } else {
            if ($link === 'Certificates') {
              include("certificate.php");
            } elseif ($link === 'Payslip') {
              include("payslip.php");
            } elseif ($link === 'Trainings') {
              include("training.php");
            } elseif ($link === 'Step Increment Application') {
              include("step-increment-application.php");
            } elseif ($link === 'Settings') {
              include("settings/index.php");
            } elseif ($link === 'Daily Time Record') {
              include("dtr.php");
            } elseif ($link === 'Service Record') {
              include("service-record.php");
            } elseif ($link === 'Personal Data Sheet') {
              include("pds/index.php");
            } elseif ($link === 'Locator') {
              include("locator/index.php");
            } elseif ($link === 'Transfer Request') {
              include("transfer-request.php");
            } elseif ($link === 'DepEd Account Request') {
              include("deped-account-request.php");
            } elseif ($link === 'IPCRF') {
              include("ipcrf.php");
            } elseif ($link === '201 File') {
              include("201-file.php");
            } else {
              include('dashboard.php');
            }
          }
          ?>
        </div>
      </div><!-- #content -->

      <?php include_once('../_includes_/layout/footer.php'); ?>
    </div><!-- #content-wrapper -->
  </div><!-- #wrapper -->

  <?php
  ScrollToTop();
  ModalConfirm('Select "Logout" below if you are ready to end your current session.', 'Logout', 'logoutModal', 'ModalLabel', 'Logout', GetSiteURL() . '/personnel/logout');
  ?>

  <script src="<?php echo GetSiteURL(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo GetSiteURL(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo GetSiteURL(); ?>/assets/js/sb-admin-2.min.js"></script>
  <script src="<?php echo GetSiteURL(); ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo GetSiteURL(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo GetSiteURL(); ?>/assets/js/demo/datatables-demo.js"></script>
  <script>
    if (window.history.replaceState) window.history.replaceState(null, null, window.location.href);

    function viewdata(id, href) {
      xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById(id).innerHTML = xmlhttp.responseText;
        }
      }

      xmlhttp.open("GET", href, false);
      xmlhttp.send();
    }
  </script>
</body>

</html>