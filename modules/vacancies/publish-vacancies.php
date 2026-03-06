<?php
// modules/vacancies/publish-vacancies.php

if (!$isHrmpsb && !$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);

$publication = null;
$selectedVacancyIds = [];
$isEdit = false;

// Check for Edit Mode
if (isset($_GET['id'])) {
    $pubId = sanitize(decipher($_GET['id']));
    if ($pubId) {
        $result = publication($pubId);
        if (numRows($result) > 0) {
            $publication = fetchAssoc($result);
            $isEdit = true;

            // Get selected vacancies
            $items = publicationItems($pubId);
            while ($item = fetchAssoc($items)) {
                $selectedVacancyIds[] = $item['vacancy_id'];
            }
        }
    }
}

$pageTitle = $isEdit ? 'Edit Publication' : 'Create Publication';
$formAction = $isEdit ? 'update-publication' : 'publish-vacancies';
$btnIcon = $isEdit ? 'fa-edit' : 'fa-newspaper';
$btnText = $isEdit ? 'Update Publication' : 'Publish Vacancies';
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmpsb', 'Vacancies') ?>">Vacancies</a></li>
            <li class="breadcrumb-item active"><?= e($pageTitle) ?></li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink($pageTitle, customUri('hrmpsb', 'Publications')) ?>
    </div>

    <div class="card-body">
        <form method="POST">
    <?= csrf_field(); ?>
            <?php if ($isEdit): ?>
                <input type="hidden" name="verifier" value="<?= cipher($publication['id']) ?>">
            <?php endif; ?>

            <!-- Publication Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pub-title" class="font-weight-bold">Publication Title
                            <?php showAsterisk() ?></label>
                        <input type="text" id="pub-title" name="pub_title" class="form-control"
                            placeholder="e.g., Teaching Positions for SY 2026-2027"
                            value="<?= $isEdit ? $publication['title'] : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pub-description" class="font-weight-bold">Description</label>
                        <textarea id="pub-description" name="pub_description" class="form-control" rows="2"
                            placeholder="Brief description of this publication..."><?= $isEdit ? $publication['description'] : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="open-date" class="font-weight-bold">Opening Date <?php showAsterisk() ?></label>
                        <input type="date" id="open-date" name="open_date" class="form-control"
                            value="<?= $isEdit ? $publication['open_date'] : date('Y-m-d') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="close-date" class="font-weight-bold">Closing Date <?php showAsterisk() ?></label>
                        <input type="date" id="close-date" name="close_date" class="form-control"
                            value="<?= $isEdit ? $publication['close_date'] : date('Y-m-d', strtotime('+30 days')) ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pub-status" class="font-weight-bold">Status</label>
                        <select id="pub-status" name="pub_status" class="form-control">
                            <option value="draft" <?= ($isEdit && $publication['status'] == 'draft') ? 'selected' : '' ?>>
                                Draft (Not yet accepting applications)</option>
                            <option value="open" <?= ($isEdit && $publication['status'] == 'open') ? 'selected' : (($isEdit) ? '' : 'selected') ?>>Open (Accepting applications)</option>
                            <option value="closed" <?= ($isEdit && $publication['status'] == 'closed') ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Vacancy Selection -->
            <h5 class="font-weight-bold text-primary mb-3">
                <i class="fas fa-list-check mr-2"></i>Select Vacancies to Include
            </h5>

            <div class="alert alert-info small mb-3">
                <i class="fas fa-info-circle mr-1"></i>
                Check the vacancies you want to include in this publication.
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">
                                <input type="checkbox" id="select-all" title="Select All">
                            </th>
                            <th class="align-middle" width="30%">Position</th>
                            <th class="align-middle" width="15%">Item Number</th>
                            <th class="align-middle" width="30%">Station</th>
                            <th class="align-middle" width="20%">Date Vacated</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $result = vacantItems(); // Get all open vacancies
                        $hasVacancies = numRows($result) > 0;
                        while ($row = fetchArray($result)):
                            $isChecked = in_array($row['id'], $selectedVacancyIds) ? 'checked' : '';
                            ?>
                            <tr class="text-uppercase">
                                <td class="align-middle">
                                    <input type="checkbox" class="vacancy-checkbox" name="vacancy_ids[]"
                                        value="<?= e($row['id']) ?>" <?= e($isChecked) ?>>
                                </td>
                                <td class="align-middle font-weight-bold text-left"><?= e($row['position']) ?></td>
                                <td class="align-middle"><?= toHandleNull($row['item_number'], 'N/A') ?></td>
                                <td class="align-middle">
                                    <?php if (empty($row['station_id'])) {
                                        echo '<span class="text-muted small">TO BE DETERMINED</span>';
                                    } else {
                                        $school = fetchAssoc(schoolById($row['station_id']));
                                        echo $school ? $school['name'] : '<span class="text-muted small">Unknown</span>';
                                    } ?>
                                </td>
                                <td class="align-middle"><?= toLongDate($row['date_vacated']) ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>

            <?php if ($hasVacancies): ?>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <span id="selected-count"><?= count($selectedVacancyIds) ?></span> item(s) selected
                    </span>
                    <button class="btn btn-primary btn-lg" name="<?= e($formAction) ?>" type="submit">
                        <i class="fas <?= e($btnIcon) ?> fa-fw mr-1"></i>
                        <?= e($btnText) ?>
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    No open vacancies available to publish.
                </div>
            <?php endif; ?>

            <?php requiredLegend(0) ?>
        </form>
    </div>
</div>

<script>
    // Select all checkbox
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.vacancy-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    // Update count on individual checkbox change
    document.querySelectorAll('.vacancy-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });

    function updateSelectedCount() {
        const count = document.querySelectorAll('.vacancy-checkbox:checked').length;
        document.getElementById('selected-count').textContent = count;
    }
</script>