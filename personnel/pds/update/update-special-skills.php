<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $skillhobby = '';
$modalTitle = "Add Special Skill / Hobby";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Special Skill / Hobby";
  $skills = mysqli_query($con, "SELECT * FROM tbl_special_skills WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($skills) > 0) {
    $skill = mysqli_fetch_array($skills);
    $skillhobby = $skill['Special_Skills'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modalTitle; ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="Organization" class="mb-0">Special Skill / Hobby: <span class="text-danger">*</span></label>
          <input id="Organization" type="text" name="Skill" class="form-control" required value="<?php echo $skillhobby; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveSpecialSkill">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->