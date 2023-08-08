<?php
// modules/employees/update/update-learning-development.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$learningId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$title = $hours = $type = $sponsor = '';
$from = $to = date('Y-m-d');
$modalTitle = 'Add Learning &amp; Development Intervention';

if (isset($learningId)) {
  $modalTitle = 'Edit Learning &amp; Development Intervention';
  $trainings = learningAndDevelopment($employeeId, $learningId);

  if (numRows($trainings) > 0) {
    $training = fetchArray($trainings);
    $learningId = $training['no'];
    $title = $training['title'];
    $from = $training['from'];
    $to = $training['to'];
    $hours = $training['hours'];
    $type = $training['type'];
    $sponsor = $training['sponsor'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="title" class="mb-0">Learning &amp; Development Intervention / Training Programs<br>(Write in full): <?php showAsterisk(); ?></label>
          <textarea id="title" name="title" class="form-control" title="Required field" rows="3" required><?php echo $title; ?></textarea>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Inclusive Date From: <?php showAsterisk(); ?></label>
              <input id="from" type="date" name="from" class="form-control" title="Required field" value="<?php echo $from; ?>" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="to" class="mb-0">Inclusive Date To: <?php showAsterisk(); ?></label>
              <input id="to" type="date" name="to" class="form-control" title="Required field" value="<?php echo $to; ?>" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="hours" class="mb-0">Number of <br>Hours: <?php showAsterisk(); ?></label>
              <input id="hours" type="number" min="0" steps="0.01" name="hours" class="form-control" title="Required field" value="<?php echo $hours; ?>" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="type" class="mb-0">Type of Learning &amp; Development: <?php showAsterisk(); ?></label>
              <input id="type" type="text" name="type" class="form-control" title="Required field" value="<?php echo $type; ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="sponsor" class="mb-0">Conducted / Sponsored by (Write in full): <?php showAsterisk(); ?></label>
          <input id="sponsor" type="text" name="sponsor" class="form-control" title="Required field" value="<?php echo $sponsor; ?>" required>
        </div>

        <?php requiredLegend(0); ?>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-learning-development">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->