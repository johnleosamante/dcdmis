<?php
// modules/pm/admin-raters.php - Admin: Top Management / Raters Management
if (!$isHrmis && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$topManagement = pmTopManagement(false);
$activeCycle = pmActiveCycle();

// Get all active employees for selection
$allEmployees = activeEmployees();

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Raters Management</li>
        </ol>
    </nav>
</div>

<div class="card border-left-success shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-success text-uppercase">
                <i class="fas fa-user-tie mr-1"></i> Top Management / Raters
            </h6>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addRaterModal">
                <i class="fas fa-plus fa-sm mr-1"></i> Add Rater
            </button>
        </div>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            Manage the list of employees who can serve as raters/validators for IPCRF. 
            These are typically section heads, supervisors, and top management personnel.
        </p>

        <?php if (empty($topManagement)): ?>
            <div class="text-center py-4">
                <i class="fas fa-user-tie fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No raters defined yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="small text-uppercase">
                            <th width="5%">#</th>
                            <th width="35%">Name</th>
                            <th width="30%">Position Title</th>
                            <th width="15%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topManagement as $i => $tm): ?>
                            <tr>
                                <td class="align-middle"><?= $i + 1 ?></td>
                                <td class="align-middle font-weight-bold text-uppercase"><?= e($tm['name']) ?></td>
                                <td class="align-middle"><?= e($tm['position_title'] ?? '-') ?></td>
                                <td class="align-middle text-center">
                                    <?php if ($tm['is_active']): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="editRater(<?= e(json_encode($tm)) ?>)" title="Edit">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="rater-verifier" value="<?= cipher($tm['id']) ?>">
                                        <button type="submit" name="remove-rater" class="btn btn-sm btn-outline-danger" 
                                            title="Remove" onclick="return confirm('Remove this rater?')">
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

<!-- Validator Assignments -->
<?php if ($activeCycle): ?>
<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info text-uppercase">
                <i class="fas fa-link mr-1"></i> Rater-Ratee Assignments (<?= e($activeCycle['title']) ?>)
            </h6>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#assignValidatorModal">
                <i class="fas fa-plus fa-sm mr-1"></i> Assign Rater
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php 
        $assignments = pmValidators($activeCycle['id']);
        if (empty($assignments)): 
        ?>
            <div class="text-center py-4">
                <i class="fas fa-link fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No rater-ratee assignments for this cycle.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="small text-uppercase">
                            <th width="5%">#</th>
                            <th width="35%">Rater</th>
                            <th width="35%">Ratee</th>
                            <th width="15%">Assigned</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignments as $i => $assign): ?>
                            <tr>
                                <td class="align-middle"><?= $i + 1 ?></td>
                                <td class="align-middle text-uppercase"><?= e($assign['rater_name']) ?></td>
                                <td class="align-middle text-uppercase"><?= e($assign['ratee_name']) ?></td>
                                <td class="align-middle small"><?= date('M d, Y', strtotime($assign['created_at'])) ?></td>
                                <td class="align-middle text-center">
                                    <form action="" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="validator-id" value="<?= cipher($assign['validator_id']) ?>">
                                        <input type="hidden" name="ratee-id" value="<?= cipher($assign['ratee_id']) ?>">
                                        <input type="hidden" name="cycle-id" value="<?= cipher($activeCycle['id']) ?>">
                                        <button type="submit" name="remove-assignment" class="btn btn-sm btn-outline-danger" 
                                            title="Remove" onclick="return confirm('Remove this assignment?')">
                                            <i class="fas fa-unlink fa-sm"></i>
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
<?php endif; ?>

<!-- Add Rater Modal -->
<div class="modal fade" id="addRaterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Add Rater</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Employee <?php showAsterisk() ?></label>
                        <select name="employee_id" class="form-control select2" required>
                            <option value="">-- Select Employee --</option>
                            <?php foreach ($allEmployees as $emp): ?>
                                <?php if (!pmTopManagementRecord($emp['id'])): ?>
                                    <option value="<?= e($emp['id']) ?>">
                                        <?= e(strtoupper(toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension']))) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Position Title <?php showAsterisk() ?></label>
                        <input type="text" name="position_title" class="form-control" required 
                            placeholder="e.g., Schools Division Superintendent">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-rater" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Add Rater
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Rater Modal -->
<div class="modal fade" id="editRaterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="rater-verifier" id="edit-rater-id">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Rater</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Name</label>
                        <input type="text" id="edit-rater-name" class="form-control bg-light" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Position Title <?php showAsterisk() ?></label>
                        <input type="text" name="position_title" id="edit-rater-position" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="is_active" id="edit-rater-active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update-rater" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Validator Modal -->
<?php if ($activeCycle): ?>
<div class="modal fade" id="assignValidatorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="cycle-id" value="<?= cipher($activeCycle['id']) ?>">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Assign Rater to Ratee</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Rater <?php showAsterisk() ?></label>
                        <select name="validator_id" class="form-control" required>
                            <option value="">-- Select Rater --</option>
                            <?php foreach ($topManagement as $tm): ?>
                                <?php if ($tm['is_active']): ?>
                                    <option value="<?= cipher($tm['employee_id']) ?>">
                                        <?= e(strtoupper($tm['name'])) ?> — <?= e($tm['position_title']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Ratee <?php showAsterisk() ?></label>
                        <select name="ratee_id" class="form-control select2" required>
                            <option value="">-- Select Ratee --</option>
                            <?php foreach ($allEmployees as $emp): ?>
                                <option value="<?= cipher($emp['id']) ?>">
                                    <?= e(strtoupper(toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension']))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="assign-validator" class="btn btn-info">
                        <i class="fas fa-link mr-1"></i> Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function editRater(tm) {
    document.getElementById('edit-rater-id').value = '<?= cipher(0) ?>'.slice(0, -1) + btoa(tm.id).replace(/=/g, '');
    document.getElementById('edit-rater-name').value = tm.name;
    document.getElementById('edit-rater-position').value = tm.position_title || '';
    document.getElementById('edit-rater-active').value = tm.is_active;
    
    // Store raw ID
    const form = document.querySelector('#editRaterModal form');
    let hiddenInput = form.querySelector('input[name="rater_id_raw"]');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'rater_id_raw';
        form.appendChild(hiddenInput);
    }
    hiddenInput.value = tm.id;
    
    $('#editRaterModal').modal('show');
}
</script>
