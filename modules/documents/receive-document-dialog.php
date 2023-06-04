<?php
// modules/documents/receive-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/string.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/layout/components.php');

$documentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$documents = document($documentId);
$description = '';
$modalTitle = 'Document not found';
$hasDocument = false;

if (numRows($documents) > 0) {
  $document = fetchAssoc($documents);
  $documentId = $document['id'];
  $description = $document['description'];
  $documentLogs = fetchAssoc(documentLogs($documentId));
  $hasDocument = !str_contains(strtolower($documentLogs['status']), 'complete') && !str_contains(strtolower($documentLogs['status']), 'cancel') && $documentLogs['to'] === $station;
  $modalTitle = $hasDocument ? 'Receive Document' : $modalTitle;
}
?>

<div class="modal-dialog <?php echo !$hasDocument ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasDocument) { ?>
          <div class="form-group">
            <label for="code" class="mb-0">Code</label>
            <input id="code" type="text" value="<?php echo $documentId ?>" class="form-control text-uppercase" disabled>
          </div>

          <div class="form-group mb-0">
            <label for="description" class="mb-0">Description</label>
            <textarea id="description" class="form-control text-uppercase" rows="3" disabled><?php echo $description; ?></textarea>
          </div>
        <?php } else {
          missingAlert($modalTitle, 'fa-times-circle');
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasDocument) : ?>
          <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
          <button class="btn btn-primary" type="submit" name="receive-document">Continue</button>
        <?php endif; ?>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>