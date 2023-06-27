<?php
// modules/users/view-user-dialog.php
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
$depedEmail = $temporaryPassword = '';

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
  $modalTitle = 'Reset User Password';
  $hasEmployee = true;
  $strongPassword = false;
  $length = rand(10, 16);
  $randomPassword = '';

  while (!$strongPassword) {
    $randomPassword = randomPassword($length);
    $strongPassword = checkPasswordStrength($randomPassword);
  }
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
          <hr>
          <div class="text-center bg-secondary text-light rounded p-2 h2 mt-3 mb-0"><?php echo $randomPassword; ?></div>
          <div class="text-center mt-1 small"><em>Copy temporary password above and share to user</em></div>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasEmployee) : ?>
          <input type="hidden" name="verifier" value="<?php echo cipher($depedEmail); ?>">
          <input type="hidden" name="data-verifier" value="<?php echo cipher($randomPassword); ?>">
          <button class="btn btn-danger" name="reset-user" type="submit">Continue</button>
        <?php endif;
        cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>