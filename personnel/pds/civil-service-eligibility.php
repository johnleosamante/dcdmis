<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'eligibility'); ?>" id="eligibility">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Civil Service Eligibility</h3>
    <a href="#AddEligibility" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-2" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="25%" rowspan="2">Career Services / RA 1080 (BOARD / BAR) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
            <th class="align-middle" width="15%" rowspan="2">Rating (if Applicable)</th>
            <th class="align-middle" width="15%" rowspan="2">Date of Examinition Conferment</th>
            <th class="align-middle" width="15%" rowspan="2">Place of Examinition / Conferment</th>
            <th class="align-middle" width="20%" colspan="2">License(if Applicable)</th>
            <th class="align-middle" colspan="2" width="10%">Action</th>
          </tr>
          <tr class="text-center">
            <th class="align-middle">Number</th>
            <th class="align-middle">Date of Validity</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result3 = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
          while ($row3 = mysqli_fetch_array($result3)) {
            echo '<tr>
												<td style="text-align:center;">' . $row3['Carrer_Service'] . '</td>
												<td style="text-align:center;">' . $row3['Rating'] . '</td>
												<td style="text-align:center;">' . $row3['Date_of_Examination'] . '</td>
												<td style="text-align:center;">' . $row3['Place_of_Examination'] . '</td>
												<td style="text-align:center;">' . $row3['Number_of_Hour'] . '</td>
												<td style="text-align:center;">' . $row3['Date_of_Validity'] . '</td>
											
												<td style="text-align:center;">
													<a href="my_license.php?id=' . urlencode(base64_encode($row3['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
													<a style="cursor:pointer;" onclick="delete_service(this.id)" id="' . $row3['No'] . '">Remove</a>
																
													  </td>
											
											</tr>';
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function delete_service(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_service.php?id=' + id;
    }
  }
</script>

<!-- Modal for Civil SERVICE-->
<div class="modal fade" id="AddEligibility" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">IV. CIVIL SERVICE ELIGIBILITY </h4>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group">
            <div style="overflow-x:auto;">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th rowspan="2" style="text-align:center;">CAREER SERVICES / RA 1080 (BOARD / BAR)<br /> UNDERSPECIAL LAWS / CES / CSEE <br />BARANGAY ELIGIBILITY/ DRIVERS LICENSE</th>
                  <th rowspan="2" style="text-align:center;">RATING <br />(if Applicable)</th>
                  <th rowspan="2" style="text-align:center;">DATE OF EXAMINATION <br /> CONFERMENT</th>
                  <th rowspan="2" style="text-align:center;">PLACE OF EXAMINATION / CONFERMENT</th>
                  <th colspan="2" style="text-align:center;">LICENSE(if Applicable)</th>
                </tr>
                <tr>
                  <th style="text-align:center;">NUMBER</th>
                  <th style="text-align:center;">Date of Validity</th>
                </tr>
                <tr>
                  <th><input type="text" name="Carrer" class="form-control" required></th>
                  <th><input type="text" name="rating" class="form-control" required></th>
                  <th><input type="date" name="date_exam" class="form-control" required></th>
                  <th><input type="text" name="Place" class="form-control" required></th>
                  <th><input type="text" name="license_number" class="form-control" required></th>
                  <th><input type="date" name="year" class="form-control" required></th>

                </tr>
              </table>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="save_CS" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="mylicense" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->