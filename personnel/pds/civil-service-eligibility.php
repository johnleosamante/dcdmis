<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'eligibility'); ?>" id="eligibility">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Civil Service Eligibility</h3>
    <a href="#AddEligibilityModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-2" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="25%" rowspan="2">Career Services / RA 1080 (BOARD / BAR) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
            <th class="align-middle" width="15%" rowspan="2">Rating (if Applicable)</th>
            <th class="align-middle" width="15%" rowspan="2">Date of Examinition Conferment</th>
            <th class="align-middle" width="15%" rowspan="2">Place of Examination / Conferment</th>
            <th class="align-middle" width="20%" colspan="2">License (if Applicable)</th>
            <th class="align-middle" rowspan="2" width="10%">Action</th>
          </tr>
          <tr class="text-center">
            <th class="align-middle">Number</th>
            <th class="align-middle">Date of Validity</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $eligibility = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($eligibility) > 0) {
            while ($row3 = mysqli_fetch_array($eligibility)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row3['Carrer_Service']; ?></td>
                <td class="text-center align-middle"><?php echo $row3['Rating']; ?></td>
                <td class="text-center align-middle"><?php echo $row3['Date_of_Examination']; ?></td>
                <td class="text-center align-middle"><?php echo $row3['Place_of_Examination']; ?></td>
                <td class="text-center align-middle"><?php echo $row3['Number_of_Hour']; ?></td>
                <td class="text-center align-middle"><?php echo $row3['Date_of_Validity']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="my_license.php?id=<?php echo urlencode(base64_encode($row3['No'])); ?>" data-toggle="modal" data-target="#UpdateEligibilityModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_service(this.id)" id="<?php echo $row3['No']; ?>" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="7">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <script>
        function delete_service(id) {
          if (confirm("Are you sure you want to deleted this row?")) {

            window.location.href = 'delete_service.php?id=' + id;
          }
        }
      </script>
    </div>
  </div>

  <div class="modal fade" id="AddEligibilityModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Civil Service Eligibility</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="Carrer" class="mb-0">Career Service / RA 1080 (Board/Bar) / Underspecial Laws / CES / CSEE / Barangay Eligibility / Drivers License</label>
              <input id="Carrer" type="text" name="Carrer" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="rating" class="mb-0">Rating <br>(if applicable)</label>
                  <input id="rating" type="text" name="rating" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="date_exam" class="mb-0">Date of Examination / Conferment</label>
                  <input id="date_exam" type="date" name="date_exam" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Place" class="mb-0">Place of Examination / Conferment</label>
              <input id="Place" type="text" name="Place" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label for="license_number" class="mb-0">License No. (if applicable)</label>
                  <input id="license_number" type="text" name="license_number" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label for="year" class="mb-0">Date of Validity (if applicable)</label>
                  <input id="year" type="date" name="year" class="form-control" required>
                </div>
              </div>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddEligibility">Save</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->

  <div class="modal fade" id="UpdateEligibilityModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->