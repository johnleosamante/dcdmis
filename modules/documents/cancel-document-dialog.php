<?php
// modules/documents/cancel-document-dialog.php
$modal_title = 'Cancel';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label class="mb-0">Code</label>
          <input type="text" value="<?php echo 'Code'; ?>" class="form-control" disabled>
        </div>

        <div class="form-group">
          <label class="mb-0">Description</label>
          <textarea class="form-control" rows="3" disabled><?php echo 'Description'; ?></textarea>
        </div>

        <div class="form-group mb-0">
          <label class="mb-0" for="remarks">Reason (required)</label>
          <textarea class="form-control" rows="3" name="remarks" id="remarks" autofocus placeholder="Reason..." required><?php echo ''; ?></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="cancel_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>