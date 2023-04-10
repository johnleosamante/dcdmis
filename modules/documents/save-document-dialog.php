<?php
// modules/documents/save-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');
$modal_title = 'New';
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
        if ($_SESSION[alias() . '_No'] !== null) {
          $description = 'Description';
          $destination = 'ITO';
          $purpose = 'For release';
        ?>
          <div class="form-group">
            <label class="mb-0">Code</label>
            <input type="text" value="<?php echo $code; ?>" class="form-control text-uppercase" disabled>
          </div>
        <?php } ?>

        <div class="form-group">
          <label class="mb-0">Description</label>
          <textarea class="form-control" rows="3" required placeholder="Type description..." name="description"><?php echo $description; ?></textarea>
        </div>

        <div class="form-group">
          <label class="mb-0" for="destination">Destination</label>
          <select name="destination" id="destination" class="form-control" required>
            <option>Select destination...</option>
            <?php
            if ($_SESSION[alias() . '_portal'] !== 'school_portal') {
              $sections = sections_except($_SESSION[alias() . '_station']);
              while ($section = fetch_array($sections)) { ?>
                <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
            <?php }
            } else {
              $section = fetch_assoc(section('RECORD')); ?>
              <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
            <?php } ?>
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
        <button class="btn btn-primary" name="save_document" type="submit">Continue</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>