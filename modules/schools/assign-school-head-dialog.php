<?php
// modules/schools/assign-school-head-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');



$modalTitle = 'Set Head of Office';
$notFound = true;
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <button class="btn btn-primary" name="set-school-head" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>