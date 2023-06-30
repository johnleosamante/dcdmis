<?php
// modules/trainings/add-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$title = $type = $sponsor = $venue = $participants = '';
$dateFrom = $dateTo = date('Y-m-d');
$modalTitle = 'New Training';
$hasTraining = true;
?>

<div class="modal-dialog <?php echo !$hasTraining ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasTraining) { ?>
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
            <input id="type" name="type" tyoe="text" class="form-control" value="<?php echo $type; ?>" required>
          </div>

          <div class="form-group">
            <label for="sponsor" class="mb-0">Sponsor <?php showAsterisk(); ?></label>
            <input id="sponsor" name="sponsor" type="text" class="form-control" value="<?php echo $sponsor; ?>" required>
          </div>

          <div class="form-group">
            <label for="venue" class="mb-0">Venue <?php showAsterisk(); ?></label>
            <input id="venue" name="venue" type="text" class="form-control" value="<?php echo $venue; ?>" required>
          </div>

          <div class="form-group">
            <label for="participants" class="mb-0">Expected Number of Participants <?php showAsterisk(); ?></label>
            <input id="participants" name="participants" type="number" class="form-control" value="<?php echo $participants; ?>" required>
          </div>

          <?php requiredLegend(0); ?>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasTraining) : ?>
          <input type="hidden" name="verifier" value="<?php echo cipher($trainingId); ?>">
          <button class="btn btn-primary" name="save-training" type="submit">Continue</button>
        <?php endif;
        cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>