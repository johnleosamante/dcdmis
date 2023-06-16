<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
  $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
  $positions = fetchAssoc(position($employeeId));
  $stationId = $positions['station_id'];
  $station = $positions['station'];
  $positionId = $positions['position_id'];
  $position = $positions['position'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Remove Employee';
  $hasEmployee = true;
}
?>

<div class="modal-dialog <?php echo !$hasEmployee ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasEmployee) { ?>
          <div class="d-flex justify-content-center align-middle employee-photo photo-2x rounded-circle overflow-hidden mx-auto mb-3">
            <img height="100%" src="<?php echo $picture; ?>" alt="<?php echo $employeeName; ?>">
          </div>
          <div class="text-center text-uppercase my-1 h4"><?php echo $employeeName; ?></div>
          <div class="text-center text-uppercase my-1 h5"><?php echo $position; ?></div>
          <div class="text-center text-uppercase my-1 h6"><?php echo $station; ?></div>

          <hr>

          <div class="form-group">
            <label for="reason" class="mb-0">Reason <?php showAsterisk(); ?></label>
            <select id="reason" name="reason" class="form-control" required>
              <option value="">Select reason...</option>
              <option value="Transferred">Transferred</option>
              <option value="Resigned">Resigned</option>
              <option value="Retired">Retired</option>
              <option value="Suspended">Suspended</option>
              <option value="Dismissed">Dismissed</option>
              <option value="Deceased">Deceased</option>
              <option value="Duplicate">Duplicate</option>
            </select>
          </div>

          <?php requiredLegend(0); ?>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasEmployee) : ?>
          <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
          <button class="btn btn-primary" name="remove-employee" type="submit">Continue</button>
        <?php endif;
        cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>