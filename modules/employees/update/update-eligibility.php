<?php
// modules/employees/update/update-eligibility.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/eligibility.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$employee_id = $_SESSION[alias() . '_current_employee_id'];
$eligibility_id = $career = $rating = $exam_place = $license = '';
$exam_date = $validity = date('Y-m-d');
$is_applicable = true;
$modalTitle = "Add Civil Service Eligibility";

if (isset($_GET['id']) && strlen($_GET['id']) > 0) {
  $modalTitle = "Edit Civil Service Eligibility";
  $_SESSION[alias() . '_current_eligibility_id'] = $id;
  $eligibilities = eligibility($employee_id, $id);

  if (num_rows($eligibilities) > 0) {
    $eligibility = fetch_array($eligibilities);
    $eligibility_id = $eligibility['no'];
    $career = $eligibility['eligibility'];
    $rating = $eligibility['rating'];
    $exam_date = to_date($eligibility['date'], 'Y-m-d');
    $exam_place = $eligibility['place'];
    $license = $eligibility['license'];
    $is_applicable = $eligibility['isapplicable'];
    $validity = $is_applicable ? to_date($eligibility['validity'], 'Y-m-d') : date('Y-m-d');
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="career" class="mb-0">Career Service / RA 1080 (Board/Bar) / Under Special Laws / CES / CSEE / Barangay Eligibility / Driver's License: <?php show_asterisk(); ?></label>
          <input id="career" name="career" type="text" class="form-control" value="<?php echo $career; ?>" required>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="rating" class="mb-0">Rating <br>(if applicable):</label>
              <input id="rating" name="rating" type="number" class="form-control" min="0" step="0.01" value="<?php echo $rating; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="exam_date" class="mb-0">Date of Examination / Conferment: <?php show_asterisk(); ?></label>
              <input id="exam_date" name="exam_date" type="date" class="form-control" required value="<?php echo $exam_date; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="exam_place" class="mb-0">Place of Examination / Conferment: <?php show_asterisk(); ?></label>
          <input id="exam_place" name="exam_place" type="text" class="form-control" required value="<?php echo $exam_place; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="license" class="mb-0">License No. (if applicable):</label>
              <input id="license" type="text" name="license" class="form-control" value="<?php echo $license; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="validity" class="mb-0">Validity:</label>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" id="isapplicable" type="checkbox" name="isapplicable" <?php echo set_item_checked($is_applicable); ?>>
                    <label class="form-check-label" for="isapplicable">Applicable</label>
                  </div><!-- .form-check-->
                </div>
              </div>
              <input id="validity" name="validity" type="date" class="form-control" value="<?php echo $validity; ?>">
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