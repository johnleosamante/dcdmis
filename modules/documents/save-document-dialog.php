<?php
// modules/documents/save-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');

$is_edit = $_SESSION[alias() . '_No'] !== null;
$modal_title = $is_edit ? 'Edit' : 'New';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modal_title; ?></h5>
      <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form action="" method="POST">
      <div class="modal-body">
        <?php
        $description = $destination = $purpose = null;
        $attribute = '';

        if ($is_edit) {
          $code = $_SESSION[alias() . '_No'];
          $document = fetch_assoc(document_log($_SESSION[alias() . '_No']));
          $description = $document['description'];
          $destination = $document['destination'];
          $purpose = $document['purpose'];

          if ($_SESSION[alias() . '_station'] !== $document['from']) {
            $attribute = ' disabled';
          } else {
            $attribute = num_rows(document_logs($code)) === 1 ? '' : ' disabled';
          }
        ?>
          <div class="form-group">
            <label class="mb-0">Code</label>
            <input type="text" value="<?php echo $code; ?>" class="form-control text-uppercase" disabled>
          </div>
        <?php } ?>

        <div class="form-group">
          <label class="mb-0">Description</label>
          <textarea class="form-control" rows="3" required placeholder="Type description..." name="description" <?php echo $attribute; ?>><?php echo $description; ?></textarea>
        </div>

        <?php if ($_SESSION[alias() . '_portal'] !== 'school_portal') : ?>
          <div class="form-group">
            <label class="mb-0" for="destination">Destination</label>
            <select name="destination" id="destination" class="form-control" required>
              <option value="">Select destination...</option>
              <?php $sections = sections_except($_SESSION[alias() . '_station']);
              while ($section = fetch_array($sections)) : ?>
                <option value="<?php echo $section['id']; ?>" <?php echo set_option_selected($section['id'], $destination); ?>><?php echo $section['name']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        <?php endif; ?>

        <div class="form-group mb-0">
          <label class="mb-0" for="purpose">Purpose</label>
          <select name="purpose" id="purpose" class="form-control" required>
            <option value="">Select purpose...</option>
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
        <button class="btn btn-primary" name="save_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>