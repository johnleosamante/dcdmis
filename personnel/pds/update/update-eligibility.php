<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $career = $rating = $exam_date = $exam_place = $number = $validity = '';
$modalTitle = "Add Civil Service Eligibility";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Civil Service Eligibility";
  $eligibilities = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($eligibilities) > 0) {
    $eligibility = mysqli_fetch_array($eligibilities);
    $career = $eligibility['Carrer_Service'];
    $rating = $eligibility['Rating'];
    $exam_date = $eligibility['Date_of_Examination'];
    $exam_place = $eligibility['Place_of_Examination'];
    $number = $eligibility['Number_of_Hour'];
    $validity = $eligibility['Date_of_Validity'];
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
        <div class="form-group">
          <label for="Carrer" class="mb-0">Career Service / RA 1080 (Board/Bar) / Underspecial Laws / CES / CSEE / Barangay Eligibility / Driver's License <span class="text-danger">*</span></label>
          <input id="Carrer" type="text" name="WCareer" class="form-control" required value="<?php echo $career; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="rating" class="mb-0">Rating <br>(if applicable)</label>
              <input id="rating" type="number" name="WRating" class="form-control" value="<?php echo $rating; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="date_exam" class="mb-0">Date of Examination / Conferment <span class="text-danger">*</span></label>
              <input id="date_exam" type="date" name="WDate" class="form-control" required value="<?php echo $exam_date; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="Place" class="mb-0">Place of Examination / Conferment <span class="text-danger">*</span></label>
          <input id="Place" type="text" name="WPlace" class="form-control" required value="<?php echo $exam_place; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="license_number" class="mb-0">License No. (if applicable)</label>
              <input id="license_number" type="text" name="WLicense" class="form-control" value="<?php echo $number; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="year" class="mb-0">Date of Validity (if applicable)</label>
              <input id="year" type="date" name="WValidity" class="form-control" value="<?php echo $validity; ?>">
            </div>
          </div>
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveEligibility">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->