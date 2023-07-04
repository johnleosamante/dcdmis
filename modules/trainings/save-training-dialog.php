<?php
// modules/trainings/add-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$trainings = training($trainingId);
$title = $type = $sponsor = $venue = '';
$participants = 1;
$dateFrom = $dateTo = date('Y-m-d');
$modalTitle = 'New Training';

if (numRows($trainings) > 0) {
  $training = fetchAssoc($trainings);
  $trainingId = $training['no'];
  $title = $training['title'];
  $dateFrom = $training['from'];
  $dateTo = $training['to'];
  $type = $training['type'];
  $sponsor = $training['sponsor'];
  $venue = $training['venue'];
  $modalTitle = 'Edit Training';
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label for="code" class="mb-0">Code <?php showAsterisk(); ?></label>
          <input type="text" id="code" name="code" class="form-control" value="<?php echo $trainingId; ?>" required>
        </div>

        <div class="form-group">
          <label for="title" class="mb-0">Title <?php showAsterisk(); ?></label>
          <textarea id="title" name="title" class="form-control" rows="3" required><?php echo $title; ?></textarea>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="from" class="mb-0">Date from <?php showAsterisk(); ?></label>
              <input type="date" name="from" id="from" class="form-control" value="<?php echo $dateFrom; ?>" required>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="from" class="mb-0">Date to <?php showAsterisk(); ?></label>
              <input type="date" name="to" id="to" class="form-control" value="<?php echo $dateTo; ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="type" class="mb-0">Type <?php showAsterisk(); ?></label>
          <input id="type" name="type" type="text" class="form-control" value="<?php echo $type; ?>" required>
        </div>

        <div class="form-group">
          <label for="sponsor" class="mb-0">Sponsor <?php showAsterisk(); ?></label>
          <input id="sponsor" name="sponsor" type="text" class="form-control" value="<?php echo $sponsor; ?>" required>
        </div>

        <div class="form-group">
          <label for="venue" class="mb-0">Venue <?php showAsterisk(); ?></label>
          <input id="venue" name="venue" type="text" class="form-control" value="<?php echo $venue; ?>" required>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button class="btn btn-primary" name="save-training" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>