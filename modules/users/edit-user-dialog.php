<?php
// modules/users/edit-user-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/account.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$dtsUser = $hrmisUser = $dmisUser = $hrtdmsUser = $dtsDivisionUser = false;
$stationId = $depedEmail = $dtsUserStation = '';
$modalTitle = 'User not found';
$hasUser = false;
$notFound = true;

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
  $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
  $sex = $employee['sex'];
  $positions = fetchAssoc(position($employeeId));
  $userStationId = $positions['station_id'];
  $station = $positions['station'];
  $positionId = $positions['position_id'];
  $position = $positions['position'];
  $depedEmail = $employee['email'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Edit User';
  $hasUser = true;
  $dts = dtsUser($employeeId);
  $dtsDivisionUser = $userStationId === '143';

  if (numRows($dts) > 0) {
    $dtsUser = true;
    $userData = fetchArray($dts);
    $dtsUserStation = $userData['station'];
  }

  $hrmisUser = isStationUser($employeeId, 'hrmis');
  $dmisUser = isStationUser($employeeId, 'dmis');
  $hrtdmsUser = isStationUser($employeeId, 'hrtdms');
}
?>

<div class="modal-dialog <?php echo !$hasUser ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasUser) {
          employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station); ?>

          <hr>

          <div class="text-center text-capitalize h5 px-2 mb-3">User Assignment</div>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" id="dts" type="checkbox" name="dts" <?php echo setActiveItem($dtsUser, true, 'checked'); ?>>
              <label class="form-check-label" for="dts">Document Tracking System</label>
            </div>
          </div>

          <?php if ($dtsDivisionUser) : ?>
            <div class="form-group pl-3 mt-n3">
              <select name="dts-verifier" class="form-control">
                <option value="">Select section...</option>
                <?php
                $divisions = functionalDivisions();
                while ($division = fetchAssoc($divisions)) : ?>
                  <optgroup label="<?php echo $division['name']; ?>">
                    <?php
                    $sections = sections($division['id']);
                    while ($section = fetchAssoc($sections)) {
                      if ($section['id'] !== $station) { ?>
                        <option value="<?php echo $section['id']; ?>" <?php echo setOptionSelected($section['id'], $dtsUserStation); ?>><?php echo $section['name']; ?></option>
                    <?php
                      } 
                    } ?>
                  </optgroup>
                <?php endwhile; ?>
              </select>
            </div>
          <?php else : ?>
            <input type="hidden" name="dts-verifier" value="<?php echo $userStationId; ?>">
          <?php endif; ?>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" id="hrmis" type="checkbox" name="hrmis" <?php echo setActiveItem($hrmisUser, true, 'checked'); ?>>
              <label class="form-check-label" for="hrmis">Human Resource Management Information System</label>
            </div>
          </div>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" id="dmis" type="checkbox" name="dmis" <?php echo setActiveItem($dmisUser, true, 'checked'); ?>>
              <label class="form-check-label" for="dmis">Division Management Information System</label>
            </div>
          </div>

          <div class="form-group mb-0">
            <div class="form-check">
              <input class="form-check-input" id="hrtdms" type="checkbox" name="hrtdms" <?php echo setActiveItem($hrtdmsUser, true, 'checked'); ?>>
              <label class="form-check-label" for="hrtdms">HR Training &amp; Development Management System</label>
            </div>
          </div>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasUser) : ?>
          <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
          <input type="hidden" name="data-verifier" value="<?php echo cipher($depedEmail); ?>">
          <button class="btn btn-primary" name="edit-user" type="submit">Continue</button>
        <?php endif; ?>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>