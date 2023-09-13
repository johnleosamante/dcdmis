<?php
// modules/employees/update/update-work-experience.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$experienceId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$experience = $position = $organization = $salary = $grade = $status = $service = null;
$from = $to = date('Y-m-d');
$isPresent = false;
$modalTitle = 'Add Work Experience';

if (isset($experienceId)) {
  $modalTitle = 'Edit Work Experience';
  $experiences = experience($employeeId, $experienceId);

  if (numRows($experiences) > 0) {
    $experience = fetchArray($experiences);
    $experienceId = $experience['no'];
    $from = toDate($experience['from'], 'Y-m-d');
    $isPresent = $experience['ispresent'] === '1';
    $to = $isPresent ? date('Y-m-d') : toDate($experience['to'], 'Y-m-d');
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
    <?php modalHeader($modalTitle); ?>

    <form method="POST" action="">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Inclusive Dates From: <?php showAsterisk(); ?></label>
              <input id="from" type="date" name="from" class="form-control" title="Required field" value="<?php echo $from; ?>" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="to" class="mb-0">Dates To: <?php showAsterisk(); ?></label>
                </div>
                <div class="col-6">
                  <div class="form-check" title="Check if present work">
                    <input class="form-check-input" id="is-present" type="checkbox" name="is-present" value="1" <?php echo setItemChecked($isPresent); ?>>
                    <label class="form-check-label" for="is-present">Present</label>
                  </div>
                </div>
              </div>
              <input id="to" type="date" name="to" class="form-control" title="Required field" value="<?php echo $to; ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="position" class="mb-0">Position Title: <?php showAsterisk(); ?></label>
          <input id="position" type="text" name="position" class="form-control" title="Required field" value="<?php echo $position; ?>" required>
        </div>

        <div class="form-group">
          <label for="organization" class="mb-0">Department / Agency / Office / Company: <?php showAsterisk(); ?></label>
          <input id="organization" type="text" name="organization" class="form-control" title="Required field" value="<?php echo $organization; ?>" required>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="salary" class="mb-0">Monthly<br>Salary:</label>
              <input id="salary" type="number" name="salary" class="form-control" min="0" step="1" title="Leave blank if not applicable" value="<?php echo $salary; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="step" class="mb-0">Salary/Job/Pay Grade &amp; Step Increment:</label>
              <input id="step" type="text" name="sg" class="form-control" title="Leave blank if not applicable" value="<?php echo $grade; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status" class="mb-0">Status of Appointment: <?php showAsterisk(); ?></label>
              <select name="status" id="status" class="form-control" title="Required field" required>
                <option value="Permanent" <?php echo setOptionSelected("Permanent", $status); ?>>Permanent</option>
                <option value="Temporary" <?php echo setOptionSelected("Temporary", $status); ?>>Temporary</option>
                <option value="Coterminus" <?php echo setOptionSelected("Coterminus", $status); ?>>Coterminus</option>
                <option value="Fixed Term" <?php echo setOptionSelected("Fixed Term", $status); ?>>Fixed Term</option>
                <option value="Contractual" <?php echo setOptionSelected("Contractual", $status); ?>>Contractual</option>
                <option value="Substitute" <?php echo setOptionSelected("Substitute", $status); ?>>Substitute</option>
                <option value="Provisional" <?php echo setOptionSelected("Provisional", $status); ?>>Provisional</option>
                <option value="Volunteer" <?php echo setOptionSelected("Volunteer", $status); ?>>Volunteer</option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="is-government" class="mb-0">Government Service: <?php showAsterisk(); ?></label>
              <select name="is-government" id="is-government" title="Required field" class="form-control" required>
                <option value="Y" <?php echo setOptionSelected("Y", $service); ?>>Yes</option>
                <option value="N" <?php echo setOptionSelected("N", $service); ?>>No</option>
              </select>
            </div>
          </div>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-experience">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>