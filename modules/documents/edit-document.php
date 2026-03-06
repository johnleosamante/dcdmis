<?php
// modules/documents/save-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$documentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$document = documentLog($documentId);
$description = $destination = $type = $purpose = $details = $attribute = $filename = '';
$isDescriptionEditable = true;
$modalTitle = 'New Document';
$hasDocument = true;
$forRelease = false;
$notFound = true;

if ($document) {
    $documentId = $document['id'];
    $type = $document['document_type_id'];
    $description = $document['description'];
    $destination = $document['forwarded_to'];
    $purpose = $document['status'];
    $details = $document['details'];
    $documentLogs = documentLogs($documentId)[0];
    // $filename = $documentLogs['attachment'];
    $hasDocument = !str_contains(strtolower($documentLogs['status']), 'complete') && !str_contains(strtolower($documentLogs['status']), 'cancel') && $documentLogs['received_from'] === $station;
    $modalTitle = $hasDocument ? 'Edit Document' : 'Document not found';

    if ($station === $document['created_from']) {
        $attribute = '';
        $isDescriptionEditable = $_SESSION[alias() . '_editableDescription'] = true;
    } else {
        $attribute = ' disabled';
        $isDescriptionEditable = $_SESSION[alias() . '_editableDescription'] = false;
    }

    $forRelease = str_contains(strtolower($document['status']), 'release') && $documentLogs['received_from'] === 'RECORD' && $isRecordsPortal;
    $notFound = false;
}
?>

<div class="modal-dialog <?= !$hasDocument ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <?php if ($hasDocument) { ?>
                    <?php if (!$notFound): ?>
                        <div class="form-group">
                            <label for="code" class="mb-0">Code</label>
                            <input id="code" type="text" value="<?= $documentId ?>" class="form-control text-uppercase"
                                disabled>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label for="document-type" class="mb-0">Document Type
                            <?php showAsterisk($isDescriptionEditable) ?>
                        </label>
                        <?php if ($isDescriptionEditable): ?>
                            <select name="document-type" id="document-type" class="form-control" title="Select document type..."
                                required>
                                <option value="">Select type...</option>
                                <?php
                                $documentTypes = $isSchoolPortal ? documentTypes(true) : documentTypes(false);
                                foreach ($documentTypes as $documentType): ?>
                                    <option value="<?= $documentType['id'] ?>" <?= setOptionSelected($documentType['id'], $type) ?>>
                                        <?= $documentType['name'] ?>
                                    </option>
                                <?php endforeach ?>
                                <option value="1" <?= setOptionSelected('1', $type) ?>>Others</option>
                            </select>
                        <?php else: ?>
                            <input id="document-type-name" type="text" class="form-control"
                                value="<?= documentType($type)['name'] ?>" class="form-control" disabled>
                            <input type="hidden" name="document-type" value="<?= $type ?>">
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="description" class="mb-0">Description
                            <?php showAsterisk($isDescriptionEditable) ?>
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="3"
                            placeholder="Type description..." title="Type document description..." <?= $attribute ?>
                            required><?= $description ?></textarea>
                    </div>

                    <?php if (!$isSchoolPortal): ?>
                        <div class="form-group">
                            <label class="mb-0" for="destination">Destination
                                <?php showAsterisk() ?>
                            </label>
                            <?php if (!$forRelease) { ?>
                                <select name="destination" id="destination" class="form-control"
                                    title="Select document destination..." required>
                                    <option value="">Select destination...</option>
                                    <?php
                                    $divisions = functionalDivisions();
                                    foreach ($divisions as $division): ?>
                                        <optgroup label="<?= $division['name'] ?>">
                                            <?php
                                            $sections = sections($division['id']);
                                            foreach ($sections as $section) {
                                                if ($section['id'] !== $station) { ?>
                                                    <option value="<?= $section['id'] ?>" <?= setOptionSelected($section['id'], $destination) ?>>
                                                        <?= $section['name'] ?>
                                                    </option>
                                                    <?php
                                                }
                                            } ?>
                                        </optgroup>
                                    <?php endforeach ?>
                                </select>
                            <?php } else {
                                $school = schoolByAlias($destination);

                                if ($school) {
                                    $school = $school['name'];
                                }
                                ?>
                                <input id="destination" class="form-control" type="text" value="<?= $school ?>" disabled>
                                <input name="destination" class="form-control" type="hidden" value="<?= $destination ?>" required>
                            <?php } ?>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label class="mb-0" for="purpose">Purpose
                            <?php showAsterisk() ?>
                        </label>
                        <?php if (!$forRelease): ?>
                            <select name="purpose" id="purpose" class="form-control" title="Select document purpose..."
                                required>
                                <option value="">Select purpose...</option>
                                <?php
                                $documentPurposes = documentPurpose();
                                foreach ($documentPurposes as $documentPurpose): ?>
                                    <option value="<?= $documentPurpose['purpose'] ?>"
                                        <?= setOptionSelected($documentPurpose['purpose'], $purpose) ?>>
                                        <?= $documentPurpose['purpose'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        <?php else: ?>
                            <input id="purpose" name="purpose" class="form-control" type="text" value="<?= $purpose ?>" required
                                readonly>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label class="mb-0" for="details">Additional details</label>
                        <textarea id="details" name="details" class="form-control" rows="2"
                            placeholder="Type additional details..."
                            title="Type additional details..."><?= $details ?></textarea>
                    </div>

                    <?php // TODO
                        if (false): ?>
                        <div class="form-group">
                            <label class="mb-0" for="file-upload">Attachment</label>
                            <input id="file-upload" name="file-upload[]" type="file" multiple class="w-100"
                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/*, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <div class="small mt-1">(.doc/docx, .xls/xlsx, .ppt/pptx, .jpg/jpeg, .png, .gif, .pdf)</div>
                        </div>
                    <?php endif ?>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasDocument): ?>
                    <input type="hidden" name="verifier" value="<?= isset($_GET['id']) ? $_GET['id'] : null ?>">
                    <input type="hidden" name="file-verifier" value="<?= cipher($filename) ?>">
                    <button class="btn btn-primary" name="save-document" type="submit">Continue</button>
                <?php endif ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>