<?php
// modules/service-record/save-service-record-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$serviceRecordId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$service = $position = $organization = $status = $isgovernment = $leave = $separationCause = null;
$grade = $step = 1;
$salary = 0;
$from = $to = $separationDate = date('Y-m-d');
$isPresent = $isSeparation =  false;
$modalTitle = 'Add Service Record';

if (isset($serviceRecordId)) {
  $modalTitle = 'Edit Service Record';
  $services = serviceRecord($employeeId, $serviceRecordId);

  if (numRows($services) > 0) {
    $service = fetchAssoc($services);
    $serviceRecordId = $service['no'];
    $from = toDate($service['from'], 'Y-m-d');
    $isPresent = $service['ispresent'] === '1';
    $to = $isPresent ? date('Y-m-d') : toDate($service['to'], 'Y-m-d');
    $position = $service['position'];
    $isgovernment = $service['isgovernment'];
    $grade = $service['grade'];
    $step = $service['step'];
    $salary = $service['salary'];
    $organization = $service['station'];
    $status = $service['status'];
    $leave = $service['leave_dates'];
    $isSeparation = $service['isseparation'];
    $separationDate = toDate($service['separation_date'], 'Y-m-d');
    $separationCause = $service['separation_cause'];
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
              <label for="from" class="mb-0">Inclusive Dates From <?php showAsterisk(); ?></label>
              <input id="from" type="date" name="from" class="form-control" title="Required field" value="<?php echo $from; ?>" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="to" class="mb-0">Dates To <?php showAsterisk(); ?></label>
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
          <label for="position" class="mb-0">Designation <?php showAsterisk(); ?></label>
          <input id="position" type="text" name="position" class="form-control" title="Required field" value="<?php echo $position; ?>" required>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status" class="mb-0">Employment Status <?php showAsterisk(); ?></label>
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
              <label for="is-government" class="mb-0">Government Service <?php showAsterisk(); ?></label>
              <select name="is-government" id="is-government" title="Required field" class="form-control" required>
                <option value="Y" <?php echo setOptionSelected("Y", $isgovernment); ?>>Yes</option>
                <option value="N" <?php echo setOptionSelected("N", $isgovernment); ?>>No</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="grade" class="mb-0">Salary Grade</label>
              <input id="grade" type="number" name="grade" class="form-control" min="1" max="33" step="1" title="Leave blank if not applicable" value="<?php echo $grade; ?>">
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label for="step" class="mb-0">Step</label>
              <input id="step" type="number" name="step" class="form-control" min="1" max="8" step="1" title="Leave blank if not applicable" value="<?php echo $step; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="salary" class="mb-0">Annual Salary</label>
              <input id="salary" type="number" name="salary" class="form-control" min="0" step="1" title="Leave blank if not applicable" value="<?php echo $salary; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="station" class="mb-0">Office Entity / Division / Station / Place / Branch of Assignment <?php showAsterisk(); ?></label>
          <input id="station" type="text" name="station" class="form-control" title="Required field" value="<?php echo $organization; ?>" required>
        </div>

        <div class="form-group">
          <label for="leave" class="mb-0">Leave Without Pay</label>
          <input id="leave" type="text" name="leave" class="form-control" title="Leave blank if not applicable" value="<?php echo $leave; ?>">
        </div>

        <div class="form-check mb-2" title="Check for separation">
          <input class="form-check-input" id="is-separation" type="checkbox" name="is-separation" value="1" <?php echo setItemChecked($isSeparation); ?>>
          <label class="form-check-label" for="is-separation">Separation</label>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="separation-date" class="mb-0">Date</label>
              <input id="separation-date" type="date" name="separation-date" class="form-control" title="Leave blank if not applicable" value="<?php echo $separationDate; ?>">
            </div>
          </div>

          <div class="col-md-7">
            <div class="form-group">
              <label for="separation-cause" class="mb-0">Cause</label>
              <input id="separation-cause" type="text" name="separation-cause" class="form-control" title="Leave blank if not applicable" value="<?php echo $separationCause; ?>">
            </div>
          </div>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-service-record">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>