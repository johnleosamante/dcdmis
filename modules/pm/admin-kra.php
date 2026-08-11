<?php
// modules/pm/admin-kra.php - Admin: Key Result Area Management
if (!$isHrmis && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$kras = pmKras(false);

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Key Result Areas</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">
                <i class="fas fa-bullseye mr-1"></i> Key Result Areas (KRA) Management
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addKraModal">
                <i class="fas fa-plus fa-sm mr-1"></i> Add KRA
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($kras)): ?>
            <div class="text-center py-4">
                <i class="fas fa-bullseye fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No Key Result Areas defined yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="small text-uppercase">
                            <th width="5%">#</th>
                            <th width="30%">Title</th>
                            <th width="35%">Description</th>
                            <th width="10%">Weight</th>
                            <th width="10%">Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kras as $i => $kra): ?>
                            <tr>
                                <td class="align-middle"><?= $kra['sort_order'] ?: ($i + 1) ?></td>
                                <td class="align-middle font-weight-bold"><?= e($kra['title']) ?></td>
                                <td class="align-middle small"><?= e($kra['description'] ?? '-') ?></td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-primary"><?= e($kra['weight']) ?>%</span>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($kra['is_active']): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="editKra(<?= e(json_encode($kra)) ?>)" title="Edit">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add KRA Modal -->
<div class="modal fade" id="addKraModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Add Key Result Area</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Title <?php showAsterisk() ?></label>
                        <input type="text" name="title" class="form-control" required 
                            placeholder="e.g., Content Knowledge and Pedagogy">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2" 
                            placeholder="Brief description of this KRA..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Default Weight (%) <?php showAsterisk() ?></label>
                                <input type="number" name="weight" class="form-control" min="1" max="100" required 
                                    placeholder="e.g., 20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" min="1" 
                                    value="<?= count($kras) + 1 ?>" placeholder="e.g., 1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-kra" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Save KRA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit KRA Modal -->
<div class="modal fade" id="editKraModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="kra-verifier" id="edit-kra-id">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Key Result Area</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Title <?php showAsterisk() ?></label>
                        <input type="text" name="title" id="edit-kra-title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Description</label>
                        <textarea name="description" id="edit-kra-description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Default Weight (%) <?php showAsterisk() ?></label>
                                <input type="number" name="weight" id="edit-kra-weight" class="form-control" min="1" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Sort Order</label>
                                <input type="number" name="sort_order" id="edit-kra-sort" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="is_active" id="edit-kra-active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update-kra" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update KRA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editKra(kra) {
    document.getElementById('edit-kra-id').value = '<?= cipher(0) ?>'.replace('0', kra.id);
    // Use cipher from PHP
    fetch('<?= uri() ?>/pis/?cipher=' + kra.id).then(r => r.text()).then(c => {
        document.getElementById('edit-kra-id').value = c;
    }).catch(() => {
        // Fallback - just use the ID directly encoded
        document.getElementById('edit-kra-id').value = btoa(kra.id);
    });
    document.getElementById('edit-kra-id').value = '<?= cipher(0) ?>'.slice(0, -1) + btoa(kra.id).replace(/=/g, '');
    
    document.getElementById('edit-kra-title').value = kra.title;
    document.getElementById('edit-kra-description').value = kra.description || '';
    document.getElementById('edit-kra-weight').value = kra.weight;
    document.getElementById('edit-kra-sort').value = kra.sort_order;
    document.getElementById('edit-kra-active').value = kra.is_active;
    
    // Set the verifier properly
    const form = document.querySelector('#editKraModal form');
    let hiddenInput = form.querySelector('input[name="kra_id_raw"]');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'kra_id_raw';
        form.appendChild(hiddenInput);
    }
    hiddenInput.value = kra.id;
    
    $('#editKraModal').modal('show');
}
</script>
