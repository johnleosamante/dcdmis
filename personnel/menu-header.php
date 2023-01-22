<?php
# personnel/header-menu.php
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <div class="d-none d-xl-inline-block mr-auto my-2 my-md-0 mw-100">
    <h1 class="h4 m-0 text-uppercase"><?php echo $row['SchoolName']; ?></h1>
    <div class="small m-0 text-uppercase"><?php echo GetRegionAlias() . ' / ' . GetDivision() . ' / ' . $row['Address']; ?></div>
  </div>

  <?php
  $result = DBQuery("SELECT * FROM tbl_deployment_history WHERE tbl_deployment_history.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

  if (DBNumRows($result) <> 0) {
    $getRow = DBFetchAssoc($result);
    $myyear = date('Y') - mb_strimwidth($getRow['Date_assignment'], 0, 4);

    DBQuery("UPDATE tbl_deployment_history SET tbl_deployment_history.No_of_years ='" . $myyear . "' WHERE tbl_deployment_history.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

    if ($myyear >= 3) {
      $qeduc = DBQuery("SELECT * FROM educational_background WHERE educational_background.Emp_ID ='" . $_SESSION['EmpID'] . "' AND educational_background.Level='Masteral'");
      $data = DBFetchAssoc($qeduc);

      if (DBNumRows($qeduc) <> 0) {
        if ($data['Highest_Level'] == 'GRADUATED') {
          $res = DBQuery("SELECT * FROM tbl_messages WHERE Message_to='" . $_SESSION['EmpID'] . "'");
          $mydate = DBFetchAssoc($res);
          $myoption = mb_strimwidth($mydate['Message_date'], 0, 4);

          if ($myoption <> date("Y")) {
            DBQuery("INSERT INTO tbl_messages VALUES(NULL,'HRMO','" . $_SESSION['EmpID'] . "','" . 'You are qualified for ERF' . "','" . date('Y-m-d') . "','Unread','ERF')");
          }
        }
      }
    }
  }

  // $get_step = DBQuery("SELECT * FROM tbl_step_increment WHERE tbl_step_increment.Emp_ID='" . $_SESSION['EmpID'] . "'");

  // if (DBNumRows($get_step) <> 0) {
  //   $get_data = DBFetchAssoc($get_step);
  //   $mystep = $get_data['Step_No'];
  //   $mystep++;

  //   if (DBNumRows($get_step) <> 0) {
  //     $mylenght = date('Y') - $get_data['Date_last_step'];

  //     DBNonQuery("UPDATE tbl_step_increment SET tbl_step_increment.No_of_year ='" . $mylenght . "' WHERE tbl_step_increment.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

  //     if ($mylenght >= 3) {
  //       $dquery = DBQuery("SELECT * FROM tbl_messages WHERE Message_to='" . $_SESSION['EmpID'] . "' AND Message_date='" . date('Y-m-d') . "'");
  //       $getdata = DBFetchAssoc($dquery);
  //       $gdata = mb_strimwidth($getdata['Message_date'], 0, 4);

  //       if ($gdata <> date('Y')) {
  //         DBQuery($con, "INSERT INTO tbl_messages VALUES(NULL,'HRMO','" . $_SESSION['EmpID'] . "','" . 'You are qualified for Step ' . $mystep . "','" . date('Y-m-d') . "','Unread','Steps')");
  //       }
  //     }
  //   }
  // }

  $myname = DBQuery("SELECT * FROM tbl_employee WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
  $rowdata = DBFetchAssoc($myname);
  ?>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="completionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-tasks fa-fw"></i>
      </a>

      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="completionDropdown">
        <?php
        $total = $fam = $educ = $civil = $work = $volun = $learn = $other = $ref = 0;

        $family_data = DBQuery("SELECT * FROM family_background WHERE family_background.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (DBNumRows($family_data) <> 0) {
          $fam = 10;
        }

        $educ_data = DBQuery("SELECT * FROM educational_background WHERE educational_background.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($educ_data) <> 0) {
          $educ = 15;
        }

        $civil_data = DBQuery("SELECT * FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($civil_data) <> 0) {
          $civil = 15;
        }

        $work_data = DBQuery("SELECT * FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($work_data) <> 0) {
          $work = 5;
        }

        $voluntary_data = DBQuery("SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($voluntary_data) <> 0) {
          $volun = 5;
        }
        $learning_data = DBQuery("SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($learning_data) <> 0) {
          $learn = 20;
        }

        $other_data = DBQuery("SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (mysqli_num_rows($other_data) <> 0) {
          $other = 10;
        }

        $reference_data = DBQuery("SELECT * FROM reference WHERE reference.Emp_ID='" . $_SESSION['EmpID'] . "'");

        if (DBNumRows($reference_data) <> 0) {
          $ref = 20;
        }

        $total = $fam + $educ + $civil + $work + $volun + $learn + $other + $ref;
        ?>

        <h6 class="dropdown-header bg-dark border-dark">
          Personal Data Sheet
        </h6>

        <div class="dropdown-item py-3">
          <div class="font-weight-bold text-left pb-1">
            <?php echo "$total% Complete"; ?>
          </div>

          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $total; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $total; ?>%;">
              <span class="sr-only"><?php echo $total; ?>% Complete</span>
            </div>
          </div>
        </div>
      </div>
    </li>

    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <?php
        $mymemo = DBQuery("SELECT * FROM tbl_messages WHERE Message_to='" . $_SESSION['EmpID'] . "'  AND  Message_status ='Unread' LIMIT 5");

        if (DBNumRows($mymemo) <> 0) {
        ?>
          <span class="badge badge-danger badge-counter"><?php echo DBNumRows($mymemo); ?></span>
        <?php
        }
        ?>
      </a>

      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <?php
        $query_messages = DBQuery("SELECT * FROM tbl_messages WHERE Message_to='" . $_SESSION['EmpID'] . "' AND  Message_status ='Unread' ORDER BY Message_status Desc LIMIT 5");
        ?>

        <h6 class="dropdown-header bg-dark border-dark">Notifications</h6>

        <?php while ($rmessages = DBFetchArray($query_messages)) : ?>
          <a class="dropdown-item d-flex align-items-center px-3 py-2" href="#<?php //echo GetHashURL('personnel', 'Step Increment Application', $rmessages['No']); 
                                                                              ?>">
            <div class="mr-2">
              <div class="icon-circle bg-info"><i class="fas fa-donate text-white"></i></div>
            </div>

            <div class="font-weight-bold">
              <div class="font-weight-bold text-truncate"><?php echo $rmessages['Message_details']; ?></div>

              <div class="small text-gray-500"><?php echo $rmessages['Message_from'] . ' &middot; ' . $rmessages['Message_date']; ?></div>
            </div>
          </a>
        <?php endwhile; ?>
      </div><!-- .dropdown-menu -->
    </li><!-- .nav-item -->

    <div class="topbar-divider d-none d-sm-block"></div>

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          <?php echo $_SESSION['TeacherName'] = ToName($rowdata['Emp_LName'], $rowdata['Emp_FName'], $rowdata['Emp_MName'], $rowdata['Emp_Extension'], true); ?>
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