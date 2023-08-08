<?php
// modules/employees/update/update-recognition.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$recognitionId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$recognition = '';
$modalTitle = 'Add Recognition';

if (isset($recognitionId)) {
  $modalTitle = 'Edit Recognition';
  $recognitionDataSet = recognition($employeeId, $recognitionId);

  if (numRows($recognitionDataSet) > 0) {
    $recognitionData = fetchArray($recognitionDataSet);
    $recognitionId = $recognitionData['no'];
    $recognition = $recognitionData['recognition'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="recognition" class="mb-0">Non-Academic Distinction / Recognition: <?php showAsterisk(); ?></label>
          <input id="recognition" type="text" name="recognition" class="form-control" title="Required field" value="<?php echo $recognition; ?>" required>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-recognition">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->