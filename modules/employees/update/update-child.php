<?php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/children.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$employee_id = $_SESSION[alias() . '_current_employee_id'];
$child_id = $fname = $mname = $lname = $ext = '';
$bdate = date('Y-M-d');
$_SESSION[alias() . '_current_child_id'] = '';
$modalTitle = "Add Child Name";

if (isset($_GET['id']) && strlen($_GET['id']) > 0) {
  $modalTitle = "Edit Child Name";
  $_SESSION[alias() . '_current_child_id'] = $id;
  $children = child($employee_id, $id);

  if (numRows($children) > 0) {
    $child = fetchArray($children);
    $child_id = $child['no'];
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
        <button type="submit" class="btn btn-primary" name="save-child">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->