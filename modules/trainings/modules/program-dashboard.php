<?php
// modules/trainings/training-details.php
require_once(root() . '../includes/database/database.php');
require_once(root() . '/modules/trainings/modules/action.php');

if (!$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}
$programs = getProgramslist();

?>


<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Programs</li>
        </ol>
    </nav>
</div>

<div class="d-sm-flex align-items-center flex-row-reverse mb-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onclick="resetProgramInput()"
        data-target="#addProgramModal">
        <i class="fa fa-plus"></i> Add Program
    </button>
</div>

<h4><i class="fa fa-list"></i> Programs</h4>
<div class="row">
    <?php if (!empty($programs)): ?>
        <?php foreach ($programs as $program): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100 program-card">


                    <div class="card-body position-relative">

                        <div class="d-flex justify-content-between align-items-start">

                            <div class="d-flex align-items-start">

                                <div class="mr-3">
                                    <i class="fa fa-folder fa-2x text-primary"></i>
                                </div>

                                <div>
                                    <h6 class="font-weight-bold mb-1">
                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/hrtdms/?v=<?= base64_encode('Program Detail') ?>&id=<?= base64_encode($program['program_id']) ?>"
                                            class="text-primary text-decoration-none">
                                            <?= e($program['program_name']) ?>
                                        </a>
                                    </h6>

                                    <p class="mb-2 text-muted small">
                                        <?= e($program['description'] ?? 'No description') ?>
                                    </p>
                                </div>

                            </div>

                            <div class="dropdown">

                                <button class="btn btn-sm btn-light border" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right shadow">

                                    <button class="dropdown-item" type="button" onclick="editProgram(
                                                                    <?= (int) $program['program_id'] ?>,
                                                                    '<?= e(addslashes($program['program_code'])) ?>',
                                                                    '<?= e(addslashes($program['program_name'])) ?>',
                                                                    '<?= e(addslashes($program['description'])) ?>'
                                                                    )">
                                        <i class="fa fa-edit mr-2 text-primary"></i>
                                        Edit Program
                                    </button>

                                    <div class="dropdown-divider"></div>

                                    <button class="dropdown-item text-danger" type="button" onclick="confirmDeleteProgram(
                                                                    <?= (int) $program['program_id'] ?>,
                                                                    '<?= e(addslashes($program['program_name'])) ?>'
                                                                    )">
                                        <i class="fa fa-trash mr-2"></i>
                                        Delete Program
                                    </button>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between small text-primary">
                            <div>
                                Code: <?= e($program['program_code']) ?>
                            </div>

                            <div>
                                Created: <?= date('M d, Y', strtotime($program['created_at'])) ?>
                            </div>
                        </div>
                        <!-- Actions -->

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No programs found for this training.
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form method="POST" action="#">
            <div class="modal-content">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <input type="hidden" id="program_id">
                <input type="hidden" id="program_action" value="add">

                <div class="modal-header">
                    <h5 class="modal-title" id="addProgramModalLabel">
                        Add New Program
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Program Code</label>
                        <input type="text" id="program_code" name="program_code" class="form-control"
                            placeholder="Program Code">
                    </div>

                    <div class="form-group">
                        <label>Program Name</label>
                        <input type="text" id="program_name" name="program_name" class="form-control" required
                            placeholder="Program Name">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-primary" onclick="submitProgram()">
                        Save Program
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteProgramModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Delete Program
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete
                <strong id="delete_program_name"></strong>?

                <br><br>

                <div class="alert alert-warning mb-0">
                    This action cannot be undone.
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="delete_program_id">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <button type="button" class="btn btn-danger" onclick="deleteProgram()">
                    Delete Program
                </button>
            </div>

        </div>
    </div>
</div>