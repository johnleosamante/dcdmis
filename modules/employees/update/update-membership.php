<?php
// modules/employees/update/update-membership.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/membership.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$membershipId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$membership = '';
$modalTitle = 'Add Membership in Association / Organization';

if (isset($membershipId)) {
  $modalTitle = 'Edit Membership in Association / Organization';
  $membershipDataSet = membership($employeeId, $membershipId);

  if (numRows($membershipDataSet) > 0) {
    $membershipData = fetchArray($membershipDataSet);
    $membershipId = $membershipData['no'];
    $membership = $membershipData['organization'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="membership" class="mb-0">Membership in Association / Organization: <?php showAsterisk(); ?></label>
          <input id="membership" type="text" name="membership" class="form-control" required value="<?php echo $membership; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-membership">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->