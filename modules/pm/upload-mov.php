<?php
// modules/pm/upload-mov.php - Upload Means of Verification
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$ipcrfId = (int) sanitize(decode($_GET['id'] ?? null));
$ipcrf = pmIpcrf($ipcrfId);

if (!$ipcrf) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$isOwner = ($userId === (int) $ipcrf['employee_id']);

if (!$isOwner) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employee = employee($ipcrf['employee_id']);
$objectives = pmObjectives($ipcrfId);
$movList = pmMovByIpcrf($ipcrfId);

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Upload MOV</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card border-left-primary shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-upload mr-1"></i> Upload Means of Verification
                </h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">

                    <div class="form-group">
                        <label class="font-weight-bold">Select Objective <?php showAsterisk() ?></label>
                        <select name="objective_id" class="form-control" required>
                            <option value="">-- Select Objective --</option>
                            <?php 
                            $currentKra = '';
                            foreach ($objectives as $obj): 
                                if ($currentKra !== $obj['kra_title']):
                                    if ($currentKra !== '') echo '</optgroup>';
                                    $currentKra = $obj['kra_title'];
                                    echo '<optgroup label="' . e($currentKra) . '">';
                                endif;
                            ?>
                                <option value="<?= cipher($obj['id']) ?>">
                                    <?= e(substr($obj['objective'], 0, 80)) ?><?= strlen($obj['objective']) > 80 ? '...' : '' ?>
                                </option>
                            <?php endforeach; ?>
                            <?php if ($currentKra !== '') echo '</optgroup>'; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">File <?php showAsterisk() ?></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="mov-file" name="mov_file" required 
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <label class="custom-file-label" for="mov-file">Choose file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max: 30MB)
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2" 
                            placeholder="Brief description of this document..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <button type="submit" name="upload-mov" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-file-alt mr-1"></i> Uploaded Documents
                </h6>
            </div>
            <div class="card-body">
                <?php if (empty($movList)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted mb-0">No documents uploaded yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="small">
                                    <th>Objective</th>
                                    <th>File</th>
                                    <th>Uploaded</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($movList as $mov): ?>
                                    <tr class="small">
                                        <td>
                                            <span class="text-muted"><?= e($mov['kra_title']) ?></span><br>
                                            <?= e(substr($mov['objective'], 0, 40)) ?>...
                                        </td>
                                        <td>
                                            <i class="fas fa-file mr-1"></i>
                                            <?= e($mov['original_name']) ?>
                                            <?php if ($mov['description']): ?>
                                                <br><small class="text-muted"><?= e($mov['description']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($mov['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= uri() ?>/uploads/mov/<?= e($mov['file_name']) ?>" target="_blank" 
                                                class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye fa-sm"></i>
                                            </a>
                                            <form action="" method="POST" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                                <input type="hidden" name="mov-verifier" value="<?= cipher($mov['id']) ?>">
                                                <button type="submit" name="delete-mov" class="btn btn-sm btn-outline-danger" 
                                                    title="Delete" onclick="return confirm('Delete this document?')">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('mov-file').addEventListener('change', function(e) {
    var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file...';
    e.target.nextElementSibling.textContent = fileName;
});
</script>
