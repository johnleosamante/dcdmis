<?php
// modules/trainings/save-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$trainings = training($trainingId);
$title = $hours = $trainingType = $trainingSponsor = $venue = $unconsecutiveDates = '';
$dateFrom = $dateTo = date('Y-m-d');
$generateCertificate = false;
$modalTitle = 'Add Training';
$notFound  = true;

if (numRows($trainings) > 0) {
  $training = fetchAssoc($trainings);
  $trainingId = $training['no'];
  $title = $training['title'];
  $dateFrom = $training['from'];
  $dateTo = $training['to'];
  $hours = $training['hours'];
  $trainingType = $training['type'];
  $trainingSponsor = $training['sponsor'];
  $venue = $training['venue'];
  $unconsecutiveDates = $training['unconsecutive_date'];
  $generateCertificate = $training['generate_certificate'] === '1';
  $modalTitle = 'Edit Training';
  $notFound = false;
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if (!$notFound) : ?>
          <div class="form-group">
            <label for="code" class="mb-0">Code <?php showAsterisk(); ?></label>
            <input type="text" id="code" class="form-control text-uppercase" value="<?php echo $trainingId; ?>" disabled>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <label for="title" class="mb-0">Title <?php showAsterisk(); ?></label>
          <textarea id="title" name="title" class="form-control" rows="3" placeholder="Type title..."><?php echo $title; ?></textarea>
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
          <label for="unconsecutive-dates" class="mb-0">For non-consecutive days, please specify</label>
          <input type="text" name="unconsecutive-dates" id="unconsecutive-dates" class="form-control" value="<?php echo $unconsecutiveDates; ?>">
        </div>

        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="hours" class="mb-0">Number of hours <?php showAsterisk(); ?></label>
              <input type="number" name="hours" id="hours" class="form-control" placeholder="Type hours..." value="<?php echo $hours; ?>" required>
            </div>
          </div>

          <div class="col-8">
            <div class="form-group">
              <label for="type" class="mb-0">Type <?php showAsterisk(); ?></label>
              <select id="type" name="type" class="form-control" required>
                <option value="">Select type...</option>
                <?php
                $types = trainingTypes();
                while ($type = fetchAssoc($types)) : ?>
                  <option value="<?php echo $type['id']; ?>" <?php echo setOptionSelected($type['id'], $trainingType); ?>><?php echo $type['type']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="sponsor" class="mb-0">Sponsor <?php showAsterisk(); ?></label>
          <select id="sponsor" name="sponsor" class="form-control" required>
            <option value="">Select sponsor...</option>
            <?php
              $sponsors = trainingSponsors();
              while ($sponsor = fetchAssoc($sponsors)) : ?>
                <option value="<?php echo $sponsor['id']; ?>" <?php echo setOptionSelected($sponsor['id'], $trainingSponsor); ?>><?php echo $sponsor['sponsor']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="venue" class="mb-0">Venue <?php showAsterisk(); ?></label>
          <input id="venue" name="venue" type="text" class="form-control" placeholder="Type venue..." value="<?php echo $venue; ?>" required>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" id="has-certificate" type="checkbox" name="has-certificate" value="1" <?php echo setItemChecked($generateCertificate); ?>>
          <label class="form-check-label" for="has-certificate">Generate certificate</label>
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