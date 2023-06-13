<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/layout/components.php');

$modal_title = 'Remove Employee';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modal_title); ?>
  </div>
</div>