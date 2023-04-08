<?php
// modules/documents/receive-document-dialog.php
$modal_title = 'Receive';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

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