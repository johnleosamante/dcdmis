<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Update Civil Service Eligibility</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <?php
      include_once('../../../_includes_/function.php');
      include_once('../../../_includes_/database/database.php');

      foreach ($_GET as $key => $data) {
        $id = $_GET[$key] = $data;
      }

      $_SESSION['No'] = $id;

      $eligibilities = mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No ='$id' LIMIT 1;");

      if (mysqli_num_rows($eligibilities) > 0) {
        $eligibility = mysqli_fetch_array($eligibilities);
        $career = $eligibility['Carrer_Service'];
        $rating = $eligibility['Rating'];
        $exam_date = $eligibility['Date_of_Examination'];
        $exam_place = $eligibility['Place_of_Examination'];
        $number = $eligibility['Number_of_Hour'];
        $validity = $eligibility['Date_of_Validity'];
      } else {
        $career = $rating = $exam_date = $exam_place = $number = $validity = '';
      }
      ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="Carrer" class="mb-0">Career Service / RA 1080 (Board/Bar) / Underspecial Laws / CES / CSEE / Barangay Eligibility / Drivers License</label>
          <input id="Carrer" type="text" name="WCareer" class="form-control" required value="<?php echo $career; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="rating" class="mb-0">Rating <br>(if applicable)</label>
              <input id="rating" type="number" name="WRating" class="form-control" required value="<?php echo $rating; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="date_exam" class="mb-0">Date of Examination / Conferment</label>
              <input id="date_exam" type="date" name="WDate" class="form-control" required value="<?php echo $exam_date; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="Place" class="mb-0">Place of Examination / Conferment</label>
          <input id="Place" type="text" name="WPlace" class="form-control" required value="<?php echo $exam_place; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group mb-0">
              <label for="license_number" class="mb-0">License No. (if applicable)</label>
              <input id="license_number" type="text" name="WNHour" class="form-control" required value="<?php echo $number; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group mb-0">
              <label for="year" class="mb-0">Date of Validity (if applicable)</label>
              <input id="year" type="date" name="WValidity" class="form-control" required value="<?php echo $validity; ?>">
            </div>
          </div>
        </div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="UpdateEligibility">Save</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->