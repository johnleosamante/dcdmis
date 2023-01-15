<div class="table-responsive tab-pane fade<?php echo SetActiveNavigationTab(!isset($_SESSION['settingstab']) || $_SESSION['settingstab'] === 'user-information'); ?>" id="user-information">
  <table>
    <?php
    $myname = DBQuery("SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =  tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID WHERE tbl_employee.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

    $row_record = DBFetchAssoc($myname);

    $empPosition = $row_record['Job_code'];
    ?>

    <tr class="border-bottom">
      <th class="py-2">Full Name:</th>
      <td class="py-2 px-3"><?php echo ToName($row_record['Emp_LName'], $row_record['Emp_FName'], $row_record['Emp_MName'], $row_record['Emp_Extension'], false, true); ?></td>
    </tr>

    <tr class="border-bottom">
      <th class="py-2">Position:</th>
      <td class="py-2 px-3"><?php echo $row_record['Job_description']; ?></td>
      <td class="py-2 px-3"><span class="small"><a class="text-decoration-none" href="#positionModal" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></span></td>
    </tr>

    <tr class="border-bottom">
      <th class="py-2">Station:</th>
      <td class="py-2 px-3"><?php echo $row_record['SchoolName']; ?></td>
    </tr>

    <tr class="border-bottom">
      <th class="py-2">Address:</th>
      <td class="py-2 px-3"><?php echo $row_record['Emp_Address']; ?></td>
    </tr>

    <tr class="border-bottom">
      <th class="py-2">Contact Number:</th>
      <td class="py-2 px-3"><?php echo $row_record['Emp_Cell_No']; ?></td>
    </tr>

    <tr class="border-bottom">
      <th class="py-2"> Email Address: </th>
      <td class="py-2 px-3"><?php echo $row_record['Emp_Email']; ?></td>
    </tr>

    <tr>
      <th class="py-2"> TIN: </th>
      <td class="py-2 px-3"><?php echo $row_record['Emp_TIN']; ?></td>
      <td class="py-2 px-3"><span class="small"><a class="text-decoration-none" href="#TINModal" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></span></td>
    </tr>
  </table>

  <div class="modal fade" id="positionModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Position</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form action="" Method="POST" ENCTYPE="multipart/form-data">
          <div class="modal-body">
            <select name="position" class="form-control" required>
              <option value="">Position</option>
              <?php
              $data = DBQuery("SELECT * FROM tbl_job ORDER BY Job_description;");
              while ($row = DBFetchArray($data)) { ?>
                <option value="<?php echo $row['Job_code']; ?>" <?php echo SetOptionSelected($row['Job_code'], $empPosition); ?>><?php echo $row['Job_description']; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" name="UpdatePosition" value="Update">
          </div>
        </form>
      </div>
    </div>
  </div><!-- #positionModal -->

  <div class="modal fade" id="TINModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Position</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form action="" Method="POST" ENCTYPE="multipart/form-data">
          <div class="modal-body">
            <input type="text" name="myTIN" placeholder="TIN" value="<?php echo $row_record['Emp_TIN']; ?>" class="form-control">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" name="UpdateTIN" value="Update">
          </div>
        </form>
      </div>
    </div>
  </div><!-- #TINModal -->
</div><!-- .tab-pane -->