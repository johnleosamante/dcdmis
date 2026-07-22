<?php
// modules/race/page.php
if (!$isRace) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$nominatorOnly = isNominatorOnly($userId);

$view = $_GET['view'] ?? 'schedules';
if (isset($url)) {
    if ($url === 'Event Schedules') {
        $view = 'schedules';
    } elseif ($url === 'Awards List') {
        $view = 'awards';
    } elseif ($url === 'Nominees List') {
        $view = 'nominees';
    } elseif ($url === 'Winners Lookup') {
        $view = 'winners';
    } elseif ($url === 'Ranking') {
        $view = 'ranking';
    }
}

if ($nominatorOnly && in_array($view, ['schedules', 'winners', 'ranking'])) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$scheduleId = isset($_GET['schedule_id']) ? sanitize(decipher($_GET['schedule_id'])) : null;
$schedule = null;

if ($scheduleId && $view === 'schedules') {
    $schedule = awardSchedule($scheduleId);
    if (!$schedule) {
        require_once(root() . '/modules/error/no-results-found.php');
        return;
    }
}

$awardId = isset($_GET['award_id']) ? sanitize(decipher($_GET['award_id'])) : null;
$award = null;

if ($scheduleId && $awardId && $view === 'schedules') {
    $award = recognitionAward($awardId);
    if (!$award) {
        require_once(root() . '/modules/error/no-results-found.php');
        return;
    }
}

// Generate query string links that preserve existing GET parameters
$currentParams = $_GET;
unset($currentParams['schedule_id']);
unset($currentParams['award_id']);
$backToSchedulesUrl = uri() . '/race?' . http_build_query($currentParams);

$currentParamsWithSched = $_GET;
unset($currentParamsWithSched['award_id']);
$backToAwardsUrl = uri() . '/race?' . http_build_query($currentParamsWithSched);

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <?php if ($view === 'awards'): ?>
                <li class="breadcrumb-item active">Awards</li>
            <?php elseif ($view === 'nominees'): ?>
                <li class="breadcrumb-item active">Nominees</li>
            <?php elseif ($view === 'winners'): ?>
                <li class="breadcrumb-item active">Winner</li>
            <?php elseif ($view === 'ranking'): ?>
                <li class="breadcrumb-item active">Ranking</li>
            <?php else: ?>
                <?php if ($scheduleId): ?>
                    <li class="breadcrumb-item"><a href="<?= $backToSchedulesUrl ?>">Awards and Recognitions</a></li>
                    <?php if ($awardId): ?>
                        <li class="breadcrumb-item"><a href="<?= $backToAwardsUrl ?>"><?= e($schedule['title']) ?></a></li>
                        <li class="breadcrumb-item active"><?= e($award['name']) ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item active"><?= e($schedule['title']) ?></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="breadcrumb-item active">Awards and Recognitions</li>
                <?php endif; ?>
            <?php endif; ?>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <?php if ($view === 'schedules'): ?>
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <div>
                <?php if ($scheduleId): ?>
                    <?php if ($awardId): ?>
                        <?php modalButtonSplit(uri() . '/modules/race/nominate-reminder-dialog.php?e=' . cipher($scheduleId) . '&award_id=' . cipher($awardId), 'Add Nominee', 'fa-plus', 'Add Nominee') ?>
                        <a href="<?= $backToAwardsUrl ?>" class="btn btn-secondary btn-sm ml-2">
                            <i class="fas fa-arrow-left fa-fw"></i> Back to Awards
                        </a>
                    <?php else: ?>
                        <a href="<?= $backToSchedulesUrl ?>" class="btn btn-secondary btn-sm ml-2">
                            <i class="fas fa-arrow-left fa-fw"></i> Back to Events
                        </a>
                        <?php if (!$nominatorOnly): ?>
                            <?php modalButtonSplit(uri() . '/modules/race/save-award-dialog.php?e=' . cipher($scheduleId), 'Add Award', 'fa-plus', 'Add Award') ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (!$nominatorOnly): ?>
                        <?php modalButtonSplit(uri() . '/modules/race/save-schedule-dialog.php', 'Add Year', 'fa-calendar-plus', 'Add Year') ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if ($scheduleId): ?>
                <span class="badge badge-primary font-weight-bold text-uppercase p-2 text-xs">
                    Event: <?= e($schedule['title']) ?>
                </span>
            <?php endif; ?>
        </div>
    <?php elseif ($view === 'awards'): ?>
        <?php if (!$nominatorOnly): ?>
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <div>
                    <?php modalButtonSplit(uri() . '/modules/race/save-award-dialog.php', 'Add Award', 'fa-plus', 'Add Award') ?>
                </div>
            </div>
        <?php endif; ?>
    <?php elseif ($view === 'nominees'): ?>
        <div class="card-header py-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <?php modalButtonSplit(uri() . '/modules/race/nominate-select-schedule-dialog.php', 'Nominate', 'fa-user-plus', 'Nominate') ?>
                </div>
            </div>
            <?php
            $nomFilterSched = isset($_GET['nom_sched_id']) ? sanitize($_GET['nom_sched_id']) : '';
            $nomFilterAward = isset($_GET['nom_award_id']) ? sanitize($_GET['nom_award_id']) : '';
            $nomFilterLevel = isset($_GET['nom_level']) ? sanitize($_GET['nom_level']) : '';
            ?>
            <form action="" method="GET" class="row align-items-end">
                <input type="hidden" name="v" value="<?= isset($_GET['v']) ? e($_GET['v']) : '' ?>">
                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? e($_GET['id']) : '' ?>">
                <input type="hidden" name="view" value="nominees">

                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Event Schedule</label>
                    <select name="nom_sched_id" class="form-control form-control-sm">
                        <option value="">All Events</option>
                        <?php
                        $nomScheds = awardSchedules();
                        foreach ($nomScheds as $ns): ?>
                            <option value="<?= e($ns['id']) ?>" <?= setOptionSelected($ns['id'], $nomFilterSched) ?>>
                                <?= e($ns['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Award</label>
                    <select name="nom_award_id" class="form-control form-control-sm">
                        <option value="">All Awards</option>
                        <?php
                        $nomAwds = recognitionAwardsWithCategory();
                        foreach ($nomAwds as $na): ?>
                            <option value="<?= e($na['id']) ?>" <?= setOptionSelected($na['id'], $nomFilterAward) ?>>
                                <?= e($na['name']) ?> (<?= e($na['category_name']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Level</label>
                    <select name="nom_level" class="form-control form-control-sm">
                        <option value="">All Levels</option>
                        <option value="Elementary" <?= setOptionSelected('Elementary', $nomFilterLevel) ?>>Elementary
                        </option>
                        <option value="Secondary" <?= setOptionSelected('Secondary', $nomFilterLevel) ?>>Secondary</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm btn-block" type="submit">
                        <i class="fas fa-filter fa-fw"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    <?php elseif ($view === 'winners'): ?>
        <div class="card-header py-3 bg-light">
            <?php
            $selectedAwardId = isset($_GET['winner_award_id']) ? sanitize($_GET['winner_award_id']) : '';
            $needsLevelLookup = false;
            if (!empty($selectedAwardId)) {
                $selAwardObj = recognitionAward($selectedAwardId);
                if ($selAwardObj) {
                    $needsLevelLookup = isset($selAwardObj['has_level']) && (int) $selAwardObj['has_level'] === 1;
                }
            }
            $gridClass = $needsLevelLookup ? 'col-md-4' : 'col-md-5';
            ?>
            <form action="" method="GET" class="row align-items-end">
                <input type="hidden" name="v" value="<?= isset($_GET['v']) ? e($_GET['v']) : '' ?>">
                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? e($_GET['id']) : '' ?>">
                <input type="hidden" name="view" value="winners">

                <div class="grid-adjust <?= $gridClass ?> mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Choose Year / Event</label>
                    <select name="winner_sched_id" class="form-control form-control-sm" required>
                        <option value="">Select Event Year...</option>
                        <?php
                        $scheds = awardSchedules();
                        $selectedSchedId = isset($_GET['winner_sched_id']) ? sanitize($_GET['winner_sched_id']) : '';
                        foreach ($scheds as $sc): ?>
                            <option value="<?= e($sc['id']) ?>" <?= setOptionSelected($sc['id'], $selectedSchedId) ?>>
                                <?= e($sc['title']) ?> (<?= toLongDate($sc['date']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid-adjust <?= $gridClass ?> mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Choose Award</label>
                    <select name="winner_award_id" id="winner_award_id" class="form-control form-control-sm" required>
                        <option value="">Select Award...</option>
                        <?php
                        $awds = recognitionAwardsWithCategory();
                        foreach ($awds as $aw): ?>
                            <option value="<?= e($aw['id']) ?>" <?= setOptionSelected($aw['id'], $selectedAwardId) ?>>
                                <?= e($aw['name']) ?> (<?= e($aw['category_name']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 mb-2 mb-md-0" id="level-lookup-container"
                    style="display: <?= $needsLevelLookup ? 'block' : 'none' ?>;">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Choose Level</label>
                    <select name="winner_level" id="winner_level" class="form-control form-control-sm" <?= $needsLevelLookup ? 'required' : '' ?>>
                        <option value="">Select Level...</option>
                        <option value="Elementary" <?= setOptionSelected('Elementary', $_GET['winner_level'] ?? '') ?>>
                            Elementary</option>
                        <option value="Secondary" <?= setOptionSelected('Secondary', $_GET['winner_level'] ?? '') ?>>
                            Secondary</option>
                        <option value="Integrated" <?= setOptionSelected('Integrated', $_GET['winner_level'] ?? '') ?>>
                            Integrated</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm btn-block" type="submit">
                        <i class="fas fa-search fa-fw"></i> Search
                    </button>
                </div>
            </form>
        </div>
    <?php elseif ($view === 'ranking'): ?>
        <?php
        $selectedRankSchedId = isset($_GET['rank_sched_id']) ? sanitize($_GET['rank_sched_id']) : '';
        $selectedRankAwardId = isset($_GET['rank_award_id']) ? sanitize($_GET['rank_award_id']) : '';
        $selectedRankLevel = isset($_GET['rank_level']) ? sanitize($_GET['rank_level']) : '';
        $isFinalized = ($selectedRankSchedId && $selectedRankAwardId) ? isRankingFinalized($selectedRankSchedId, $selectedRankAwardId, $selectedRankLevel ?: null) : false;
        $hasSavedRankings = ($selectedRankSchedId && $selectedRankAwardId) ? hasFinalRankings($selectedRankSchedId, $selectedRankAwardId, $selectedRankLevel ?: null) : false;
        ?>
        <div class="card-header py-3 bg-light">
            <form action="" method="GET" class="row align-items-end">
                <input type="hidden" name="v" value="<?= isset($_GET['v']) ? e($_GET['v']) : '' ?>">
                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? e($_GET['id']) : '' ?>">
                <input type="hidden" name="view" value="ranking">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Select Event / Year</label>
                    <select name="rank_sched_id" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">All Events...</option>
                        <?php
                        $rankSchedules = awardSchedules();
                        foreach ($rankSchedules as $rs): ?>
                            <option value="<?= e($rs['id']) ?>" <?= setOptionSelected($rs['id'], $selectedRankSchedId) ?>>
                                <?= e($rs['title']) ?> (<?= toLongDate($rs['date']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Select Award</label>
                    <select name="rank_award_id" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">Select Award...</option>
                        <?php
                        $rankAwards = awardsWithNominees($selectedRankSchedId ?: null);
                        foreach ($rankAwards as $ra): ?>
                            <option value="<?= e($ra['id']) ?>" <?= setOptionSelected($ra['id'], $selectedRankAwardId) ?>>
                                <?= e($ra['name']) ?> (<?= e($ra['nominee_count']) ?> nominees)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php
                $selectedRankAwardHasLevel = false;
                if ($selectedRankAwardId) {
                    $selectedRankAwardData = recognitionAward($selectedRankAwardId);
                    if ($selectedRankAwardData && (int) $selectedRankAwardData['has_level'] === 1) {
                        $selectedRankAwardHasLevel = true;
                    }
                }
                ?>
                <div class="col-md-3 mb-2 mb-md-0" <?= $selectedRankAwardHasLevel ? '' : ' style="display:none;"' ?>>
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Select Level</label>
                    <select name="rank_level" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">All Levels</option>
                        <option value="Elementary" <?= setOptionSelected('Elementary', $selectedRankLevel) ?>>Elementary
                        </option>
                        <option value="Secondary" <?= setOptionSelected('Secondary', $selectedRankLevel) ?>>Secondary
                        </option>
                        <option value="Integrated" <?= setOptionSelected('Integrated', $selectedRankLevel) ?>>Integrated
                        </option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 mb-md-0">
                    <button class="btn btn-primary btn-sm btn-block" type="submit">
                        <i class="fas fa-filter fa-fw"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="card-body">
        <div class="table-responsive">
            <?php if ($view === 'awards'): ?>
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-middle" width="50%">Award</th>
                            <th class="align-middle" width="35%">Category</th>
                            <?php if (!$nominatorOnly): ?>
                                <th class="align-middle" width="15%">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $awards = recognitionAwardsWithCategory();
                        if (!empty($awards)):
                            foreach ($awards as $aw): ?>
                                <tr>
                                    <td class="align-middle text-center font-weight-bold text-uppercase"><?= e($aw['name']) ?></td>
                                    <td class="align-middle text-center small text-uppercase"><?= e($aw['category_name']) ?></td>
                                    <?php if (!$nominatorOnly): ?>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php modalDropdownItem(uri() . '/modules/race/save-award-dialog.php?id=' . cipher($aw['id']), 'Edit Award', 'fa-edit', 'Edit Award'); ?>
                                                    <?php modalDropdownItem(uri() . '/modules/race/delete-award-dialog.php?id=' . cipher($aw['id']), 'Delete', 'fa-trash', 'Delete Award'); ?>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="<?= $nominatorOnly ? '2' : '3' ?>" class="text-center py-4">No awards found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <?php elseif ($view === 'nominees'): ?>

                <!-- GLOBAL NOMINEES VIEW TABLE -->
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-middle" width="10%">Status</th>
                            <th class="align-middle" width="25%">Nominee</th>
                            <th class="align-middle" width="12%">Level</th>
                            <th class="align-middle" width="22%">Award Information</th>
                            <th class="align-middle" width="18%">Event Schedule</th>
                            <?php if (!$nominatorOnly): ?>
                                <th class="align-middle" width="10%">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $allNominees = allNominees(
                            !empty($nomFilterSched) ? $nomFilterSched : null,
                            !empty($nomFilterAward) ? $nomFilterAward : null,
                            !empty($nomFilterLevel) ? $nomFilterLevel : null
                        );
                        if (!empty($allNominees)):
                            foreach ($allNominees as $nom):
                                $nomBadgeColor = 'warning';
                                if ($nom['status'] === 'Awarded') {
                                    $nomBadgeColor = 'success';
                                } elseif ($nom['status'] === 'Disqualified') {
                                    $nomBadgeColor = 'danger';
                                }
                                ?>
                                <tr>
                                    <td class="align-middle text-capitalize">
                                        <span class="badge badge-pill badge-<?= $nomBadgeColor ?>">
                                            <?= e($nom['status'] === 'Awarded' ? 'Winner' : $nom['status']) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-uppercase">
                                        <?php if (isset($nom['nominee_type']) && $nom['nominee_type'] === 'School'): ?>
                                            <div><strong><?= e($nom['school_name'] ?: 'Unknown School') ?></strong></div>
                                            <div class="text-muted small">School Code: <?= e($nom['nominee_id']) ?>
                                                (<?= e($nom['school_alias'] ?: 'N/A') ?>)</div>
                                        <?php else: ?>
                                            <?php if ($nom['last_name'] !== null): ?>
                                                <div>
                                                    <strong><?= toName($nom['last_name'], $nom['first_name'], $nom['middle_name'], $nom['name_extension']) ?></strong>
                                                </div>
                                                <div class="text-muted small"><?= e($nom['position']) ?></div>
                                            <?php else: ?>
                                                <div><strong>Nominee ID: <?= e($nom['nominee_id']) ?></strong></div>
                                                <div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee Record
                                                    Missing</div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($nom['nominated_by'])): ?>
                                            <div class="text-muted small mt-1"><i class="fas fa-user-tag fa-fw"></i> Nominated by
                                                <?= e($nom['nominator_first'] . ' ' . $nom['nominator_last']) ?>
                                                <?= !empty($nom['nominator_position']) ? ' (' . e($nom['nominator_position']) . ')' : '' ?>
                                                <?= !empty($nom['nominator_school']) ? ' — ' . e($nom['nominator_school']) : '' ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle font-weight-bold text-uppercase">
                                        <?php if ($nom['level']): ?>
                                            <span class="badge badge-secondary px-2 py-1 text-xs"><?= e($nom['level']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle small text-uppercase">
                                        <div><strong><?= e($nom['award_name']) ?></strong></div>
                                        <div class="text-muted small"><?= e($nom['category_name']) ?></div>
                                    </td>
                                    <td class="align-middle small text-uppercase font-weight-bold"><?= e($nom['schedule_title']) ?>
                                    </td>
                                    <?php if (!$nominatorOnly): ?>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php if ($raceAccess === 'admin'): ?>
                                                        <?php modalDropdownItem(uri() . '/modules/race/edit-nominator-dialog.php?id=' . cipher($nom['id']), 'Change Nominator', 'fa-user-edit', 'Change Nominator'); ?>
                                                        <div class="dropdown-divider"></div>
                                                    <?php endif; ?>
                                                    <?php if ($nom['status'] !== 'Disqualified'): ?>
                                                        <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nom['id']) . '&action=disqualify', 'Disqualify', 'fa-ban', 'Disqualify Nominee'); ?>
                                                    <?php endif; ?>

                                                    <div class="dropdown-divider"></div>
                                                    <?php modalDropdownItem(uri() . '/modules/race/delete-nominee-dialog.php?id=' . cipher($nom['id']), 'Delete', 'fa-trash', 'Delete Nominee'); ?>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="<?= $nominatorOnly ? '5' : '6' ?>" class="text-center py-4">No nominees found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <?php elseif ($view === 'winners'): ?>

                <!-- SEARCH RESULT -->
                <?php
                $selSched = isset($_GET['winner_sched_id']) ? sanitize($_GET['winner_sched_id']) : null;
                $selAward = isset($_GET['winner_award_id']) ? sanitize($_GET['winner_award_id']) : null;
                $selLevel = isset($_GET['winner_level']) ? sanitize($_GET['winner_level']) : null;

                if ($selSched && $selAward):
                    if ($needsLevelLookup && empty($selLevel)): ?>
                        <div class="py-4 text-center text-muted">
                            <div class="mb-3 text-info" style="font-size: 3rem;">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <h5>Please choose a level (Elementary / Secondary) above.</h5>
                            <p class="small">This award has separate winners for each level.</p>
                        </div>
                    <?php else:
                        $winner = awardWinnerByScheduleAndAward($selSched, $selAward, $selLevel);
                        if ($winner): ?>
                            <div class="p-4 text-center border-bottom">
                                <div class="display-4 text-warning mb-3">
                                    <i class="fas fa-trophy animate__animated animate__bounceIn"></i>
                                </div>
                                <?php if ($winner['level']): ?>
                                    <div class="mb-3">
                                        <span class="badge badge-pill badge-secondary text-uppercase px-3 py-1 text-xs">
                                            Level: <?= e($winner['level']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($winner['nominee_type']) && $winner['nominee_type'] === 'School'): ?>
                                    <h3 class="font-weight-bold text-success text-uppercase mb-1">
                                        <?= e($winner['school_name'] ?: 'Unknown School') ?>
                                    </h3>
                                    <p class="text-muted small text-uppercase font-weight-bold mb-3">School Code:
                                        <?= e($winner['nominee_id']) ?> (<?= e($winner['school_alias'] ?: 'N/A') ?>)
                                    </p>
                                <?php else: ?>
                                    <?php if ($winner['last_name'] !== null): ?>
                                        <h3 class="font-weight-bold text-success text-uppercase mb-1">
                                            <?= toName($winner['last_name'], $winner['first_name'], $winner['middle_name'], $winner['name_extension']) ?>
                                        </h3>
                                        <p class="text-muted small text-uppercase font-weight-bold mb-3"><?= e($winner['position']) ?></p>
                                    <?php else: ?>
                                        <h3 class="font-weight-bold text-danger text-uppercase mb-1">
                                            Nominee ID: <?= e($winner['nominee_id']) ?>
                                        </h3>
                                        <p class="text-danger small text-uppercase font-weight-bold mb-3"><i
                                                class="fas fa-exclamation-triangle"></i> Employee Record Missing</p>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <hr class="w-50 my-3">

                                <h5 class="text-dark font-weight-bold mb-1 text-uppercase"><?= e($winner['award_name']) ?></h5>
                                <span
                                    class="badge badge-pill badge-danger text-uppercase px-3 py-2 text-xs"><?= e($winner['category_name']) ?></span>

                                <div class="mt-4">
                                    <span class="text-muted small">Declared Winner on:</span>
                                    <div class="font-weight-bold text-dark"><?= toLongDate($winner['created_at']) ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="py-4 text-center text-muted border-bottom">
                                <div class="mb-3 text-gray-300" style="font-size: 2rem;">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <h6>No winner has been declared for this selection yet.</h6>
                                <p class="small">Go to <strong>Schedule &rarr; Choose Event &rarr; Select Award</strong> to declare a
                                    nominee as the winner.</p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- ALL WINNERS TABLE -->
                <?php $allWinners = awardWinners(); ?>
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-middle" width="5%">No.</th>
                            <th class="align-middle" width="30%">Winner</th>
                            <th class="align-middle" width="20%">Award</th>
                            <th class="align-middle" width="15%">Category</th>
                            <th class="align-middle" width="10%">Level</th>
                            <th class="align-middle" width="20%">Event Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allWinners)):
                            $winnerNum = 0;
                            foreach ($allWinners as $w):
                                $winnerNum++;
                                if (isset($w['nominee_type']) && $w['nominee_type'] === 'School'):
                                    $winnerName = $w['school_name'] ?: 'Unknown School';
                                    $winnerSub = $w['school_alias'] ?: '';
                                elseif ($w['last_name'] !== null):
                                    $winnerName = toName($w['last_name'], $w['first_name'], $w['middle_name'], $w['name_extension']);
                                    $winnerSub = $w['position'] ?? '';
                                else:
                                    $winnerName = 'ID: ' . $w['nominee_id'];
                                    $winnerSub = 'Record Missing';
                                endif;
                                $winnerDialogUrl = uri() . '/modules/race/view-winner-dialog.php?id=' . cipher($w['id']);
                                ?>
                                <tr style="cursor: pointer;" data-toggle="modal" data-target="#modal"
                                    onclick="loadData('<?= $winnerDialogUrl ?>')">
                                    <td class="align-middle"><?= $winnerNum ?></td>
                                    <td class="align-middle text-center">
                                        <div class="font-weight-bold text-primary"><?= e($winnerName) ?></div>
                                        <?php if ($winnerSub): ?>
                                            <small class="text-muted"><?= e($winnerSub) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle text-center"><?= e($w['award_name']) ?></td>
                                    <td class="align-middle">
                                        <span class="badge badge-danger px-2 py-1"><?= e($w['category_name']) ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <?php if (!empty($w['level'])): ?>
                                            <span class="badge badge-secondary px-2 py-1"><?= e($w['level']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle"><?= e($w['schedule_title']) ?></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">No winners declared yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <?php elseif ($view === 'ranking'): ?>

                <?php
                $rankAwardId = isset($_GET['rank_award_id']) ? sanitize($_GET['rank_award_id']) : null;
                $rankSchedId = isset($_GET['rank_sched_id']) ? sanitize($_GET['rank_sched_id']) : null;
                $rankLevel = isset($_GET['rank_level']) ? sanitize($_GET['rank_level']) : null;
                if ($rankAwardId):
                    $rankAward = recognitionAward($rankAwardId);
                    $rankCriteria = rankingCriteriaByAward($rankAwardId);
                    $rankNominees = nomineesWithScoresByAward($rankAwardId, $rankSchedId ?: null, $rankLevel ?: null);
                    $hasScores = ($rankSchedId && $rankAwardId) ? hasNomineeScores($rankSchedId, $rankAwardId, $rankLevel ?: null) : false;
                    ?>

                    <?php if ($rankAward): ?>
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="badge badge-primary font-weight-bold text-uppercase p-2">
                                    <?= e($rankAward['name']) ?> — <?= count($rankNominees) ?> nominee(s)
                                </span>
                                <?php if ($rankLevel): ?>
                                    <span class="badge badge-info font-weight-bold text-uppercase p-2 ml-1">
                                        <?= e($rankLevel) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($rankCriteria)): ?>
                                    <span class="badge badge-success font-weight-bold p-2 ml-1">
                                        <i class="fas fa-check"></i> Criteria set (<?= count($rankCriteria) ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-warning font-weight-bold p-2 ml-1">
                                        <i class="fas fa-exclamation-triangle"></i> No criteria set
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-row align-items-center mt-2 mt-md-0">
                                <?php modalButtonSplit(uri() . '/modules/race/save-ranking-criteria-dialog.php?id=' . cipher($rankAwardId), 'Set Criteria', 'fa-clipboard-list', 'Set Ranking Criteria') ?>
                                <?php if (!empty($rankSchedId)): ?>
                                    <?php if ($isFinalized): ?>
                                        <span class="badge badge-danger p-2 ml-2"><i class="fas fa-trophy"></i> Winner Declared</span>
                                    <?php elseif (empty($rankCriteria)): ?>
                                        <?php modalButtonSplit(uri() . '/modules/race/no-criteria-dialog.php?award=' . cipher($rankAwardId), 'Save Rankings', 'fa-save', 'Save Rankings', 'warning') ?>
                                    <?php elseif (!$hasScores): ?>
                                        <?php modalButtonSplit(uri() . '/modules/race/no-rankings-dialog.php?award=' . cipher($rankAwardId) . '&sched=' . cipher($rankSchedId), 'Save Rankings', 'fa-save', 'Save Rankings', 'warning') ?>
                                    <?php elseif ($hasSavedRankings): ?>
                                        <?php modalButtonSplit(uri() . '/modules/race/finalize-winner-dialog.php?sched=' . cipher($rankSchedId) . '&award=' . cipher($rankAwardId) . ($rankLevel ? '&level=' . cipher($rankLevel) : ''), 'Declare Winner', 'fa-trophy', 'Finalize & Declare Winner') ?>
                                    <?php else: ?>
                                        <form action="" method="POST" class="ml-2">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="save-rankings" value="1">
                                            <input type="hidden" name="rank_schedule_id" value="<?= e($rankSchedId) ?>">
                                            <input type="hidden" name="rank_award_id" value="<?= e($rankAwardId) ?>">
                                            <?php if ($rankLevel): ?>
                                                <input type="hidden" name="rank_level" value="<?= e($rankLevel) ?>">
                                            <?php endif; ?>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-save fa-fw"></i> Save Rankings
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($rankCriteria)): ?>
                        <div class="text-center py-5">
                            <div class="text-muted mb-3" style="font-size:3rem;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h5 class="text-muted">No criteria has been set for this award yet.</h5>
                            <p class="text-muted small">Please contact the RACE administrator for nomination guidelines.</p>
                            <?php modalButtonSplit(uri() . '/modules/race/ranking-guidelines-dialog.php', 'View Guidelines', 'fa-book-open', 'Award Guidelines') ?>
                        </div>
                    <?php elseif (empty($rankNominees)): ?>
                        <div class="text-center py-5 text-muted">
                            <div class="mb-2" style="font-size:2rem;"><i class="fas fa-users-slash"></i></div>
                            <p>No nominees found for this award.</p>
                        </div>
                    <?php else: ?>
                        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle" width="5%">Rank</th>
                                    <th class="align-middle" width="45%">Nominee</th>
                                    <th class="align-middle" width="20%">Category</th>
                                    <th class="align-middle" width="15%">Total Score</th>
                                    <th class="align-middle" width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rank = 1;
                                foreach ($rankNominees as $rn): ?>
                                    <tr>
                                        <td class="align-middle">
                                            <?php if ($rank === 1): ?>
                                                <span class="badge badge-warning font-weight-bold p-2"><i class="fas fa-crown"></i>
                                                    1st</span>
                                            <?php elseif ($rank === 2): ?>
                                                <span class="badge badge-secondary font-weight-bold p-2">2nd</span>
                                            <?php elseif ($rank === 3): ?>
                                                <span class="badge badge-dark font-weight-bold p-2">3rd</span>
                                            <?php else: ?>
                                                <span class="text-muted font-weight-bold"><?= $rank ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle text-left">
                                            <?php if ($rn['nominee_type'] === 'School'): ?>
                                                <div><strong><?= e($rn['school_name'] ?: 'Unknown School') ?></strong></div>
                                                <div class="text-muted small">School Code: <?= e($rn['nominee_id']) ?>
                                                    (<?= e($rn['school_alias'] ?: 'N/A') ?>)</div>
                                            <?php else: ?>
                                                <?php if ($rn['last_name'] !== null): ?>
                                                    <div>
                                                        <strong><?= toName($rn['last_name'], $rn['first_name'], $rn['middle_name'], $rn['name_extension']) ?></strong>
                                                    </div>
                                                <?php else: ?>
                                                    <div><strong>Nominee ID: <?= e($rn['nominee_id']) ?></strong></div>
                                                    <div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee record
                                                        missing</div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (!empty($rn['nominated_by'])): ?>
                                                <div class="text-muted small mt-1"><i class="fas fa-user-tag fa-fw"></i> Nominated by
                                                    <?= e($rn['nominator_first'] . ' ' . $rn['nominator_last']) ?>
                                                    <?= !empty($rn['nominator_position']) ? ' (' . e($rn['nominator_position']) . ')' : '' ?>
                                                    <?= !empty($rn['nominator_school']) ? ' — ' . e($rn['nominator_school']) : '' ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle small text-uppercase">
                                            <?php
                                            $catName = '';
                                            if ($rankAward) {
                                                $cat = recognitionCategory($rankAward['category_id']);
                                                if ($cat)
                                                    $catName = $cat['name'];
                                            }
                                            echo e($catName);
                                            ?>
                                        </td>
                                        <td class="align-middle">
                                            <span
                                                class="badge badge-<?= $rn['total_score'] > 0 ? 'success' : 'light' ?> font-weight-bold px-2 py-1"
                                                style="font-size:1rem;">
                                                <?= number_format($rn['total_score'], 2) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <?php if ($isFinalized): ?>
                                                <span class="badge badge-light text-muted p-2"><i class="fas fa-lock"></i> Locked</span>
                                            <?php else: ?>
                                                <?php modalButtonSplit(uri() . '/modules/race/rank-nominee-dialog.php?id=' . cipher($rn['id']), 'Rank', 'fa-star', 'Give Points') ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $rank++; endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <div class="mb-2" style="font-size:2rem;"><i class="fas fa-trophy"></i></div>
                        <p>Select an award above to view and rank nominees.</p>
                        <?php $allRankAwards = awardsWithNominees(); ?>
                        <?php if (empty($allRankAwards)): ?>
                            <p class="small">No awards with nominees found yet.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <?php if ($scheduleId): ?>
                    <?php if ($awardId): ?>
                        <!-- AWARD NOMINEES TABLE -->
                        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle" width="10%">Status</th>
                                    <th class="align-middle" width="45%">Nominee</th>
                                    <th class="align-middle" width="15%">Level</th>
                                    <th class="align-middle" width="20%">Date Nominated</th>
                                    <th class="align-middle" width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $nominees = nomineesByScheduleAndAward($scheduleId, $awardId);

                                if (!empty($nominees)):
                                    foreach ($nominees as $nominee):
                                        $badgeColor = 'warning';
                                        if ($nominee['status'] === 'Awarded') {
                                            $badgeColor = 'success';
                                        } elseif ($nominee['status'] === 'Disqualified') {
                                            $badgeColor = 'danger';
                                        }
                                        ?>
                                        <tr>
                                            <td class="align-middle text-capitalize">
                                                <span class="badge badge-pill badge-<?= $badgeColor ?>">
                                                    <?= e($nominee['status'] === 'Awarded' ? 'Winner' : $nominee['status']) ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-uppercase">
                                                <?php if (isset($nominee['nominee_type']) && $nominee['nominee_type'] === 'School'): ?>
                                                    <div><strong><?= e($nominee['school_name'] ?: 'Unknown School') ?></strong></div>
                                                    <div class="text-muted small">School Code: <?= e($nominee['nominee_id']) ?>
                                                        (<?= e($nominee['school_alias'] ?: 'N/A') ?>)</div>
                                                <?php else: ?>
                                                    <?php if ($nominee['last_name'] !== null): ?>
                                                        <div>
                                                            <strong><?= toName($nominee['last_name'], $nominee['first_name'], $nominee['middle_name'], $nominee['name_extension']) ?></strong>
                                                        </div>
                                                        <div class="text-muted small"><?= e($nominee['position']) ?></div>
                                                    <?php else: ?>
                                                        <div><strong>Nominee ID: <?= e($nominee['nominee_id']) ?></strong></div>
                                                        <div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee Record
                                                            Missing</div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if (!empty($nominee['nominated_by'])): ?>
                                                    <div class="text-muted small mt-1"><i class="fas fa-user-tag fa-fw"></i> Nominated by
                                                        <?= e($nominee['nominator_first'] . ' ' . $nominee['nominator_last']) ?>
                                                        <?= !empty($nominee['nominator_position']) ? ' (' . e($nominee['nominator_position']) . ')' : '' ?>
                                                        <?= !empty($nominee['nominator_school']) ? ' — ' . e($nominee['nominator_school']) : '' ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle font-weight-bold text-uppercase">
                                                <?php if ($nominee['level']): ?>
                                                    <span class="badge badge-secondary px-2 py-1 text-xs"><?= e($nominee['level']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted small">&mdash;</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle"><?= toLongDate($nominee['created_at']) ?></td>
                                            <td class="align-middle">
                                                <div class="dropdown no-arrow">
                                                    <?php dropdownEllipsis() ?>
                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                        <?php if ($raceAccess === 'admin'): ?>
                                                            <?php modalDropdownItem(uri() . '/modules/race/edit-nominator-dialog.php?id=' . cipher($nominee['id']), 'Change Nominator', 'fa-user-edit', 'Change Nominator'); ?>
                                                            <?php modalDropdownItem(uri() . '/modules/race/edit-nominee-dialog.php?id=' . cipher($nominee['id']), 'Edit Nominee', 'fa-edit', 'Edit Nominee'); ?>
                                                            <div class="dropdown-divider"></div>
                                                        <?php endif; ?>
                                                        <?php if (!$nominatorOnly): ?>
                                                            <?php if ($nominee['status'] !== 'Disqualified'): ?>
                                                                <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nominee['id']) . '&action=disqualify', 'Disqualify', 'fa-ban', 'Disqualify Nominee'); ?>
                                                            <?php endif; ?>

                                                            <div class="dropdown-divider"></div>
                                                            <?php modalDropdownItem(uri() . '/modules/race/delete-nominee-dialog.php?id=' . cipher($nominee['id']), 'Delete', 'fa-trash', 'Delete Nominee'); ?>
                                                        <?php else: ?>
                                                            <span class="dropdown-item small text-muted disabled"><i
                                                                    class="fas fa-eye fa-fw mr-2"></i> View Only</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No nominees found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <!-- EVENT AWARDS TABLE -->
                        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle" width="45%">Award</th>
                                    <th class="align-middle" width="25%">Category</th>
                                    <th class="align-middle" width="10%">Nominees</th>
                                    <th class="align-middle" width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $schedAwards = scheduleAwards($scheduleId);
                                $nomineeCounts = nomineesCountByAward($scheduleId);

                                if (!empty($schedAwards)):
                                    foreach ($schedAwards as $aw):
                                        $count = $nomineeCounts[$aw['id']] ?? 0;
                                        $rowParams = $_GET;
                                        $rowParams['award_id'] = cipher($aw['id']);
                                        $awardDetailsUrl = uri() . '/race?' . http_build_query($rowParams);
                                        ?>
                                        <tr>
                                            <td class="align-middle text-center font-weight-bold text-uppercase">
                                                <a href="<?= $awardDetailsUrl ?>">
                                                    <?= e($aw['name']) ?>
                                                </a>
                                            </td>
                                            <td class="align-middle text-center small text-uppercase"><?= e($aw['category_name']) ?></td>
                                            <td class="align-middle">
                                                <span class="badge badge-pill badge-info font-weight-bold px-2 py-1"><?= $count ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="dropdown no-arrow">
                                                    <?php dropdownEllipsis() ?>
                                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                        <a class="dropdown-item small" href="<?= $awardDetailsUrl ?>">
                                                            <i class="fas fa-users fa-fw mr-2 text-gray-400"></i> View Nominees
                                                        </a>
                                                        <?php modalDropdownItem(uri() . '/modules/race/criteria-dialog.php?e=' . cipher($scheduleId) . '&award_id=' . cipher($aw['id']), 'View Criteria', 'fa-clipboard-list', 'View Criteria'); ?>
                                                        <?php modalDropdownItem(uri() . '/modules/race/nominate-reminder-dialog.php?e=' . cipher($scheduleId) . '&award_id=' . cipher($aw['id']), 'Nominate', 'fa-plus', 'Add Nominee'); ?>
                                                        <?php if (!$nominatorOnly): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <?php modalDropdownItem(uri() . '/modules/race/save-award-dialog.php?e=' . cipher($scheduleId) . '&id=' . cipher($aw['id']), 'Edit', 'fa-edit', 'Edit Award'); ?>
                                                            <?php modalDropdownItem(uri() . '/modules/race/delete-award-dialog.php?id=' . cipher($aw['id']), 'Delete', 'fa-trash', 'Delete Award'); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            No awards found in the database yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- EVENT SCHEDULES TABLE -->
                    <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="30%">Title</th>
                                <th class="align-middle" width="15%">Event Date</th>
                                <th class="align-middle" width="20%">Nomination Period</th>
                                <th class="align-middle" width="10%">Status</th>
                                <th class="align-middle" width="15%">Venue</th>
                                <th class="align-middle" width="10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $schedules = awardSchedules();

                            if (!empty($schedules)):
                                foreach ($schedules as $sched):
                                    $rowParams = $_GET;
                                    $rowParams['schedule_id'] = cipher($sched['id']);
                                    $scheduleDetailsUrl = uri() . '/race?' . http_build_query($rowParams);
                                    $nomStatus = nominationStatus($sched);
                                    ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <a href="<?= $scheduleDetailsUrl ?>" class="font-weight-bold">
                                                <?= e($sched['title']) ?>
                                            </a>
                                        </td>
                                        <td class="align-middle"><?= toLongDate($sched['date']) ?></td>
                                        <td class="align-middle small">
                                            <?php if (!empty($sched['nomination_start']) || !empty($sched['nomination_deadline'])): ?>
                                                <?= !empty($sched['nomination_start']) ? toLongDate($sched['nomination_start']) : 'N/A' ?>
                                                <br>&mdash;
                                                <br><?= !empty($sched['nomination_deadline']) ? toLongDate($sched['nomination_deadline']) : 'N/A' ?>
                                            <?php else: ?>
                                                <span class="text-muted">No deadline</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <span
                                                class="badge badge-<?= $nomStatus['color'] ?> px-2 py-1"><?= $nomStatus['label'] ?></span>
                                        </td>
                                        <td class="align-middle text-center"><?= e($sched['venue']) ?></td>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php modalDropdownItem(uri() . '/modules/race/save-schedule-dialog.php?id=' . cipher($sched['id']), 'Edit', 'fa-edit', 'Edit Schedule'); ?>
                                                    <?php modalDropdownItem(uri() . '/modules/race/delete-schedule-dialog.php?id=' . cipher($sched['id']), 'Delete', 'fa-trash', 'Delete Schedule'); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">No award schedules found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>