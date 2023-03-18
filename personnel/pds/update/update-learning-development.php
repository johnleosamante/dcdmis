<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $title = $from = $to = $hours = $type = $sponsor = '';
$modalTitle = "Add Learning &amp; Development Intervention";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Learning &amp; Development Intervention";
  $trainings = mysqli_query($con, "SELECT * FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($trainings) > 0) {
    $training = mysqli_fetch_array($trainings);
    $title = $training['Title_of_Training'];
    $from = $training['From'];
    $to = $training['To'];
    $hours = $training['Number_of_Hours'];
    $type = $training['Managerial'];
    $sponsor = $training['Conducted'];
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
          <label for="Title_learning" class="mb-0">Learning &amp; Development Intervention / Training Program (Write in full): <span class="text-danger">*</span></label>
          <textarea id="Title_learning" name="TTraining" class="form-control" required rows="2"><?php echo $title; ?></textarea>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="From" class="mb-0">Inclusive Date From: <span class="text-danger">*</span></label>
              <input id="From" type="date" name="TFrom" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="To" class="mb-0">Inclusive Date To: <span class="text-danger">*</span></label>
              <input id="To" type="date" name="TTo" class="form-control" required value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="No_of_hours" class="mb-0">Number of <br>Hours: <span class="text-danger">*</span></label>
              <input id="No_of_hours" type="number" min="0" steps="0.01" name="THour" class="form-control" required value="<?php echo $hours; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="TrainingType" class="mb-0">Type of Learning &amp; Development: <span class="text-danger">*</span></label>
              <input id="TrainingType" type="text" name="TManage" class="form-control" required value="<?php echo $type; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="Conducted" class="mb-0">Conducted / Sponsored by (Write in full): <span class="text-danger">*</span></label>
          <input id="Conducted" type="text" name="TConduct" class="form-control" required value="<?php echo $sponsor; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveLearningDevelopment">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->