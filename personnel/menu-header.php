<?php
# personnel/header-menu.php

// PERSONAL DATA SHEET PROGRESS BAR
$pds_progress = 0;

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_employee WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 15;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM work_experience WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_special_skills WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_recognition WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_membership WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_other_information WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
  $pds_progress += 5;
}

$users = DBQuery("SELECT * FROM tbl_employee WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
$user = DBFetchAssoc($users);
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <div class="d-none d-xl-inline-block mr-auto my-2 my-md-0 mw-100">
    <h1 class="h4 m-0 text-uppercase"><?php echo $row['SchoolName']; ?></h1>
    <div class="small m-0 text-uppercase"><?php echo GetRegionAlias() . ' / ' . GetDivision() . ' / ' . $row['Address']; ?></div>
  </div>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="completionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-tasks fa-fw"></i>
      </a>

      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="completionDropdown">
        <h6 class="dropdown-header bg-dark border-dark">
          Personal Data Sheet
        </h6>

        <a class="dropdown-item py-3" href="<?php echo GetHashURL('personnel', 'Personal Data Sheet'); ?>">
          <div class="font-weight-bold text-left pb-1">
            <?php echo "$pds_progress% Complete"; ?>
          </div>

          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $pds_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $pds_progress; ?>%;">
              <span class="sr-only"><?php echo $pds_progress; ?>% Complete</span>
            </div>
          </div>
        </a>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          <?php echo $_SESSION['TeacherName'] = ToName($user['Emp_LName'], $user['Emp_FName'], $user['Emp_MName'], $user['Emp_Extension'], true); ?>
        </span>

        <img class="img-profile rounded-circle" src="<?php echo GetSiteURL() . '/' . $_SESSION['Picture']; ?>">
      </a>

      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<?php echo GetHashURL('personnel', 'Settings'); ?>">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav><!-- .navbar -->