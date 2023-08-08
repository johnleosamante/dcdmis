<?php
// modules/employees/update/update-reference.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/references.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$referenceId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$name = $address = $contact = '';
$modalTitle = 'Add Reference';

if (isset($referenceId)) {
  $modalTitle = 'Edit Reference';
  $references = reference($employeeId, $referenceId);

  if (numRows($references) > 0) {
    $reference = fetchArray($references);
    $referenceId = $reference['no'];
    $name = $reference['name'];
    $address = $reference['address'];
    $contact = $reference['telephone'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="name" class="mb-0">Name: <?php showAsterisk(); ?></label>
          <input type="text" id="name" name="name" class="form-control" title="Required field" value="<?php echo $name; ?>" required>
        </div>

        <div class="form-group">
          <label for="address" class="mb-0">Address: <?php showAsterisk(); ?></label>
          <input type="text" id="address" name="address" class="form-control" title="Required field" value="<?php echo $address; ?>" required>
        </div>

        <div class="form-group">
          <label for="telephone" class="mb-0">Contact Number: <?php showAsterisk(); ?></label>
          <input type="text" id="telephone" name="telephone" class="form-control" title="Required field" value="<?php echo $contact; ?>" required>
        </div>

        <?php requiredLegend(0); ?>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-reference">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->