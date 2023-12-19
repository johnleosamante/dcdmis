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
$empStatus = $item = $salaryGrade = $step = $status = $eligibility = null;
$doa = $dlp = date('Y-m-d');

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
  $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
  $sex = $employee['sex'];
  $dob = $employee['month'] . '/' . $employee['day'] . '/' . $employee['year'];
  $empStatus = $employee['status'];
  $positions = fetchAssoc(position($employeeId));
  $stationId = $positions['station_id'];
  $station = $positions['station'];
  $positionId = $positions['position_id'];
  $salaryGrade = fetchAssoc(positions($positionId))['salary_grade'];
  $position = $positions['position'];
  $depedEmail = $employee['email'];
  $tin = $employee['tin'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Employee PSIPOP Information';
  $hasEmployee = true;

  $psipops = psipop($employeeId);

  if (numRows($psipops) > 0) {
    $psipop = fetchAssoc($psipops);
    $item = $psipop['item'];
    $step = $psipop['step'];
    $status = $psipop['status'];
    $doa = $psipop['original_appointment'] ?? date('Y-m-d');
    $dlp = $psipop['date_promoted'] ?? date('Y-m-d');
    $eligibility = $psipop['eligibility'];
  }
}
?>

<div class="modal-dialog <?php echo !$hasEmployee ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasEmployee) {
          employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $empStatus); ?>
          <hr>

          <div class="form-group">
            <label for="item" class="mb-0">Item Number <?php showAsterisk(); ?></label>
            <input type="text" id="item" name="item" class="form-control" value="<?php echo $item; ?>" required>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="position" class="mb-0">Position</label>
                <input type="text" id="position" class="form-control" value="<?php echo $position; ?>" readonly>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="salary-grade" class="mb-0">Salary Grade</label>
                <input type="text" id="salary-grade" class="form-control" value="<?php echo $salaryGrade; ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="step" class="mb-0">Step Increment <?php showAsterisk(); ?></label>
                <input type="number" id="step" name="step" min="1" max="8" step="1" class="form-control" value="<?php echo $step; ?>" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="sex" class="mb-0">Sex</label>
                <input type="text" id="sex" class="form-control" value="<?php echo $sex; ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="dob" class="mb-0">Date of Birth</label>
                <input type="text" id="dob" class="form-control" value="<?php echo $dob; ?>" readonly>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="tin" class="mb-0">Tax Identification Number</label>
                <input type="text" id="tin" class="form-control" value="<?php echo $tin; ?>" readonly>
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