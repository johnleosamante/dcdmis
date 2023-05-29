<?php
// modules/employees/update/update-work-experience.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/experience.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$employee_id = $_SESSION[alias() . '_current_employee_id'];
$experience_id = $experience = $from = $to = $position = $organization = $salary = $grade = $status = $service = '';
$is_present = false;
$modalTitle = "Add Work Experience";

if (isset($_GET['id']) && strlen($_GET['id']) > 0) {
  $modalTitle = "Edit Work Experience";
  $_SESSION[alias() . '_current_work_experience_id'] = $id;
  $experiences = experience($employee_id, $id);

  if (num_rows($experiences) > 0) {
    $experience = fetch_array($experiences);
    $experience_id = $experience['no'];
    $from = to_date($experience['from'], 'Y-m-d');
    $is_present = $experience['ispresent'];
    $to = $is_present ? date('Y-m-d') : to_date($experience['to'], 'Y-m-d');
    $position = $experience['position'];
    $organization = $experience['organization'];
    $salary = $experience['salary'];
    $grade = $experience['sg'];
    $status = $experience['status'];
    $service = $experience['isgovernment'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Inclusive Dates From: <?php show_asterisk(); ?></label>
              <input id="from" type="date" name="from" class="form-control" value="<?php echo $from; ?>" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="to" class="mb-0">Dates To: <?php show_asterisk(); ?></label>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" id="ispresent" type="checkbox" name="ispresent" <?php echo set_item_checked($is_present); ?>>
                    <label class="form-check-label" for="ispresent">Present</label>
                  </div><!-- .form-check-->
                </div>
              </div>
              <input id="to" type="date" name="to" class="form-control" value="<?php echo $to; ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="position" class="mb-0">Position Title: <?php show_asterisk(); ?></label>
          <input id="position" type="text" name="position" class="form-control" required value="<?php echo $position; ?>">
        </div>

        <div class="form-group">
          <label for="organization" class="mb-0">Department / Agency / Office / Company: <?php show_asterisk(); ?></label>
          <input id="organization" type="text" name="organization" class="form-control" required value="<?php echo $organization; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="salary" class="mb-0">Monthly<br>Salary:</label>
              <input id="salary" type="number" name="salary" class="form-control" min="0" step="1" value="<?php echo $salary; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="step" class="mb-0">Salary/Job/Pay Grade &amp; Step Increment:</label>
              <input id="step" type="text" name="sg" class="form-control" value="<?php echo $grade; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status" class="mb-0">Status of Appointment: <span class="text-danger">*</span></label>
              <select name="status" id="status" class="form-control" required>
                <option value="Permanent" <?php echo set_option_selected("Permanent", $status); ?>>Permanent</option>
                <option value="Temporary" <?php echo set_option_selected("Temporary", $status); ?>>Temporary</option>
                <option value="Coterminus" <?php echo set_option_selected("Coterminus", $status); ?>>Coterminus</option>
                <option value="Fixed Term" <?php echo set_option_selected("Fixed Term", $status); ?>>Fixed Term</option>
                <option value="Contractual" <?php echo set_option_selected("Contractual", $status); ?>>Contractual</option>
                <option value="Substitute" <?php echo set_option_selected("Substitute", $status); ?>>Substitute</option>
                <option value="Provisional" <?php echo set_option_selected("Provisional", $status); ?>>Provisional</option>
                <option value="Volunteer" <?php echo set_option_selected("Volunteer", $status); ?>>Volunteer</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="isgovernment" class="mb-0">Government Service: <span class="text-danger">*</span></label>
              <select name="isgovernment" id="isgovernment" class="form-control" required>
                <option value="Y" <?php echo set_option_selected("Y", $service); ?>>Yes</option>
                <option value="N" <?php echo set_option_selected("N", $service); ?>>No</option>
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