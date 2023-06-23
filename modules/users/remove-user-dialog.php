<?php
// modules/users/remove-user-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$modalTitle = 'User not found';
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
  $depedEmail = $employee['email'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Remove User';
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
          <div class="text-center text-uppercase h4 mt-1 mb-0"><?php echo $employeeName; ?></div>
          <div class="text-center text-lowercase m-0 small"><?php echo $depedEmail; ?></div>
          <div class="text-center text-uppercase h5 mt-2 mb-1"><?php echo $position; ?></div>
          <div class="text-center text-uppercase h6 my-1"><?php echo $station; ?></div>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasEmployee) : ?>
          <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
          <button class="btn btn-danger" name="remove-user" type="submit">Continue</button>
        <?php endif;
        cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>