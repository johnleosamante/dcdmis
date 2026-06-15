<?php
// modules/vacancies/publish-vacancies.php

if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);

$publication = null;
$selectedVacancyIds = [];
$isEdit = false;

if (isset($_GET['id'])) {
    $pubId = sanitize(decipher($_GET['id']));
    if ($pubId) {
        $publication = publication($pubId);
        if ($publication) {
            $isEdit = true;
            $items = publicationItems($pubId);
            foreach ($items as $item) {
                $selectedVacancyIds[] = $item['vacancy_id'];
            }
        }
    }
}

$currentBreadCrumb = ($isEdit ? 'Edit' : 'Create');
$pageTitle = "{$currentBreadCrumb} Call for Application";
$btnText = ($isEdit ? 'Update' : 'Save') . ' Call for Application';
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "$baseUri/$activeApp" ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Call for Applications') ?>">Call for
                    Applications</a></li>
            <li class="breadcrumb-item active"><?= e($currentBreadCrumb) ?></li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink($pageTitle, customUri('hrmis', 'Call for Applications')) ?>
    </div>

    <div class="card-body">
        <form method="POST">
            <?= csrf_field(); ?>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="pub-title" class="font-weight-bold">Title <?php showAsterisk() ?></label>
                        <input type="text" id="pub-title" name="pub_title" class="form-control"
                            placeholder="e.g., Teaching Positions for SY <?= date('Y') . '-' . date('Y', strtotime('+1 year')) ?>"
                            value="<?= $isEdit ? $publication['title'] : '' ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="pub-description" class="font-weight-bold">Description</label>
                        <textarea id="pub-description" name="pub_description" class="form-control" rows="5"
                            placeholder="Brief description of this publication..."><?= $isEdit ? $publication['description'] : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
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

            <?php requiredLegend() ?>

            <hr class="mt-0 mb-3">

            <h5 class="font-weight-bold mb-3">
                Select Vacancies to Include
            </h5>

            <div class="my-2 p-3 rounded alert-info small text-left d-flex mb-3">
                <span class="d-inline-block m-2">
                    <i class="fas fa-info-circle fa-2x"></i>
                </span>
                <span class="ml-2 d-inline-block d-flex align-items-center">
                    <div>
                        <?php if ($isEdit): ?>
                            Check the vacancies you want to include in this publication. You can select previously added
                            vacancies
                            or new unpublished vacancies.
                        <?php else: ?>
                            Check the vacancies you want to include in this publication. Only open vacancies that have not
                            been
                            published yet are available.
                        <?php endif; ?>
                    </div>
                </span>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">
                                <input type="checkbox" id="select-all" title="Select All">
                            </th>
                            <th class="align-middle" width="20%">Position</th>
                            <th class="align-middle" width="25%">Item Number</th>
                            <th class="align-middle" width="35%">Station</th>
                            <th class="align-middle" width="15%">Date Vacated</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Get vacancies based on whether creating or updating publication
                        $result = $isEdit ? vacantItemsForUpdate($publication['id']) : vacantItems();
                        $hasVacancies = count($result) > 0;
                        foreach ($result as $row):
                            $isChecked = in_array($row['id'], $selectedVacancyIds) ? 'checked' : '';
                            $isPublished = !$isEdit && isVacancyPublished($row['id']);
                            $isDisabled = $isPublished ? 'disabled' : '';
                            ?>
                            <tr class="text-uppercase <?= $isPublished ? 'table-secondary' : '' ?>">
                                <td class="align-middle">
                                    <input type="checkbox" class="vacancy-checkbox" name="vacancy_ids[]"
                                        value="<?= e($row['id']) ?>" <?= e($isChecked) ?>     <?= e($isDisabled) ?>>
                                </td>
                                <td class="align-middle">
                                    <?= e(positions($row['position_id'])['official_title']) ?>
                                </td>
                                <td class="align-middle"><?= toHandleNull($row['item_number'], 'N/A') ?></td>
                                <td class="align-middle">
                                    <?php if (empty($row['station_id'])) {
                                        echo '<span class="text-muted small">TO BE DETERMINED</span>';
                                    } else {
                                        $school = schoolById($row['station_id']);
                                        echo $school ? $school['name'] : '<span class="text-muted small">Unknown</span>';
                                    } ?>
                                </td>
                                <td class="align-middle"><?= toLongDate($row['date_vacated']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <?php if ($hasVacancies): ?>
                <div class="d-flex justify-content-between align-items-center">
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="verifier" value="<?= cipher($publication['id']) ?>">
                    <?php endif; ?>
                    <span class="text-muted small">
                        <span id="selected-count"><?= count($selectedVacancyIds) ?></span> item(s) selected
                    </span>
                    <button class="btn btn-primary" name="save-publication" type="submit">
                        <?= e($btnText) ?>
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    No open vacancies available to publish.
                </div>
            <?php endif; ?>
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