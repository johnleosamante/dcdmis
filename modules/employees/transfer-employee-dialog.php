<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/layout/components.php');

$modal_title = 'Transfer Employee';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modal_title); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="d-flex">
          <div class="d-flex justify-content-center align-middle employee-photo photo-2x rounded-circle overflow-hidden">
            <img height="100%" src="<?php echo $photo; ?>" alt="<?php echo $employee_name; ?>">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
        <button class="btn btn-primary" name="cancel-document" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>