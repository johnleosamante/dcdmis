<?php
include_once('../_includes_/function.php');

$page = 'SDO Dipolog DB';

include_once('../_includes_/layout/header.php');
include_once('../_includes_/layout/components.php');
include_once('../_includes_/string.php');
?>

<link href="<?php echo GetSiteURL(); ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo GetSiteURL(); ?>/assets/vendor/jquery/jquery.min.js"></script>
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card my-4">
                <div class="card-header">
                  <h3 class="mb-0">SDO Dipolog DB</h3>
                </div>
                <div class="card-body">
                  <?php
                  $con = mysqli_connect('localhost', 'root', 'dcdmis@2022', 'sdodipologdb');

                  $query = mysqli_query($con, "SELECT * FROM vpersonal  WHERE id<>'1' ORDER BY lastname, firstname, middlename;");

                  if (mysqli_num_rows($query) > 0) {
                  ?>
                    <div class="table-responsive">
                      <table id="dataTable" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                        <thead>
                          <tr class="text-center align-middle">
                            <th width="100px">Photo</th>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Date Of Birth</th>
                            <th>Sex</th>
                            <th>Download</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                              <td>
                                <img width="100%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>">
                              </td>
                              <td class="text-center align-middle"><?php echo $row['id']; ?></td>
                              <td class="text-center align-middle"><?php echo ToName($row['lastname'], $row['firstname'], $row['middlename'], $row['extension'], false, true); ?></td>
                              <td class="text-center align-middle"><?php echo $row['dob']; ?></td>
                              <td class="text-center align-middle"><?php echo strtolower($row['sex']) === '1' ? 'Female' : 'Male'; ?></td>
                              <td class="text-center align-middle"><a href="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" download="<?php echo strtoupper(ToName($row['lastname'], $row['firstname'], $row['middlename'], $row['extension'], false, true)) . '-' . $row['id'] . '.' . $row['ext']; ?>"><i class="fas fa-download fa-fw"></i>Download</a></td>
                            </tr>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                    </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

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