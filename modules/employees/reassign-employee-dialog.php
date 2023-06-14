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
  $modalTitle = 'Reassign Employee';
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-middle employee-photo photo-2x rounded-circle overflow-hidden mx-auto mb-3">
          <img height="100%" src="<?php echo $picture; ?>" alt="<?php echo $employeeName; ?>">
        </div>
        <div class="text-center text-uppercase my-1 h4"><?php echo $employeeName; ?></div>
        <div class="text-center text-uppercase my-1 h5"><?php echo $position; ?></div>
        <div class="text-center text-uppercase my-1 h6"><?php echo $station; ?></div>

        <hr>

        <div class="form-group">
          <label for="position" class="mb-0">Position</label>
          <select id="position" name="position" class="form-control" required>
            <option value="">Select position...</option>
            <?php $jobPositions = positions();
            while ($jobPosition = fetchArray($jobPositions)) : ?>
              <option value="<?php echo $jobPosition['id']; ?>" <?php echo setOptionSelected($jobPosition['id'], $positionId); ?>><?php echo $jobPosition['position']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="assignment" class="mb-0">Place of Assignment</label>
          <select id="assignment" name="assignment" class="form-control" required>
            <option value="">Select place of assignment...</option>
            <?php $assignments = schools();
            while ($assignment = fetchArray($assignments)) : ?>
              <option value="<?php echo $assignment['id']; ?>" <?php echo setOptionSelected($assignment['id'], $stationId); ?>><?php echo $assignment['name']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group mb-0">
          <label for="assignment-date" class="mb-0">Date of Assignment</label>
          <input class="form-control" type="date" id="assignment-date" name="assignment-date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
        <button class="btn btn-primary" name="reassign-employee" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>