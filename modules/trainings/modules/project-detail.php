<?php
// modules/trainings/training-details.php
require_once(root() . '../includes/database/database.php');
require_once(root() . '/modules/trainings/modules/action.php');

if (!$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$projectId = isset($_GET['id']) ? decode($_GET['id']) : null;
$project = getProjectDetail($projectId);
$trainings = getTrainingByProjects($projectId);
 
?>


<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item">
                <a href="<?= customUri('hrtdms', 'Program') ?>">Project Detail /</a>
            </li>
        </ol>
    </nav>
</div>

<div class="card border-left-success shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Project Detail</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive mb-3">
            <table cellspacing="0">
                <tr>
                    <th class="pr-5" scope="row">Code</th>
                    <td class="text-uppercase"><?= ($project['project_code']) ?></td>
                </tr>
                <tr>
                    <th class="align-top pr-5" scope="row">Title</th>
                    <td class="text-uppercase"><?= ($project['project_name']) ?></td>
                </tr>
                <tr>
                    <th class="align-top pr-5" scope="row">Description</th>
                    <td class="text-uppercase"><?= ($project['description']) ?></td>
                </tr>
                <tr>
                    <th class="align-top pr-5" scope="row">Date Created</th>
                    <td class="text-uppercase"><?= date('M d, Y', strtotime($project['created_at'])) ?></td>
                </tr>

            </table>
        </div>



    </div>
</div>
<h4><i class="fa fa-list"></i> Activity /  Training List</h4>
<div class="row">
    <?php if (!empty($trainings)): ?>
        <?php foreach ($trainings as $training): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100 program-card">

                    <div class="card-body position-relative">

                        <div class="d-flex justify-content-between align-items-start">

                            <div class="d-flex align-items-start">

                                <div class="mr-3">
                                    <i class="fa fa-folder-open fa-2x text-primary"></i>
                                </div>

                                <div class="w-100">

                                    <h4 class="font-weight-bold mb-1">
                                        <?php linkItem(customUri('hrtdms', 'Training Details', $training['id']), $training['title']) ?>
                                    </h4>

                                    <p class="mb-2 text-muted">
                                        sponsored by:
                                        <?= e($training['sponsored_by'] ?? ' ') ?>
                                    </p>

                                </div>

                            </div>

                        </div>
                       
                        <div class="small text-muted d-flex justify-content-between">
                            <div>
                                <strong>Start:</strong>
                                <?= date('M d, Y', strtotime($training['start_date'])) ?>
                            </div>

                            <div>
                                <strong>End:</strong>
                                <?= date('M d, Y', strtotime($training['end_date'])) ?>
                            </div>
                        </div>
                        <hr style="margin-bottom: 5px; margin-top: 5px">

                        <div class="d-flex justify-content-between small text-primary">
                            <div>
                                ID Code: <?= e($training['id']) ?>
                            </div>

                            <div>
                                Created: <?= date('M d, Y', strtotime($training['created_at'])) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No Project found in this Program
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form method="POST" action="#">
            <div class="modal-content">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <input type="hidden" id="program_id" value="<?= $programId ?>">
                <input type="hidden" id="project_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="addProgramModalLabel">
                        Add New Project
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Project Code</label>
                        <input type="text" id="project_code" name="project_code" class="form-control" placeholder="Project Code">
                    </div>

                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" id="project_name" name="project_name" class="form-control" required placeholder="Project Name">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control">
                            </div>
                        </div>
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

                    <button type="button" class="btn btn-primary" onclick="submitProject()">
                        Save Project
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Delete Project
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
                <input type="hidden" id="delete_project_id">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                        class="btn btn-danger"
                        onclick="deleteProject()">
                    Delete Project
                </button>
            </div>

        </div>
    </div>
</div>
<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/assets/vendor/toastr/toastr.min.css">
