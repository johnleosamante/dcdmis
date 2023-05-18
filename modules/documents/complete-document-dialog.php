<?php
// modules/documents/complete-document-dialog.php
include_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
$modal_title = 'Mark Completed Document';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form action="" method="POST">
      <?php $document = fetch_assoc(document($_SESSION[alias() . '_document_id'])); ?>
      <div class="modal-body">
        <div class="form-group">
          <label class="mb-0">Code</label>
          <input type="text" value="<?php echo $document['id']; ?>" class="form-control text-uppercase" disabled>
        </div>

        <div class="form-group">
          <label class="mb-0">Description</label>
          <textarea class="form-control text-uppercase" rows="3" disabled><?php echo $document['description']; ?></textarea>
        </div>

        <div class="form-group mb-0">
          <label class="mb-0" for="remarks">Remarks (<em>optional</em>)</label>
          <textarea class="form-control" rows="3" name="remarks" id="remarks" autofocus placeholder="Type remarks..."></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="complete_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>