<?php
// logout/dialog.php
include_once('../includes/function.php');
$modal_title = 'Logout';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <div class="modal-body">
      Select "Logout" below if you are ready to end your current session.
    </div>

    <div class="modal-footer">
      <a class="btn btn-primary" href="<?php echo uri() . '/logout'; ?>">Logout</a>
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
    </div>
  </div>
</div>