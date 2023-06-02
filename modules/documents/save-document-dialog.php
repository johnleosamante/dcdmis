<?php
// modules/documents/save-document-dialog.php
include_once('../../includes/function.php');
include_once(root() . '/includes/string.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/database/document-purpose.php');
include_once(root() . '/includes/database/section.php');
include_once(root() . '/includes/database/school.php');
include_once(root() . '/includes/layout/components.php');

$station     = $_SESSION[alias() . '_station'];
$portal      = $_SESSION[alias() . '_portal'];
$document_id = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$documents   = document_log($document_id);
$for_release = false;

if (num_rows($documents) > 0) {
  $document = fetch_assoc($documents);
  $code = $document['id'];
  $description = $document['description'];
  $destination = $document['destination'];
  $purpose = $document['purpose'];
  $details = $document['details'];

  if ($station !== $document['from']) {
    $attribute = ' disabled';
  } else {
    if (num_rows(document_logs($document_id)) === 1) {
      $attribute = '';
      $_SESSION[alias() . '_editable_description'] = true;
    } else {
      $attribute = ' disabled';
      $_SESSION[alias() . '_editable_description'] = false;
    }
  }

  $for_release = (strtolower($document['purpose']) === 'for release' && $portal === 'record_portal');
  $modal_title = 'Edit Document';
  $not_found = false;
} else {
  $code = $description = $destination = $purpose = $details = $attribute = '';
  $modal_title = 'New Document';
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
        <?php endif; ?>

        <div class="form-group">
          <label for="description" class="mb-0">Description</label>
          <textarea id="description" name="description" class="form-control" rows="3" placeholder="Type description..." <?php echo $attribute; ?> required><?php echo $description; ?></textarea>
        </div>

        <?php if ($portal !== 'school_portal') : ?>
          <div class="form-group">
            <label class="mb-0" for="destination">Destination</label>
            <?php if (!$for_release) { ?>
              <select name="destination" id="destination" class="form-control" required>
                <option value="">Select destination...</option>
                <?php $sections = sections_except($station);
                while ($section = fetch_array($sections)) : ?>
                  <option value="<?php echo $section['id']; ?>" <?php echo set_option_selected($section['id'], $destination); ?>><?php echo $section['name']; ?></option>
                <?php endwhile; ?>
              </select>
            <?php } else {
              $schools = school_by_alias($destination);
              $school = '';

              if (num_rows($schools) > 0) {
                $school = fetch_assoc($schools)['name'];
              }
            ?>
              <input id="destination" class="form-control" type="text" value="<?php echo $school; ?>" disabled>
              <input name="destination" class="form-control" type="hidden" value="<?php echo $destination; ?>" required>
            <?php } ?>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <label class="mb-0" for="purpose">Purpose</label>
          <?php if (!$for_release) : ?>
            <select name="purpose" id="purpose" class="form-control" required>
              <option value="">Select purpose...</option>
              <?php
              $document_purposes = document_purpose();
              while ($document_purpose = fetch_array($document_purposes)) : ?>
                <option value="<?php echo $document_purpose['purpose']; ?>" <?php echo set_option_selected($document_purpose['purpose'], $purpose); ?>><?php echo $document_purpose['purpose']; ?></option>
              <?php endwhile; ?>
            </select>
          <?php else : ?>
            <input id="purpose" name="purpose" class="form-control" type="text" value="<?php echo $purpose; ?>" required readonly>
          <?php endif; ?>
        </div>

        <div class="form-group mb-0">
          <label class="mb-0" for="details">Additional details (optional)</label>
          <textarea id="details" name="details" class="form-control" rows="2" placeholder="Type additional details..."><?php echo $details; ?></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <?php if (!$not_found) : ?>
          <input type="hidden" name="verifier" value="<?php echo $_GET['id']; ?>">
        <?php endif; ?>
        <button class="btn btn-primary" name="save_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>