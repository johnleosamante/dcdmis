<?php
// modules/documents/receive-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/layout/components.php');
$modal_title = 'Receive Document';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modal_title); ?>

    <form action="" method="POST">
      <div class="modal-body">
        Select "Continue" below if the document is ready to be received.
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" type="submit" name="receive_document">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>