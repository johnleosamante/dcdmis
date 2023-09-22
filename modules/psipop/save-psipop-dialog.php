<?php
// modules/psipop/save-psipop-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/psipop.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;
$item = $salaryGrade = $step = $status = $eligibility = null;
$doa = $dlp = date('Y-m-d');

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
  $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
  $sex = $employee['sex'];
  $positions = fetchAssoc(position($employeeId));
  $stationId = $positions['station_id'];
  $station = $positions['station'];
  $positionId = $positions['position_id'];
  $position = $positions['position'];
  $depedEmail = $employee['email'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Employee PSIPOP Information';
  $hasEmployee = true;

  $psipops = psipop($employeeId);

  if (numRows($psipops) > 0) {
    $psipop = fetchAssoc($psipops);
    $item = $psipop['item'];
    $salaryGrade = $psipop['sg'];
    $step = $psipop['step'];
    $status = $psipop['status'];
    $dlp = $psipop['date_promoted'];
    $eligibility = $psipop['eligibility'];
  }

  $appointments = originalAppointment($employeeId);

  if (numRows($appointments) > 0) {
    $appointment = fetchAssoc($appointments);
    $doa = $appointment['doa'];
  }
}
?>

<div class="modal-dialog <?php echo !$hasEmployee ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasEmployee) {
          employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station); ?>
          <hr>

          <div class="form-group">
            <label for="item" class="mb-0">Item Number <?php showAsterisk(); ?></label>
            <input type="text" id="item" name="item" class="form-control" value="<?php echo $item; ?>" required>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="salary-grade" class="mb-0">Salary Grade <?php showAsterisk(); ?></label>
                <input type="number" id="salary-grade" name="salary-grade" min="1" max="33" step="1" class="form-control" value="<?php echo $salaryGrade; ?>" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="step" class="mb-0">Step Increment <?php showAsterisk(); ?></label>
                <input type="number" id="step" name="step" min="1" max="8" step="1" class="form-control" value="<?php echo $step; ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="doa" class="mb-0">Date of Original<br>Appointment <?php showAsterisk(); ?></label>
                <input type="date" id="doa" name="doa" class="form-control" value="<?php echo $doa; ?>" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="dlp" class="mb-0">Date of Last<br>Promotion <?php showAsterisk(); ?></label>
                <input type="date" id="dlp" name="dlp" class="form-control" value="<?php echo $dlp; ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
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
            <div class="col-6">
              <div class="form-group">
                <label for="eligibility" class="mb-0">Eligibility <?php showAsterisk(); ?></label>
                <input type="text" id="eligibility" name="eligibility" class="form-control" value="<?php echo $eligibility; ?>" required>
              </div>
            </div>
          </div>

          <?php requiredLegend(0); ?>
        <?php
        } else {
          missingAlert($modalTitle);
        } ?>
      </div>
      <div class="modal-footer">
        <?php if ($hasEmployee) : ?>
          <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
          <button class="btn btn-primary" name="save-psipop" type="submit">Continue</button>
        <?php
        endif;
        cancelModalButton();
        ?>
      </div>
    </form>
  </div>
</div>