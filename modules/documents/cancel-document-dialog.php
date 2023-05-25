<?php
// modules/documents/cancel-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/layout/components.php');
$modal_title = 'Cancel Document';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modal_title); ?>

    <form action="" method="POST">
      <?php $document = fetch_assoc(document($_SESSION[alias() . '_document_id'])); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="code" class="mb-0">Code</label>
          <input id="code" type="text" value="<?php echo $document['id']; ?>" class="form-control text-uppercase" disabled>
        </div>

        <div class="form-group">
          <label for="description" class="mb-0">Description</label>
          <textarea id="description" class="form-control text-uppercase" rows="3" disabled><?php echo $document['description']; ?></textarea>
        </div>

        <div class="form-group mb-0">
          <label for="remarks" class="mb-0">Reason (required)</label>
          <textarea id="remarks" name="remarks" class="form-control" rows="3" autofocus placeholder="Reason..." required></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="cancel_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>