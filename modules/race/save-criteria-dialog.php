<?php
// modules/race/save-criteria-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$awardId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$criteria = $award ? trim($award['criteria'] ?? '') : '';
$awardName = $award ? $award['name'] : 'Award';

$isTableMode = (strpos($criteria, '<thead') !== false);
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php modalHeader('Edit Criteria — ' . e($awardName)); ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <input type="hidden" name="criteria_mode" id="criteria_mode"
                    value="<?= $isTableMode ? 'table' : 'text' ?>">
                <input type="hidden" name="criteria" id="criteria_hidden" value="">

                <div class="btn-group mb-3 w-100" role="group">
                    <button type="button" class="btn btn-outline-primary <?= !$isTableMode ? 'active' : '' ?>"
                        id="btn-text-mode" onclick="switchCriteriaMode('text')">
                        <i class="fas fa-font fa-fw"></i> Text Only
                    </button>
                    <button type="button" class="btn btn-outline-primary <?= $isTableMode ? 'active' : '' ?>"
                        id="btn-table-mode" onclick="switchCriteriaMode('table')">
                        <i class="fas fa-table fa-fw"></i> Table
                    </button>
                </div>

                <!-- Text Mode -->
                <div id="text-mode" class="criteria-mode-section" style="<?= !$isTableMode ? '' : 'display:none;' ?>">
                    <small class="text-muted d-block mb-2">Enter the criteria and guidelines for this award. Line breaks
                        will be preserved.</small>
                    <textarea id="criteria_text" class="form-control" rows="12"
                        placeholder="Enter nomination criteria and guidelines for <?= e($awardName) ?>..."><?= $isTableMode ? '' : e($criteria) ?></textarea>
                </div>

                <!-- Table Mode -->
                <div id="table-mode" class="criteria-mode-section" style="<?= $isTableMode ? '' : 'display:none;' ?>">
                    <small class="text-muted d-block mb-2">Build a criteria table. Click cells to edit content.</small>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableRow()"><i
                                class="fas fa-plus fa-fw"></i> Add Row</button>
                        <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableColumn()"><i
                                class="fas fa-plus fa-fw"></i> Add Column</button>
                        <button type="button" class="btn btn-sm btn-danger mr-1" onclick="removeCriteriaTableRow()"><i
                                class="fas fa-minus fa-fw"></i> Remove Row</button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeCriteriaTableColumn()"><i
                                class="fas fa-minus fa-fw"></i> Remove Column</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="criteria_table">
                            <?php if ($isTableMode): ?>
                                <?= $criteria ?>
                            <?php else: ?>
                                <thead>
                                    <tr>
                                        <th contenteditable="true">Criterion</th>
                                        <th contenteditable="true">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td contenteditable="true">&nbsp;</td>
                                        <td contenteditable="true">&nbsp;</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="save-criteria" type="submit"
                    onclick="prepareCriteriaSubmit()">Save Criteria</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>

<script>
    function switchCriteriaMode(mode) {
        document.getElementById('criteria_mode').value = mode;
        const btnText = document.getElementById('btn-text-mode');
        const btnTable = document.getElementById('btn-table-mode');
        const textSection = document.getElementById('text-mode');
        const tableSection = document.getElementById('table-mode');

        if (mode === 'text') {
            btnText.classList.add('active');
            btnTable.classList.remove('active');
            textSection.style.display = '';
            tableSection.style.display = 'none';
        } else {
            btnText.classList.remove('active');
            btnTable.classList.add('active');
            textSection.style.display = 'none';
            tableSection.style.display = '';
        }
    }

    function addCriteriaTableRow() {
        const table = document.getElementById('criteria_table');
        const tbody = table.querySelector('tbody') || table;
        const headerRow = table.querySelector('thead tr');
        const colCount = headerRow ? headerRow.children.length : 2;

        const tr = document.createElement('tr');
        for (let i = 0; i < colCount; i++) {
            const td = document.createElement('td');
            td.setAttribute('contenteditable', 'true');
            td.innerHTML = '&nbsp;';
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }

    function addCriteriaTableColumn() {
        const table = document.getElementById('criteria_table');
        const theadRow = table.querySelector('thead tr');
        if (theadRow) {
            const th = document.createElement('th');
            th.setAttribute('contenteditable', 'true');
            th.innerText = 'New Column';
            theadRow.appendChild(th);
        }
        const tbodyRows = table.querySelectorAll('tbody tr');
        tbodyRows.forEach(row => {
            const td = document.createElement('td');
            td.setAttribute('contenteditable', 'true');
            td.innerHTML = '&nbsp;';
            row.appendChild(td);
        });
    }

    function removeCriteriaTableRow() {
        const table = document.getElementById('criteria_table');
        const tbodyRows = table.querySelectorAll('tbody tr');
        if (tbodyRows.length > 1) {
            tbodyRows[tbodyRows.length - 1].remove();
        }
    }

    function removeCriteriaTableColumn() {
        const table = document.getElementById('criteria_table');
        const theadRow = table.querySelector('thead tr');
        if (theadRow && theadRow.children.length > 1) {
            theadRow.lastElementChild.remove();
            const tbodyRows = table.querySelectorAll('tbody tr');
            tbodyRows.forEach(row => {
                if (row.children.length > 1) {
                    row.lastElementChild.remove();
                }
            });
        }
    }

    function prepareCriteriaSubmit() {
        const mode = document.getElementById('criteria_mode').value;
        const hiddenInput = document.getElementById('criteria_hidden');
        if (mode === 'text') {
            hiddenInput.value = document.getElementById('criteria_text').value;
        } else {
            const table = document.getElementById('criteria_table');
            hiddenInput.value = table.innerHTML;
        }
    }
</script>