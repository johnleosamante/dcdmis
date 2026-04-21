<?php
$error = $publication = $vacancies = null;

if ($code) {
    $publication = publicationByCode($code);

    if ($publication) {
        if ($publication['status'] !== 'open') {
            $error = 'This publication is currently closed.';
        } elseif (strtotime($publication['close_date']) < strtotime(date('Y-m-d'))) {
            $error = 'The application period for this publication has ended.';
        } elseif (strtotime($publication['open_date']) > strtotime(date('Y-m-d'))) {
            $error = 'The application period for this publication has not started yet.';
        } else {
            $vacancies = publicationItems($publication['id']);
        }
    } else {
        $error = 'Publication not found.';
    }
} else {
    $error = 'Invalid publication link.';
}
?>

<div class="card mt-3 mb-4 mx-auto">
    <div class="card-body">
        <div class="text-center">
            <?php if ($publication): ?>
                <h2 class="h2 mt-2">
                    <?= e($publication['title']) ?>
                </h2>
                <p class="mb-4">
                    <?= e($publication['description']) ?>
                </p>
                <p class="small text-muted mb-4">
                    Application Period: <span class="font-weight-bold text-dark">
                        <?= toLongDate($publication['open_date']) ?>
                    </span> to <span class="font-weight-bold text-dark">
                        <?= toLongDate($publication['close_date']) ?>
                    </span>
                </p>
            <?php endif ?>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                <?= e($error) ?>
            </div>

            <div class="text-center mt-4">
                <a href="<?= uri() . '/hrmis/apply' ?>" class="btn btn-secondary">Go to Publications</a>
            </div>
        <?php else: ?>
            <form class="user" action="" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="publication_id" value="<?= cipher($publication['id']) ?>">

                <div>
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle mr-1"></i>
                        Check the box for each position you wish to apply for.
                    </div>

                    <div class="table-responsive border rounded mb-4">
                        <table class="table table-hover mb-0" cellspacing="0" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%"></th>
                                    <th width="70%" class="text-left">Vacant Positions</th>
                                    <th width="25%">Available Items</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($vacancies && count($vacancies) > 0) {
                                    $groups = [];
                                    foreach ($vacancies as $row) {
                                        $pid = $row['position_id'];

                                        if (!isset($groups[$pid])) {
                                            $groups[$pid] = [
                                                'position' => $row['official_title'],
                                                'salary_grade' => $row['salary_grade'],
                                                'count' => 0
                                            ];
                                        }

                                        $groups[$pid]['count']++;
                                    }

                                    foreach ($groups as $pid => $group) { ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" name="position_ids[]" value="<?= cipher($pid) ?>"
                                                    id="pos_<?= e($pid) ?>" style="transform: scale(1.5);">
                                            </td>
                                            <td class="align-middle">
                                                <label for="pos_<?= e($pid) ?>"
                                                    class="mb-0 font-weight-bold cursor-pointer"><?= e($group['position']) ?></label>
                                                <div class="small" text-muted">Salary Grade <?= e($group['salary_grade']) ?></div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <?= e($group['count']) ?> Item<?= $group['count'] > 1 ? 's' : '' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No vacancies found for this publication.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                            <thead>
                                <tr class="text-center">
                                    <th width="5%"></th>
                                    <th width="70%" class="text-left">Vacant Positions</th>
                                    <th width="25%">Available Items</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="applicant-id" class="font-weight-bold mb-1">Applicant
                            ID <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="applicant-id" name="applicant_id"
                            placeholder="Enter your applicant ID..." required>
                    </div>

                    <div class="form-group">
                        <label for="pertinent-documents" class="font-weight-bold mb-0">Pertinent Documents (PDF only)
                            <?= showAsterisk() ?></label>
                        <small class="form-text text-muted">Download and refer to the <a
                                href="<?= uri() . '/hrmis/apply/checklist-of-requirements-edited-2025-8.5x13in.pdf' ?>"
                                target="_blank">checklist</a>
                            of requirements on what to include on your pertinent documents.</small>
                        <input type="file" class="form-control-file ml-3 mt-2" id="pertinent-documents"
                            name="pertinent_documents">
                        <small class="form-text text-muted ml-3">Max file upload size: 20MB</small>
                    </div>

                    <button name="submit-application" type="submit" class="btn btn-primary btn-block mt-2">
                        Submit Application
                    </button>

                    <div class="small text-center mt-3">
                        <a href=" <?= uri() . '/hrmis/register' ?>">Don't have an applicant ID yet?</a>
                    </div>
                </div>
            </form>
        <?php endif ?>
    </div>
</div>