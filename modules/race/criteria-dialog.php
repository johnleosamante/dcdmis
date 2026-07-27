<?php
// modules/race/criteria-dialog.php
// Combined: view criteria, edit award criteria (text/table), edit ranking criteria
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$mode = $_GET['mode'] ?? 'view';
$awardId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
if (!$awardId) {
    $awardId = isset($_GET['award_id']) ? sanitize(decipher($_GET['award_id'])) : null;
}

$award = $awardId ? recognitionAward($awardId) : null;
$awardName = $award ? $award['name'] : 'Award';

// ── MODE: view ──────────────────────────────────────────────
if ($mode === 'view'):
    $criteria = rankingCriteriaByAward($awardId);
    $totalMax = 0;
    foreach ($criteria as $cr) { $totalMax += floatval($cr['max_points']); }
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php modalHeader('Criteria — ' . e($awardName)); ?>
            <div class="modal-body">
                <?php if (!empty($criteria)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="criteria-table" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width:60px;">#</th>
                                    <th>Criterion</th>
                                    <th class="text-center" style="width:140px;">Max Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($criteria as $cr): ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $i++ ?></td>
                                        <td class="align-middle"><?= e($cr['criterion_name']) ?></td>
                                        <td class="text-center align-middle font-weight-bold"><?= e(number_format($cr['max_points'], 2)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-active font-weight-bold">
                                    <td colspan="2" class="text-right">Total Maximum Points:</td>
                                    <td class="text-center"><?= e(number_format($totalMax, 2)) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <div class="text-muted mb-2" style="font-size:2rem;"><i class="fas fa-exclamation-circle"></i></div>
                        <p class="text-muted">No ranking criteria has been set for this award yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </div>
    </div>
    <script>
    (function(){var t=document.getElementById('criteria-table');if(t&&typeof jQuery!=='undefined'){jQuery(t).DataTable({responsive:true,paging:false,searching:false,info:false,order:[],autoWidth:false});}})();
    </script>

<?php
// ── MODE: edit-criteria (text/table editor for award.criteria column) ──────
elseif ($mode === 'edit-criteria'):
    $criteria = $award ? trim($award['criteria'] ?? '') : '';
    $isTableMode = (strpos($criteria, '<table') !== false);
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php modalHeader('Edit Criteria — ' . e($awardName)); ?>
            <form action="" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                    <input type="hidden" name="criteria_mode" id="criteria_mode" value="<?= $isTableMode ? 'table' : 'text' ?>">
                    <input type="hidden" name="criteria" id="criteria_hidden" value="">
                    <div class="btn-group mb-3 w-100" role="group">
                        <button type="button" class="btn btn-outline-primary <?= !$isTableMode ? 'active' : '' ?>" id="btn-text-mode" onclick="switchCriteriaMode('text')">
                            <i class="fas fa-font fa-fw"></i> Text Only
                        </button>
                        <button type="button" class="btn btn-outline-primary <?= $isTableMode ? 'active' : '' ?>" id="btn-table-mode" onclick="switchCriteriaMode('table')">
                            <i class="fas fa-table fa-fw"></i> Table
                        </button>
                    </div>
                    <div id="text-mode" class="criteria-mode-section" style="<?= !$isTableMode ? '' : 'display:none;' ?>">
                        <small class="text-muted d-block mb-2">Enter the criteria and guidelines for this award. Line breaks will be preserved.</small>
                        <textarea id="criteria_text" class="form-control" rows="12" placeholder="Enter nomination criteria and guidelines for <?= e($awardName) ?>..."><?= $isTableMode ? '' : e($criteria) ?></textarea>
                    </div>
                    <div id="table-mode" class="criteria-mode-section" style="<?= $isTableMode ? '' : 'display:none;' ?>">
                        <small class="text-muted d-block mb-2">Build a criteria table. Click cells to edit content.</small>
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableRow()"><i class="fas fa-plus fa-fw"></i> Add Row</button>
                            <button type="button" class="btn btn-sm btn-success mr-1" onclick="addCriteriaTableColumn()"><i class="fas fa-plus fa-fw"></i> Add Column</button>
                            <button type="button" class="btn btn-sm btn-danger mr-1" onclick="removeCriteriaTableRow()"><i class="fas fa-minus fa-fw"></i> Remove Row</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCriteriaTableColumn()"><i class="fas fa-minus fa-fw"></i> Remove Column</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="criteria_table">
                                <?php if ($isTableMode): ?>
                                    <?= $criteria ?>
                                <?php else: ?>
                                    <thead><tr><th contenteditable="true">Criterion</th><th contenteditable="true">Description</th></tr></thead>
                                    <tbody><tr><td contenteditable="true">&nbsp;</td><td contenteditable="true">&nbsp;</td></tr></tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" name="save-criteria" type="submit" onclick="prepareCriteriaSubmit()">Save Criteria</button>
                    <?php cancelModalButton() ?>
                </div>
            </form>
        </div>
    </div>
    <script>
    function switchCriteriaMode(mode){
        document.getElementById('text-mode').style.display=mode==='text'?'':'none';
        document.getElementById('table-mode').style.display=mode==='table'?'':'none';
        document.getElementById('criteria_mode').value=mode;
        document.getElementById('btn-text-mode').classList.toggle('active',mode==='text');
        document.getElementById('btn-table-mode').classList.toggle('active',mode==='table');
    }
    function addCriteriaTableRow(){
        var t=document.getElementById('criteria_table');
        var cols=t.rows[0].cells.length;
        var r=t.insertRow(-1);
        for(var i=0;i<cols;i++){var c=r.insertCell(i);c.contentEditable=true;c.innerHTML='&nbsp;';}
    }
    function addCriteriaTableColumn(){
        var t=document.getElementById('criteria_table');
        for(var i=0;i<t.rows.length;i++){
            var c=t.rows[i].insertCell(-1);
            if(i===0){c.outerHTML='<th contenteditable="true">&nbsp;</th>';}
            else{c.contentEditable=true;c.innerHTML='&nbsp;';}
        }
    }
    function removeCriteriaTableRow(){
        var t=document.getElementById('criteria_table');
        if(t.rows.length>2)t.deleteRow(-1);
    }
    function removeCriteriaTableColumn(){
        var t=document.getElementById('criteria_table');
        if(t.rows[0].cells.length>1)for(var i=0;i<t.rows.length;i++)t.rows[i].deleteCell(-1);
    }
    function prepareCriteriaSubmit(){
        var mode=document.getElementById('criteria_mode').value;
        if(mode==='text'){
            document.getElementById('criteria_hidden').value=document.getElementById('criteria_text').value;
        }else{
            document.getElementById('criteria_hidden').value=document.getElementById('criteria_table').outerHTML;
        }
    }
    </script>

<?php
// ── MODE: edit-ranking (ranking criteria with points) ──────────────────────
elseif ($mode === 'edit-ranking'):
    $existingCriteria = $awardId ? rankingCriteriaByAward($awardId) : [];
    $criteriaLibrary = rankingCriteriaLibrary();
    $existingByName = [];
    foreach ($existingCriteria as $criterion) {
        $existingByName[strtolower(trim($criterion['criterion_name']))] = $criterion;
    }
    $customCriteria = [];
    foreach ($existingCriteria as $criterion) {
        if (!rankingCriteriaLibraryIdByName($criterion['criterion_name'])) {
            $customCriteria[] = $criterion;
        }
    }
    ?>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <?php modalHeader('Ranking Criteria — ' . e($awardName)); ?>
            <form action="" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle text-primary mt-1 mr-2"></i>
                            <div>
                                <div class="font-weight-bold text-dark">Set the criteria for this award</div>
                                <div class="small text-muted">Select criteria from the shared list and assign the maximum points. You may add a new criterion if it is not listed.</div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($existingCriteria)): ?>
                        <div class="card border mb-4">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-pen-to-square fa-fw mr-1"></i> Current Criteria for this Award</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Criterion</th>
                                            <th class="text-center" style="width:140px;">Max Points</th>
                                            <th class="text-center" style="width:120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($existingCriteria as $cr): ?>
                                            <tr id="criterion-row-<?= e($cr['id']) ?>">
                                                <td class="align-middle">
                                                    <span class="criterion-display"><?= e($cr['criterion_name']) ?></span>
                                                    <input type="text" class="form-control form-control-sm criterion-edit d-none" value="<?= e($cr['criterion_name']) ?>">
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="criterion-points-display font-weight-bold"><?= e(number_format($cr['max_points'], 2)) ?></span>
                                                    <input type="number" class="form-control form-control-sm text-center criterion-points-edit d-none" value="<?= e($cr['max_points']) ?>" min="0" step="any">
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-primary criterion-edit-btn" onclick="
                                                        var row=this.closest('tr');
                                                        row.querySelector('.criterion-display').classList.add('d-none');
                                                        row.querySelector('.criterion-points-display').classList.add('d-none');
                                                        row.querySelector('.criterion-edit').classList.remove('d-none');
                                                        row.querySelector('.criterion-points-edit').classList.remove('d-none');
                                                        this.classList.add('d-none');
                                                        row.querySelector('.criterion-save-btn').classList.remove('d-none');
                                                    "><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-success criterion-save-btn d-none" onclick="
                                                        var row=this.closest('tr');
                                                        var id='<?= e($cr['id']) ?>';
                                                        var name=row.querySelector('.criterion-edit').value;
                                                        var pts=row.querySelector('.criterion-points-edit').value;
                                                        var f=document.createElement('form');
                                                        f.method='POST';
                                                        f.action='';
                                                        f.innerHTML='<input type=&quot;hidden&quot; name=&quot;csrf_token&quot; value=&quot;<?= csrf_token() ?>&quot;><input type=&quot;hidden&quot; name=&quot;update-criterion&quot; value=&quot;1&quot;><input type=&quot;hidden&quot; name=&quot;criterion_id&quot; value=&quot;'+id+'&quot;><input type=&quot;hidden&quot; name=&quot;criterion_name&quot; value=&quot;'+name+'&quot;><input type=&quot;hidden&quot; name=&quot;max_points&quot; value=&quot;'+pts+'&quot;>';
                                                        document.body.appendChild(f);
                                                        f.submit();
                                                    "><i class="fas fa-check"></i></button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="
                                                        var id='<?= e($cr['id']) ?>';
                                                        var f=document.createElement('form');
                                                        f.method='POST';
                                                        f.action='';
                                                        f.innerHTML='<input type=&quot;hidden&quot; name=&quot;csrf_token&quot; value=&quot;<?= csrf_token() ?>&quot;><input type=&quot;hidden&quot; name=&quot;delete-criterion&quot; value=&quot;1&quot;><input type=&quot;hidden&quot; name=&quot;criterion_id&quot; value=&quot;'+id+'&quot;>';
                                                        document.body.appendChild(f);
                                                        f.submit();
                                                    "><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($criteriaLibrary)): ?>
                        <div class="card border mb-4">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-list-check fa-fw mr-1"></i> Available Criteria</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width:80px;">Use</th>
                                            <th>Criterion</th>
                                            <th class="text-center" style="width:180px;">Maximum Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($criteriaLibrary as $libraryCriterion):
                                            $libraryName = strtolower(trim($libraryCriterion['criterion_name']));
                                            $awardCriterion = $existingByName[$libraryName] ?? null;
                                        ?>
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" class="position-static" name="library_criterion_id[]" value="<?= e($libraryCriterion['id']) ?>" <?= $awardCriterion ? 'checked' : '' ?> aria-label="Use <?= e($libraryCriterion['criterion_name']) ?>">
                                                </td>
                                                <td class="align-middle font-weight-bold text-dark"><?= e($libraryCriterion['criterion_name']) ?></td>
                                                <td class="align-middle">
                                                    <input type="number" class="form-control form-control-sm text-center" name="library_max_points[<?= e($libraryCriterion['id']) ?>]" value="<?= e($awardCriterion['max_points'] ?? $libraryCriterion['default_max_points']) ?>" min="0" step="any" aria-label="Maximum points for <?= e($libraryCriterion['criterion_name']) ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card border">
                        <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-plus-circle fa-fw mr-1"></i> Additional Criteria</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="
                                var list=document.getElementById('criteria-list');
                                var div=document.createElement('div');
                                div.className='form-row align-items-end mb-2 criteria-row';
                                var col1=document.createElement('div');
                                col1.className='col';
                                col1.innerHTML='<label class=&quot;small text-muted mb-1&quot;>Criterion Name</label><input type=&quot;text&quot; class=&quot;form-control&quot; name=&quot;criterion_name[]&quot; placeholder=&quot;e.g. Teaching Effectiveness&quot; required>';
                                var col2=document.createElement('div');
                                col2.className='col-md-3';
                                col2.innerHTML='<label class=&quot;small text-muted mb-1&quot;>Maximum Points</label><input type=&quot;number&quot; class=&quot;form-control&quot; name=&quot;max_points[]&quot; min=&quot;0&quot; step=&quot;any&quot; required>';
                                var col3=document.createElement('div');
                                col3.className='col-auto';
                                var btn=document.createElement('button');
                                btn.type='button';
                                btn.className='btn btn-outline-danger';
                                btn.title='Remove criterion';
                                btn.onclick=function(){this.closest('.criteria-row').remove();};
                                btn.innerHTML='<i class=&quot;fas fa-trash-alt&quot;></i>';
                                col3.appendChild(btn);
                                div.appendChild(col1);
                                div.appendChild(col2);
                                div.appendChild(col3);
                                list.appendChild(div);
                            "><i class="fas fa-plus fa-fw"></i> Add Criterion</button>
                        </div>
                        <div class="card-body" id="criteria-list">
                            <?php if (!empty($customCriteria)): ?>
                                <?php foreach ($customCriteria as $cr): ?>
                                    <div class="form-row align-items-end mb-2 criteria-row">
                                        <div class="col">
                                            <label class="small text-muted mb-1">Criterion Name</label>
                                            <input type="text" class="form-control" name="criterion_name[]" value="<?= e($cr['criterion_name']) ?>" placeholder="e.g. Teaching Effectiveness" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted mb-1">Maximum Points</label>
                                            <input type="number" class="form-control" name="max_points[]" value="<?= e($cr['max_points']) ?>" min="0" step="any" required>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-outline-danger" onclick="this.closest('.criteria-row').remove();" title="Remove criterion"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted small mb-0">No additional criteria have been added. Use the button above to add one.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <?php cancelModalButton() ?>
                    <button class="btn btn-primary" name="save-ranking-criteria" type="submit"><i class="fas fa-save fa-fw mr-1"></i> Save Criteria</button>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>
    <div class="modal-dialog"><div class="modal-content">
        <?php modalHeader('Error'); ?>
        <div class="modal-body"><p>Invalid criteria mode.</p></div>
        <div class="modal-footer"><?php cancelModalButton() ?></div>
    </div></div>
<?php endif; ?>
