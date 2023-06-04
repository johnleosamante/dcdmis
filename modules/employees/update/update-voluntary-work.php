<?php
// modules/employees/update/update-voluntary-work.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/voluntary-work.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$employee_id = $_SESSION[alias() . '_current_employee_id'];
$voluntary_id = $organization = $from = $to = $hours = $position = '';
$is_present = false;
$modalTitle = "Add Voluntary Work";

if (isset($_GET['id']) && strlen($id) > 0) {
  $modalTitle = "Edit Voluntary Work";
  $_SESSION[alias() . '_current_voluntary_work_id'] = $id;
  $voluntary_works = voluntaryWork($employee_id, $id);

  if (numRows($voluntary_works) > 0) {
    $voluntary_work = fetchArray($voluntary_works);
    $voluntary_id = $voluntary_work['no'];
    $organization = $voluntary_work['organization'];
    $from = toDate($voluntary_work['from'], 'Y-m-d');
    $is_present = $voluntary_work['ispresent'];
    $to = $is_present ? date('Y-m-d') : toDate($voluntary_work['to'], 'Y-m-d');
    $hours = $voluntary_work['hours'];
    $position = $voluntary_work['position'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="organization" class="mb-0">Name & Address of Organization (Write in full): <?php showAsterisk(); ?></label>
          <input id="organization" type="text" name="organization" class="form-control" required value="<?php echo $organization; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Inclusive Dates From: <?php showAsterisk(); ?></label>
              <input id="from" type="date" name="from" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="to" class="mb-0">Dates To: <?php showAsterisk(); ?></label>
                </div>
                <div class="col-6">
                  <input class="form-check-input" id="ispresent" type="checkbox" name="ispresent" <?php echo setItemChecked($is_present); ?>>
                  <label class="form-check-label" for="ispresent">Present</label>
                </div>
              </div>
              <input id="to" type="date" name="to" class="form-control" value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="hours" class="mb-0">Number of Hours:</label>
          <input id="hours" type="number" name="hours" min="0" step="1" class="form-control" value="<?php echo $hours; ?>">
        </div>

        <div class="form-group">
          <label for="position" class="mb-0">Position: <?php showAsterisk(); ?></label>
          <input id="position" type="text" name="position" class="form-control" required value="<?php echo $position; ?>">
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