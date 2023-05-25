<?php
// modules/documents/save-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/database/document-purpose.php');
include_once(root() . '/includes/database/section.php');
include_once(root() . '/includes/layout/components.php');
$is_edit = $_SESSION[alias() . '_document_id'] !== null;
$modal_title = $is_edit ? 'Edit Document' : 'New Document';
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modal_title); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php
        $description = $destination = $purpose = $details = $attribute = '';

        if ($is_edit) {
          $code = $_SESSION[alias() . '_document_id'];
          $document = fetch_assoc(document_log($_SESSION[alias() . '_document_id']));
          $description = $document['description'];
          $destination = $document['destination'];
          $purpose = $document['purpose'];
          $details = $document['details'];

          if ($_SESSION[alias() . '_station'] !== $document['from']) {
            $attribute = ' disabled';
          } else {
            if (num_rows(document_logs($code)) === 1) {
              $attribute = '';
              $_SESSION[alias() . '_editable_description'] = true;
            } else {
              $attribute = ' disabled';
              $_SESSION[alias() . '_editable_description'] = false;
            }
          }
        ?>
          <div class="form-group">
            <label for="code" class="mb-0">Code</label>
            <input id="code" type="text" value="<?php echo $code; ?>" class="form-control text-uppercase" disabled>
          </div>
        <?php } ?>

        <div class="form-group">
          <label for="description" class="mb-0">Description</label>
          <textarea id="description" name="description" class="form-control" rows="3" placeholder="Type description..." <?php echo $attribute; ?> required><?php echo $description; ?></textarea>
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

        <div class="form-group">
          <label class="mb-0" for="purpose">Purpose</label>
          <select name="purpose" id="purpose" class="form-control" required>
            <option value="">Select purpose...</option>
            <?php
            $document_purposes = document_purpose();
            while ($document_purpose = fetch_array($document_purposes)) : ?>
              <option value="<?php echo $document_purpose['purpose']; ?>" <?php echo set_option_selected($document_purpose['purpose'], $purpose); ?>><?php echo $document_purpose['purpose']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group mb-0">
          <label class="mb-0" for="details">Additional details (optional)</label>
          <textarea id="details" name="details" class="form-control" rows="2" placeholder="Type additional details..."><?php echo $details; ?></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="save_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>