<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $organization = $from = $to = $hours = $position = '';
$modalTitle = "Add Voluntary Work";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Voluntary Work";
  $voluntary_works = mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($voluntary_works) > 0) {
    $voluntary_work = mysqli_fetch_array($voluntary_works);
    $organization = $voluntary_work['Name_of_Organization'];
    $from = $voluntary_work['From'];
    $to = $voluntary_work['To'];
    $hours = $voluntary_work['Number_of_Hour'];
    $position = $voluntary_work['Position'];
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
          <label for="Organization" class="mb-0">Name & Address of Organization (Write in full): <span class="text-danger">*</span></label>
          <input id="Organization" type="text" name="NOrganization" class="form-control" required value="<?php echo $organization; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="From" class="mb-0">Inclusive Dates From: <span class="text-danger">*</span></label>
              <input id="From" type="date" name="NFrom" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="To" class="mb-0">Inclusive Dates To:</label>
              <input id="To" type="date" name="NTo" class="form-control" value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="Hours" class="mb-0">Number of Hours:</label>
          <input id="Hours" type="number" name="NHour" class="form-control" value="<?php echo $hours; ?>">
        </div>

        <div class="form-group">
          <label for="Position" class="mb-0">Position: <span class="text-danger">*</span></label>
          <input id="Position" type="text" name="NPosition" class="form-control" required value="<?php echo $position; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveVoluntaryWork">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->