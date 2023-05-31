<?php
// modules/documents/complete-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/string.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/layout/components.php');

$document_id = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$documents = document($document_id);

if (num_rows($documents) > 0) {
  $document = fetch_assoc($documents);
  $code = $document['id'];
  $description = $document['description'];
  $modal_title = 'Mark Completed Document';
  $not_found = false;
} else {
  $code = $description = '';
  $modal_title = 'Document not found';
  $not_found = true;
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modal_title); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if (!$not_found) : ?>
          <div class="form-group">
            <label for="code" class="mb-0">Code</label>
            <input id="code" type="text" value="<?php echo $code; ?>" class="form-control text-uppercase" disabled>
          </div>

          <div class="form-group">
            <label for="description" class="mb-0">Description</label>
            <textarea id="description" class="form-control text-uppercase" rows="3" disabled><?php echo $description; ?></textarea>
          </div>

          <div class="form-group mb-0">
            <label for="remarks" class="mb-0">Remarks (<em>optional</em>)</label>
            <textarea id="remarks" name="remarks" class="form-control" rows="3" autofocus placeholder="Type remarks..."></textarea>
          </div>
        <?php else : ?>
          Sorry, the document that you are looking for could not be found.
        <?php endif; ?>
      </div>

      <div class="modal-footer">
        <?php if (!$not_found) : ?>
          <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
          <button class="btn btn-primary" name="complete_document" type="submit">Continue</button>
        <?php endif; ?>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>