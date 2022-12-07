<?php
include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');

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

$dateposted = GetDateTime();

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

$image = '';
if ($row['SchoolLogo'] === NULL) {
  $image = '../assets/img/logo.png';
} else {
  $image = '../' . $row['SchoolLogo'];
}
?>

<link href="<?php echo GetSiteURL(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include_once('sidebar-menu.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include_once('header-menu.php'); ?>

        <div class="container-fluid">
          <?php
          if (!isset($link)) {
            include("dashboard.php");
          } else {
            if ($link == 'Service Record') {
              include("service-record.php");
            } elseif ($link == 'Personal Data Sheet') {
              include("pds.php");
            } elseif ($link == 'Daily Time Record') {
              include("my_dtr.php");
            } elseif ($link == 'Locator') {
              include("locator.php");
            } elseif ($link == 'Payslip') {
              include("payslip.php");
            } elseif ($link == 'Request for Transfer') {
              include("request_for_transfer.php");
            } elseif ($link == 'DepEd Account Request') {
              include("request_for_deped_account.php");
            } elseif ($link == 'IPCRF') {
              include("individual_ipcrf.php");
            } elseif ($link == '201 File') {
              include("view_201_file.php");
            } elseif ($link === 'Certificates') {
              include("certificate.php");
            } elseif ($link == 'Trainings') {
              include("training.php");
            } elseif ($link == 'Settings') {
              include("setting.php");
            } elseif ($link == 'erf') {
              include("erf_kios.php");
            } elseif ($link == 'leave') {
              include("request_for_leave.php");
            } elseif ($link == 'quatame') {
              include("quatame.php");
            } elseif ($link == 'psipop') {
              include("psipop.php");
            } elseif ($link == 'class_record') {
              include("class_records.php");
            } elseif ($link == 'class_list') {
              include("require/class_list.php");
            } elseif ($link == 'written_work_activity') {
              include("require/written_work_activity.php");
            } elseif ($link == 'Class Advisory') {
              include("require/class_advisory.php");
            } elseif ($link == 'profile') {
              include("require/profile.php");
            } elseif ($link == 'subject') {
              include("require/subject.php");
            } elseif ($link == 'form9') {
              include("require/form9.php");
            } elseif ($link == 'form10') {
              include("require/form10.php");
            } elseif ($link == 'gradesheet') {
              include("require/gradesheet.php");
            } elseif ($link == 'view_answer') {
              include("require/view_answer.php");
            } elseif ($link == 'summary_report') {
              include("require/summary_report.php");
            } elseif ($link == 'written_work_set_work') {
              include("require/written_work_set_work.php");
            } elseif ($link == 'modality') {
              include("require/modality.php");
            } elseif ($link == 'view_score') {
              include("require/view_score.php");
            } elseif ($link == 'search_data') {
              include("enrolment/search-lrn.php");
            } elseif ($link == 'search_learner') {
              include("enrolment/search-data.php");
            } elseif ($link == 'data_entry') {
              include("enrolment/data-entry.php");
            } elseif ($link == 'education_history') {
              include("enrolment/education_history.php");
            } elseif ($link == 'enrolment') {
              include("enrolment/enrollment.php");
            } elseif ($link == 'addreadingmaterial') {
              include("addreadingmaterial.php");
            } elseif ($link == 'myoptionimage') {
              include("myoptionimage.php");
            } elseif ($link == 'senior_set_activity') {
              include("require/senior_set_activity.php");
            } elseif ($link == 'video_materials') {
              include("require/video_materials.php");
            } elseif ($link == 'view_activity') {
              include("view_activity.php");
            } elseif ($link == 'Step Increment Application') {
              include("application_form_for_steps.php");
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
</body>

</html>