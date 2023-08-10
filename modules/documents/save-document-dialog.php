<?php
// modules/documents/save-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/document-purpose.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$documentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$documents = documentLog($documentId);
$description = $destination = $purpose = $details = $attribute = '';
$isDescriptionEditable = true;
$modalTitle = 'New Document';
$hasDocument = true;
$forRelease = false;
$notFound = true;

if (numRows($documents) > 0) {
  $document = fetchAssoc($documents);
  $documentId = $document['id'];
  $description = $document['description'];
  $destination = $document['destination'];
  $purpose = $document['purpose'];
  $details = $document['details'];
  $documentLogsResults = documentLogs($documentId);
  $documentLogs = fetchAssoc($documentLogsResults);
  $hasDocument = !str_contains(strtolower($documentLogs['status']), 'complete') && !str_contains(strtolower($documentLogs['status']), 'cancel') && $documentLogs['from'] === $station;
  $modalTitle = $hasDocument ? 'Edit Document' : 'Document not found';

  if ($station !== $document['from']) {
    $attribute = ' disabled';
  } else {
    if (numRows($documentLogsResults) === 1) {
      $attribute = '';
      $isDescriptionEditable = $_SESSION[alias() . '_editableDescription'] = true;
    } else {
      $attribute = ' disabled';
      $isDescriptionEditable = $_SESSION[alias() . '_editableDescription'] = false;
    }
  }

  $forRelease = str_contains(strtolower($document['purpose']), 'release') && $documentLogs['from'] === 'RECORD' && $isRecordsPortal;
  $notFound = false;
}
?>

<div class="modal-dialog <?php echo !$hasDocument ? 'modal-sm' : ''; ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasDocument) { ?>
          <?php if (!$notFound) : ?>
            <div class="form-group">
              <label for="code" class="mb-0">Code</label>
              <input id="code" type="text" value="<?php echo $documentId; ?>" class="form-control text-uppercase" disabled>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="description" class="mb-0">Description <?php showAsterisk($isDescriptionEditable); ?></label>
            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Type description..." <?php echo $attribute; ?> required><?php echo $description; ?></textarea>
          </div>

          <?php if (!$isSchoolPortal) : ?>
            <div class="form-group">
              <label class="mb-0" for="destination">Destination <?php showAsterisk(); ?></label>
              <?php if (!$forRelease) { ?>
                <select name="destination" id="destination" class="form-control" required>
                  <option value="">Select destination...</option>
                  <?php $sections = sectionsExcept($station);
                  while ($section = fetchArray($sections)) : ?>
                    <option value="<?php echo $section['id']; ?>" <?php echo setOptionSelected($section['id'], $destination); ?>><?php echo $section['name']; ?></option>
                  <?php endwhile; ?>
                </select>
              <?php } else {
                $schools = schoolByAlias($destination);
                $school = '';

                if (numRows($schools) > 0) {
                  $school = fetchAssoc($schools)['name'];
                }
              ?>
                <input id="destination" class="form-control" type="text" value="<?php echo $school; ?>" disabled>
                <input name="destination" class="form-control" type="hidden" value="<?php echo $destination; ?>" required>
              <?php } ?>
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label class="mb-0" for="purpose">Purpose <?php showAsterisk(); ?></label>
            <?php if (!$forRelease) : ?>
              <select name="purpose" id="purpose" class="form-control" required>
                <option value="">Select purpose...</option>
                <?php
                $documentPurposes = documentPurpose();
                while ($documentPurpose = fetchArray($documentPurposes)) : ?>
                  <option value="<?php echo $documentPurpose['purpose']; ?>" <?php echo setOptionSelected($documentPurpose['purpose'], $purpose); ?>><?php echo $documentPurpose['purpose']; ?></option>
                <?php endwhile; ?>
              </select>
            <?php else : ?>
              <input id="purpose" name="purpose" class="form-control" type="text" value="<?php echo $purpose; ?>" required readonly>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="mb-0" for="details">Additional details</label>
            <textarea id="details" name="details" class="form-control" rows="2" placeholder="Type additional details..."><?php echo $details; ?></textarea>
          </div>

          <?php requiredLegend(0); ?>
        <?php } else {
          missingAlert($modalTitle);
        } ?>
      </div>

      <div class="modal-footer">
        <?php if ($hasDocument) : ?>
          <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
          <button class="btn btn-primary" name="save-document" type="submit">Continue</button>
        <?php endif; ?>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>