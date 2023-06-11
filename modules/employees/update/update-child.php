<?php
// modules/employees/update/update-child.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/children.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$childId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$fname = $mname = $lname = $ext = '';
$bdate = date('Y-M-d');
$modalTitle = 'Add Child Name';

if (isset($childId)) {
  $modalTitle = 'Edit Child Name';
  $children = child($employeeId, $childId);

  if (numRows($children) > 0) {
    $child = fetchArray($children);
    $childId = $child['no'];
    $fname = $child['first'];
    $mname = $child['middle'];
    $lname = $child['last'];
    $ext = $child['ext'];
    $bdate = $child['dob'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="clast" class="mb-0">Last Name: <?php showAsterisk(); ?></label>
          <input id="clast" type="text" name="clast" class="form-control" value="<?php echo $lname; ?>" required>
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="cfirst" class="mb-0">First Name: <?php showAsterisk(); ?></label>
              <input id="cfirst" type="text" name="cfirst" class="form-control" value="<?php echo $fname; ?>" required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="cext" class="mb-0">Extension:</label>
              <input id="cext" type="text" name="cext" class="form-control" value="<?php echo $ext; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="cmiddle" class="mb-0">Middle Name:</label>
          <input id="cmiddle" type="text" name="cmiddle" class="form-control" value="<?php echo $mname; ?>">
        </div>

        <div class="form-group">
          <label for="cdob" class="mb-0">Date of Birth: <?php showAsterisk(); ?></label>
          <input id="cdob" type="date" name="cdob" class="form-control" value="<?php echo toDate($bdate, "Y-m-d"); ?>" required>
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-child">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->