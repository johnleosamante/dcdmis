<?php
// modules/201-file/save-201-file-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/201-file.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$attachmentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$description = $filename = null;
$modalTitle = 'Add 201 File';

if (isset($attachmentId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy 201 File' : 'Edit 201 File';
    $attachments = fileAttachment($employeeId, $attachmentId);

    if (numRows($attachments) > 0) {
        $attachment = fetchAssoc($attachments);
        $attachmentId = $attachment['no'];
        $description = $attachment['description'];
        $filename = $attachment['filename'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input id="file-upload" name="file-upload" type="file" class="w-100">
                </div>

                <div class="form-group">
                    <label for="description" class="mb-0">Description <?php showAsterisk(); ?></label>
                    <textarea id="description" name="description" class="form-control" placeholder="Type description..." rows="3" required><?php echo $description; ?></textarea>
                </div>

                <?php requiredLegend(0); ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
                <?php
                $verifier = isset($_GET['id']) ? $_GET['id'] : null;
                $verifier = $employeeId === $copiedId ? null : $verifier;
                $filename = !isset($_GET['c']) ? $filename : null;
                ?>
                <input type="hidden" name="data-verifier" value="<?php echo $verifier; ?>">
                <input type="hidden" name="file-verifier" value="<?php echo cipher($filename); ?>">
                <button type="submit" class="btn btn-primary" name="save-201-file">Continue</button>
                <?php cancelModalButton(); ?>
            </div>
        </form>
    </div>
</div>