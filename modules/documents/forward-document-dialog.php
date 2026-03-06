<?php
// modules/documents/forward-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$documentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$document = document($documentId);
$description = $destination = $type = $purpose = $details = '';
$modalTitle = 'Document not found';
$hasDocument = false;
$forRelease = false;

if ($document) {
    $documentId = $document['id'];
    $description = $document['description'];
    $type = $document['document_type_id'];
    $documentLogs = documentLogs($documentId)[0];
    $hasDocument = !str_contains(strtolower($documentLogs['status']), 'complete') && !str_contains(strtolower($documentLogs['status']), 'cancel') && $documentLogs['received_from'] === $station && $documentLogs['forwarded_to'] === '-';
    $modalTitle = $hasDocument ? 'Forward Document' : $modalTitle;

    if (strtolower($document['status']) === 'for release' && $portal === 'rec_portal') {
        $forRelease = true;
        $destination = $document['created_from'];
        $purpose = $document['status'];
        $details = $document['details'];
    }
}
?>

<div class="modal-dialog <?= !$hasDocument ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($hasDocument) { ?>
                    <div class="form-group">
                        <label for="code" class="mb-0">Code</label>
                        <input id="code" type="text" value="<?= e($documentId) ?>" class="form-control text-uppercase"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="type" class="mb-0">Type</label>
                        <input id="type" class="form-control text-uppercase" value="<?= documentType($type)['name'] ?>"
                            disabled>
                    </div>

                    <div class="form-group">
                        <label for="description" class="mb-0">Description</label>
                        <textarea id="description" class="form-control text-uppercase" rows="3"
                            disabled><?= e($description) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="destination" class="mb-0">Destination <?php showAsterisk() ?></label>
                        <?php if (!$forRelease) { ?>
                            <select id="destination" name="destination" class="form-control"
                                title="Select document destination..." required>
                                <option value="">Select destination...</option>
                                <?php
                                $divisions = functionalDivisions();
                                foreach ($divisions as $division): ?>
                                    <optgroup label="<?= e($division['name']) ?>">
                                        <?php
                                        $sections = sections($division['id']);
                                        foreach ($sections as $section) {
                                            if ($section['id'] !== $station) { ?>
                                                <option value="<?= e($section['id']) ?>"><?= e($section['name']) ?></option>
                                                <?php
                                            }
                                        } ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        <?php } else {
                            $school = schoolByAlias($destination) ?? null;

                            if (!empty($school)) {
                                $school = $school['name'];
                            }
                            ?>
                            <input id="destination" class="form-control" type="text" value="<?= e($school) ?>" disabled>
                            <input name="destination" class="form-control" type="hidden" value="<?= e($destination) ?>"
                                required>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="purpose" class="mb-0">Purpose <?php showAsterisk() ?></label>
                        <?php if (!$forRelease): ?>
                            <select id="purpose" name="purpose" class="form-control" title="Select document purpose..."
                                required>
                                <option value="">Select purpose...</option>
                                <?php
                                $documentPurpose = documentPurpose();
                                foreach ($documentPurpose as $purpose): ?>
                                    <option value="<?= e($purpose['purpose']) ?>"><?= e($purpose['purpose']) ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php else: ?>
                            <input id="purpose" name="purpose" class="form-control" type="text" value="<?= e($purpose) ?>"
                                required readonly>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="details" class="mb-0">Additional details</label>
                        <textarea id="details" name="details" class="form-control" rows="2"
                            placeholder="Type additional details..."
                            title="Type document additional details..."><?= e($details) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="mb-0" for="file-upload">Attachment</label>
                        <input id="file-upload" name="file-upload[]" type="file" multiple class="w-100"
                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/*, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <div class="small mt-1">(.doc/docx, .xls/xlsx, .ppt/pptx, .jpg/jpeg, .png, .gif, .pdf)</div>
                    </div>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasDocument): ?>
                    <input type="hidden" name="verifier" value="<?= e($_GET['id']) ?>">
                    <input type="hidden" name="file-verifier" value="<?= cipher($filename) ?>">
                    <button class="btn btn-primary" name="forward-document" type="submit">Continue</button>
                <?php endif ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>