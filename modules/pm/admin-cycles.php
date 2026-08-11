<?php
// modules/pm/admin-cycles.php - Admin: Rating Period / Cycle Management
if (!$isHrmis && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$cycles = pmCycles();

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Rating Periods</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">
                <i class="fas fa-calendar-alt mr-1"></i> Rating Periods / RPMS Cycles
            </h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCycleModal">
                <i class="fas fa-plus fa-sm mr-1"></i> Add Rating Period
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($cycles)): ?>
            <div class="text-center py-4">
                <i class="fas fa-calendar-alt fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No rating periods defined yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" width="100%">
                    <thead class="bg-light">
                        <tr class="small text-uppercase text-center">
                            <th width="5%">#</th>
                            <th width="25%">Title</th>
                            <th width="15%">School Year</th>
                            <th width="15%">Start Date</th>
                            <th width="15%">End Date</th>
                            <th width="10%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cycles as $i => $cycle): ?>
                            <tr class="text-center">
                                <td class="align-middle"><?= $i + 1 ?></td>
                                <td class="align-middle text-left font-weight-bold"><?= e($cycle['title']) ?></td>
                                <td class="align-middle"><?= e($cycle['school_year']) ?></td>
                                <td class="align-middle"><?= date('M d, Y', strtotime($cycle['date_start'])) ?></td>
                                <td class="align-middle"><?= date('M d, Y', strtotime($cycle['date_end'])) ?></td>
                                <td class="align-middle">
                                    <?php if ($cycle['status'] === 'Active'): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php elseif ($cycle['status'] === 'Closed'): ?>
                                        <span class="badge badge-secondary">Closed</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="editCycle(<?= e(json_encode($cycle)) ?>)" title="Edit">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </button>
                                    <?php if ($cycle['status'] !== 'Active'): ?>
                                        <form action="" method="POST" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="cycle-verifier" value="<?= cipher($cycle['id']) ?>">
                                            <button type="submit" name="activate-cycle" class="btn btn-sm btn-outline-success" 
                                                title="Activate" onclick="return confirm('Activate this rating period? This will deactivate any currently active period.')">
                                                <i class="fas fa-check fa-sm"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Cycle Modal -->
<div class="modal fade" id="addCycleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Add Rating Period</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Title <?php showAsterisk() ?></label>
                        <input type="text" name="title" class="form-control" required 
                            placeholder="e.g., School Year 2024">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">School Year <?php showAsterisk() ?></label>
                        <input type="text" name="school_year" class="form-control" required 
                            placeholder="e.g., 2024-2025">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Start Date <?php showAsterisk() ?></label>
                                <input type="date" name="date_start" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">End Date <?php showAsterisk() ?></label>
                                <input type="date" name="date_end" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-cycle" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Cycle Modal -->
<div class="modal fade" id="editCycleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="cycle-verifier" id="edit-cycle-id">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Rating Period</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Title <?php showAsterisk() ?></label>
                        <input type="text" name="title" id="edit-cycle-title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">School Year <?php showAsterisk() ?></label>
                        <input type="text" name="school_year" id="edit-cycle-sy" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Start Date <?php showAsterisk() ?></label>
                                <input type="date" name="date_start" id="edit-cycle-start" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">End Date <?php showAsterisk() ?></label>
                                <input type="date" name="date_end" id="edit-cycle-end" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" id="edit-cycle-status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update-cycle" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCycle(cycle) {
    // Store raw ID
    const form = document.querySelector('#editCycleModal form');
    let hiddenInput = form.querySelector('input[name="cycle_id_raw"]');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'cycle_id_raw';
        form.appendChild(hiddenInput);
    }
    hiddenInput.value = cycle.id;
    
    document.getElementById('edit-cycle-title').value = cycle.title;
    document.getElementById('edit-cycle-sy').value = cycle.school_year;
    document.getElementById('edit-cycle-start').value = cycle.date_start;
    document.getElementById('edit-cycle-end').value = cycle.date_end;
    document.getElementById('edit-cycle-status').value = cycle.status;
    
    $('#editCycleModal').modal('show');
}
</script>
