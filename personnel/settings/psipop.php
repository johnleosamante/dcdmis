<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['settingstab']) && $_SESSION['settingstab'] === 'psipop'); ?>" id="psipop">
  <form class="py-2" method="post" role="form" action="">
    <?php
    $mypsipop = mysqli_query($con, "SELECT * FROM psipop INNER JOIN tbl_station ON psipop.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE psipop.Emp_ID='" . $_SESSION['EmpID'] . "'");
    $rowpsip = mysqli_fetch_assoc($mypsipop); ?>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="item_number" class="mb-0">Item Number:</label>
          <input type="text" id="item_number" name="item_number" class="form-control" value="<?php echo $rowpsip['Item_Number']; ?>" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="DOA" class="mb-0">Date of Latest Appointment:</label>
          <input type="date" id="DOA" name="DOA" class="form-control" value="<?php echo $rowpsip['Date_promoted']; ?>" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="SN" class="mb-0">Step Number:</label>
          <input type="number" id="SN" name="SN" class="form-control" value="<?php echo $rowpsip['Step']; ?>" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="position" class="mb-0">Position:</label>
          <select name="position" id="position" class="form-control" required>
            <?php
            $mypost = mysqli_query($con, "SELECT * FROM tbl_job ORDER BY Job_description;");
            while ($rowpost = mysqli_fetch_array($mypost)) { ?>
              <option value="<?php echo $rowpost['Job_code']; ?>" <?php echo SetOptionSelected($rowpost['Job_code'], $rowpsip['Job_code']); ?>><?php echo $rowpost['Job_description']; ?></option>
            <?php
            }
            ?>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="jostatus" class="mb-0">Job Status</label>
          <select id="jobstatus" name="jobstatus" class="form-control" required>
            <option value="Permanent" <?php echo SetOptionSelected("Permanent", $rowpsip['Job_status']); ?>>Permanent</option>
            <option value="Temporary" <?php echo SetOptionSelected("Temporary", $rowpsip['Job_status']); ?>>Temporary</option>
            <option value="Coterminus" <?php echo SetOptionSelected("Coterminus", $rowpsip['Job_status']); ?>>Coterminus</option>
            <option value="Fixed Term" <?php echo SetOptionSelected("Fixed Term", $rowpsip['Job_status']); ?>>Fixed Term</option>
            <option value="Contractual" <?php echo SetOptionSelected("Contratual", $rowpsip['Job_status']); ?>>Contractual</option>
            <option value="Substitute" <?php echo SetOptionSelected("Substitute", $rowpsip['Job_status']); ?>>Substitute</option>
            <option value="Provisional" <?php echo SetOptionSelected("Provisional", $rowpsip['Job_status']); ?>>Provisional</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="elegibility" class="mb-0">Eligibility</label>
          <select id="elegibility" name="elegibility" class="form-control" required>
            <option value="PBET" <?php echo SetOptionSelected("PBET", $rowpsip['Elegibility']); ?>>PBET</option>
            <option value="LET" <?php echo SetOptionSelected("LET", $rowpsip['Elegibility']); ?>>LET</option>
            <option value="BLET" <?php echo SetOptionSelected("BLET", $rowpsip['Elegibility']); ?>>BLET</option>
            <option value="CSC" <?php echo SetOptionSelected("CSC", $rowpsip['Elegibility']); ?>>CSC</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <input type="submit" name="UpdatePSIPOP" value="Save" class="btn btn-primary btn-block btn-lg">
      </div>
    </div><!-- .col-sm-12 -->
  </form>
</div><!-- .tab-pane -->