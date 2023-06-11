<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');

$modal_title = 'Transfer Employee';
?>

<div class="modal-dialog"></div>
  <div class="modal-content">
    <?php modalHeader($modal_title); ?>
  </div>
</div>