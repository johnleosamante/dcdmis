<?php
// logout/dialog.php
include_once('../includes/function.php');
include_once(root() . '/includes/layout/components.php');
$modalTitle = 'Logout';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <div class="modal-body">
      Select "Logout" below if you are ready to end your current session.
    </div>

    <div class="modal-footer">
      <a class="btn btn-primary" href="<?php echo uri() . '/logout'; ?>">Logout</a>
      <?php cancelModalButton(); ?>
    </div>
  </div>
</div>