<?php
// modules/employees/transfer-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
$modal_title = 'Transfer Employee';
?>

<div class="modal-dialog"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>
  </div>
</div>