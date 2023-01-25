<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $fname = $mname = $lname = $ext = $bdate = '';
$modalTitle = "Add Child Name";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Child Name";
  $children = mysqli_query($con, "SELECT * FROM family_background WHERE `No`='$id' LIMIT 1;");

  if (mysqli_num_rows($children) > 0) {
    $child = mysqli_fetch_array($children);
    $fname = $child['First_Name'];
    $mname = $child['Middle_Name'];
    $lname = $child['Family_Name'];
    $ext = $child['Name_Extension'];
    $bdate = $child['Birthdate'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modalTitle; ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="CLastName" class="mb-0">Last Name: <span class="text-danger">*</span></label>
          <input id="CLastName" type="text" name="CLastName" class="form-control" value="<?php echo $lname; ?>" required>
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="CFirstName" class="mb-0">First Name: <span class="text-danger">*</span></label>
              <input id="CFirstName" type="text" name="CFirstName" class="form-control" value="<?php echo $fname; ?>" required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="CNameExtension" class="mb-0">Extension:</label>
              <input id="CNameExtension" type="text" name="CNameExtension" class="form-control" value="<?php echo $ext; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="CMiddleName" class="mb-0">Middle Name:</label>
          <input id="CMiddleName" type="text" name="CMiddleName" class="form-control" value="<?php echo $mname; ?>">
        </div>

        <div class="form-group">
          <label for="CDateOfBirth">Date of Birth:</label>
          <input id="CDateOfBirth" type="date" name="CDateOfBirth" class="form-control" value="<?php echo $bdate; ?>" required>
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveChild">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->