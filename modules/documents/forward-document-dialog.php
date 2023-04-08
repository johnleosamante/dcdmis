<?php
// modules/documents/forward-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');
$modal_title = 'Forward';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form action="" method="POST">
      <?php $document = fetch_assoc(document($_SESSION[alias() . '_No'])); ?>
      <div class="modal-body">
        <div class="form-group">
          <label class="mb-0">Code</label>
          <input type="text" value="<?php echo $document['id']; ?>" class="form-control text-uppercase" disabled>
        </div>

        <div class="form-group">
          <label class="mb-0">Description</label>
          <textarea class="form-control text-uppercase" rows="3" disabled><?php echo $document['description']; ?></textarea>
        </div>

        <div class="form-group">
          <label class="mb-0" for="destination">Destination</label>
          <select name="destination" id="destination" class="form-control" required>
            <option>Select destination...</option>
            <?php
            $sections = section($_SESSION[alias() . '_station']);
            while ($section = fetch_array($sections)) : ?>
              <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group mb-0">
          <label class="mb-0" for="purpose">Purpose</label>
          <select name="purpose" id="purpose" class="form-control" required>
            <option>Select purpose...</option>
            <option value="For evaluation">For evaluation</option>
            <option value="For signature">For signature</option>
            <option value="For approval">For approval</option>
            <option value="For release">For release</option>
            <option value="For comments &amp; recommendations">For comments &amp; recommendations</option>
            <option value="For submission">For submission</option>
            <option value="For appropriate action">For appropriate action</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="forward_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>