<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'eligibility'); ?>" id="eligibility">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Civil Service Eligibility</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-eligibility.php?id=')" data-toggle="modal" data-target="#Modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="25%" rowspan="2">Career Services / RA 1080 (Board / Bar) Underspecial Laws / CES / CSEE Barangay Eligibility/ Drivers License</th>
            <th class="align-middle" width="10%" rowspan="2">Rating</th>
            <th class="align-middle" width="10%" rowspan="2">Date of Examination / Conferment</th>
            <th class="align-middle" width="25%" rowspan="2">Place of Examination / Conferment</th>
            <th class="align-middle" width="20%" colspan="2">License</th>
            <th class="align-middle" rowspan="2" width="10%">Action</th>
          </tr>
          <tr class="text-center">
            <th class="align-middle" width="10%">Number</th>
            <th class="align-middle" width="10%">Date of Validity</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $eligibilities = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY Date_of_Examination DESC;");

          if (mysqli_num_rows($eligibilities) > 0) {
            while ($eligibility = mysqli_fetch_array($eligibilities)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $eligibility['Carrer_Service']; ?></td>
                <td class="text-center align-middle"><?php echo $eligibility['Rating']; ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($eligibility['Date_of_Examination']); ?></td>
                <td class="text-center align-middle"><?php echo $eligibility['Place_of_Examination']; ?></td>
                <td class="text-center align-middle"><?php echo $eligibility['Number_of_Hour']; ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($eligibility['Date_of_Validity']); ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-eligibility.php?id=<?php echo $eligibility['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-eligibility.php?id=<?php echo $eligibility['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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
    </div>
  </div>
</div><!-- .tab-pane -->