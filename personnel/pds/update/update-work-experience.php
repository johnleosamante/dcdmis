<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $experience = $from = $to = $position = $organization = $salary = $grade = $status = $service = '';
$modalTitle = "Add Work Experience";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Work Experience";
  $experiences = mysqli_query($con, "SELECT * FROM work_experience WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($experiences) > 0) {
    $experience = mysqli_fetch_array($experiences);
    $from = $experience['From'];
    $to = $experience['To'];
    $position = $experience['Position_Title'];
    $organization = $experience['Organization'];
    $salary = $experience['Monthly_Salary'];
    $grade = $experience['Salary_Grade'];
    $status = $experience['Job_Status'];
    $service = $experience['Goverment'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modalTitle; ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Inclusive Dates From: <span class="text-danger">*</span></label>
              <input id="from" type="date" name="EFrom" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="to" class="mb-0">Inclusive Dates To:</label>
              <input id="to" type="date" name="ETo" class="form-control" value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="position" class="mb-0">Position Title: <span class="text-danger">*</span></label>
          <input id="position" type="text" name="EPosition" class="form-control" required value="<?php echo $position; ?>">
        </div>

        <div class="form-group">
          <label for="organization" class="mb-0">Department / Agency / Office / Company: <span class="text-danger">*</span></label>
          <input id="organization" type="text" name="EOrganization" class="form-control" required value="<?php echo $organization; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="monthly" class="mb-0">Monthly<br>Salary: <span class="text-danger">*</span></label>
              <input id="monthly" type="text" name="ESalary" class="form-control" required value="<?php echo $salary; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="step" class="mb-0">Salary/Job/Pay Grade &amp; Step Increment:</label>
              <input id="step" type="text" name="ESGrade" class="form-control" value="<?php echo $grade; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status" class="mb-0">Status of Appointment: <span class="text-danger">*</span></label>
              <select name="EStatus" id="status" class="form-control" required>
                <option value="Permanent" <?php echo SetOptionSelected("Permanent", $status); ?>>Permanent</option>
                <option value="Temporary" <?php echo SetOptionSelected("Temporary", $status); ?>>Temporary</option>
                <option value="Coterminus" <?php echo SetOptionSelected("Coterminus", $status); ?>>Coterminus</option>
                <option value="Fixed Term" <?php echo SetOptionSelected("Fixed Term", $status); ?>>Fixed Term</option>
                <option value="Contractual" <?php echo SetOptionSelected("Contractual", $status); ?>>Contractual</option>
                <option value="Substitute" <?php echo SetOptionSelected("Substitute", $status); ?>>Substitute</option>
                <option value="Provisional" <?php echo SetOptionSelected("Provisional", $status); ?>>Provisional</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="government" class="mb-0">Government Service: <span class="text-danger">*</span></label>
              <select name="EGovernment" id="government" class="form-control" required>
                <option value="Y" <?php echo SetOptionSelected("Y", $service); ?>>Yes</option>
                <option value="N" <?php echo SetOptionSelected("N", $service); ?>>No</option>
              </select>
            </div>
          </div>
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveExperience">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->