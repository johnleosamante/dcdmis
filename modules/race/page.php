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
    }
}

if ($nominatorOnly && in_array($view, ['schedules', 'winners'])) {
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
                        <a href="<?= $backToSchedulesUrl ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left fa-fw"></i> Back to Events
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <?php modalButtonSplit(uri() . '/modules/race/save-schedule-dialog.php', 'Add Year', 'fa-calendar-plus', 'Add Year') ?>
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
                    <?php modalButtonSplit(uri() . '/modules/race/nominate-reminder-dialog.php', 'Nominate', 'fa-user-plus', 'Nominate') ?>
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
                        <option value="Elementary" <?= setOptionSelected('Elementary', $nomFilterLevel) ?>>Elementary</option>
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
                    $lowerAwardName = strtolower($selAwardObj['name']);
                    $allowedAwards = [
                        'most outstanding teacher',
                        'most outstanding master teacher',
                        'most outstanding school head',
                        'best small school',
                        'best medium school',
                        'best large school'
                    ];
                    foreach ($allowedAwards as $allowed) {
                        if (strpos($lowerAwardName, $allowed) !== false) {
                            $needsLevelLookup = true;
                            break;
                        }
                    }
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
                        foreach ($awds as $aw):
                            $needsLevel = false;
                            $lowerName = strtolower($aw['name']);
                            $allowedAwards = [
                                'most outstanding teacher',
                                'most outstanding master teacher',
                                'most outstanding school head',
                                'best small school',
                                'best medium school',
                                'best large school'
                            ];
                            foreach ($allowedAwards as $allowed) {
                                if (strpos($lowerName, $allowed) !== false) {
                                    $needsLevel = true;
                                    break;
                                }
                            }
                            ?>
                            <option value="<?= e($aw['id']) ?>" data-needs-level="<?= $needsLevel ? 'true' : 'false' ?>" <?= setOptionSelected($aw['id'], $selectedAwardId) ?>>
                                <?= e($aw['name']) ?> (<?= e($aw['category_name']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 mb-2 mb-md-0" id="level-lookup-container" style="display: <?= $needsLevelLookup ? 'block' : 'none' ?>;">
                    <label class="small font-weight-bold text-uppercase text-dark mb-1">Choose Level</label>
                    <select name="winner_level" id="winner_level" class="form-control form-control-sm" <?= $needsLevelLookup ? 'required' : '' ?>>
                        <option value="">Select Level...</option>
                        <option value="Elementary" <?= setOptionSelected('Elementary', $_GET['winner_level'] ?? '') ?>>Elementary</option>
                        <option value="Secondary" <?= setOptionSelected('Secondary', $_GET['winner_level'] ?? '') ?>>Secondary</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm btn-block" type="submit">
                        <i class="fas fa-search fa-fw"></i> Search
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
                            <th class="align-middle" width="60%">Award</th>
                            <th class="align-middle" width="40%">Category</th>
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
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="2" class="text-center py-4">No awards found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="align-middle">Award</th>
                            <th class="align-middle">Category</th>
                        </tr>
                    </tfoot>
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
                                            <div class="text-muted small">School Code: <?= e($nom['nominee_id']) ?> (<?= e($nom['school_alias'] ?: 'N/A') ?>)</div>
                                        <?php else: ?>
                                            <?php if ($nom['last_name'] !== null): ?>
                                                <div><strong><?= toName($nom['last_name'], $nom['first_name'], $nom['middle_name'], $nom['name_extension']) ?></strong></div>
                                                <div class="text-muted small"><?= e($nom['position']) ?></div>
                                            <?php else: ?>
                                                <div><strong>Nominee ID: <?= e($nom['nominee_id']) ?></strong></div>
                                                <div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee Record Missing</div>
                                            <?php endif; ?>
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
                                    <td class="align-middle small text-uppercase font-weight-bold"><?= e($nom['schedule_title']) ?></td>
                                    <?php if (!$nominatorOnly): ?>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php if ($nom['status'] !== 'Awarded'): ?>
                                                        <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nom['id']) . '&action=declare_winner', 'Declare Winner', 'fa-trophy', 'Declare Winner'); ?>
                                                    <?php endif; ?>

                                                    <?php if ($nom['status'] === 'Awarded'): ?>
                                                        <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nom['id']) . '&action=revert_winner', 'Revert Winner', 'fa-undo', 'Revert Winner'); ?>
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
                    <tfoot>
                        <tr>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Nominee</th>
                            <th class="align-middle">Level</th>
                            <th class="align-middle">Award Information</th>
                            <th class="align-middle">Event Schedule</th>
                            <?php if (!$nominatorOnly): ?>
                                <th class="align-middle">Action</th>
                            <?php endif; ?>
                        </tr>
                    </tfoot>
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
                                    <p class="text-muted small text-uppercase font-weight-bold mb-3">School Code: <?= e($winner['nominee_id']) ?> (<?= e($winner['school_alias'] ?: 'N/A') ?>)</p>
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
                                        <p class="text-danger small text-uppercase font-weight-bold mb-3"><i class="fas fa-exclamation-triangle"></i> Employee Record Missing</p>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <hr class="w-50 my-3">

                                <h5 class="text-dark font-weight-bold mb-1 text-uppercase"><?= e($winner['award_name']) ?></h5>
                                <span class="badge badge-pill badge-danger text-uppercase px-3 py-2 text-xs"><?= e($winner['category_name']) ?></span>

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
                                <p class="small">Go to <strong>Schedule &rarr; Choose Event &rarr; Select Award</strong> to declare a nominee as the winner.</p>
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
                            <tr style="cursor: pointer;" data-toggle="modal" data-target="#modal" onclick="loadData('<?= $winnerDialogUrl ?>')">
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
                    <tfoot>
                        <tr>
                            <th class="align-middle">No.</th>
                            <th class="align-middle">Winner</th>
                            <th class="align-middle">Award</th>
                            <th class="align-middle">Category</th>
                            <th class="align-middle">Level</th>
                            <th class="align-middle">Event Schedule</th>
                        </tr>
                    </tfoot>
                </table>

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
                                                    <div class="text-muted small">School Code: <?= e($nominee['nominee_id']) ?> (<?= e($nominee['school_alias'] ?: 'N/A') ?>)</div>
                                                <?php else: ?>
                                                    <?php if ($nominee['last_name'] !== null): ?>
                                                        <div><strong><?= toName($nominee['last_name'], $nominee['first_name'], $nominee['middle_name'], $nominee['name_extension']) ?></strong></div>
                                                        <div class="text-muted small"><?= e($nominee['position']) ?></div>
                                                    <?php else: ?>
                                                        <div><strong>Nominee ID: <?= e($nominee['nominee_id']) ?></strong></div>
                                                        <div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Employee Record Missing</div>
                                                    <?php endif; ?>
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
                                                        <?php if (!$nominatorOnly): ?>
                                                            <?php if ($nominee['status'] !== 'Awarded'): ?>
                                                                <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nominee['id']) . '&action=declare_winner', 'Declare Winner', 'fa-trophy', 'Declare Winner'); ?>
                                                            <?php endif; ?>

                                                            <?php if ($nominee['status'] === 'Awarded'): ?>
                                                                <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nominee['id']) . '&action=revert_winner', 'Revert Winner', 'fa-undo', 'Revert Winner'); ?>
                                                            <?php endif; ?>

                                                            <?php if ($nominee['status'] !== 'Disqualified'): ?>
                                                                <?php modalDropdownItem(uri() . '/modules/race/nominee-action-dialog.php?id=' . cipher($nominee['id']) . '&action=disqualify', 'Disqualify', 'fa-ban', 'Disqualify Nominee'); ?>
                                                            <?php endif; ?>

                                                            <div class="dropdown-divider"></div>
                                                            <?php modalDropdownItem(uri() . '/modules/race/delete-nominee-dialog.php?id=' . cipher($nominee['id']), 'Delete', 'fa-trash', 'Delete Nominee'); ?>
                                                        <?php else: ?>
                                                            <span class="dropdown-item small text-muted disabled"><i class="fas fa-eye fa-fw mr-2"></i> View Only</span>
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

                            <tfoot>
                                <tr>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Nominee</th>
                                    <th class="align-middle">Level</th>
                                    <th class="align-middle">Date Nominated</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    <?php else: ?>
                        <!-- EVENT AWARDS TABLE -->
                        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle" width="50%">Award</th>
                                    <th class="align-middle" width="30%">Category</th>
                                    <th class="align-middle" width="10%">Nominees</th>
                                    <th class="align-middle" width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $awards = recognitionAwardsWithCategory();
                                $nomineeCounts = nomineesCountByAward($scheduleId);

                                if (!empty($awards)):
                                    foreach ($awards as $aw):
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
                                                        <?php modalDropdownItem(uri() . '/modules/race/nominate-reminder-dialog.php?e=' . cipher($scheduleId) . '&award_id=' . cipher($aw['id']), 'Nominate', 'fa-plus', 'Add Nominee'); ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No awards found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th class="align-middle">Award</th>
                                    <th class="align-middle">Category</th>
                                    <th class="align-middle">Nominees</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </tfoot>
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
                                            <span class="badge badge-<?= $nomStatus['color'] ?> px-2 py-1"><?= $nomStatus['label'] ?></span>
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

                        <tfoot>
                            <tr>
                                <th class="align-middle" width="30%">Title</th>
                                <th class="align-middle" width="15%">Event Date</th>
                                <th class="align-middle" width="20%">Nomination Period</th>
                                <th class="align-middle" width="10%">Status</th>
                                <th class="align-middle" width="15%">Venue</th>
                                <th class="align-middle" width="10%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?= uri() ?>/assets/vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#winner_award_id').change(function() {
        var selected = $(this).find('option:selected');
        var needsLevel = selected.attr('data-needs-level') === 'true';
        if (needsLevel) {
            $('#level-lookup-container').show();
            $('#winner_level').prop('required', true);
            $('.grid-adjust').removeClass('col-md-5').addClass('col-md-4');
        } else {
            $('#level-lookup-container').hide();
            $('#winner_level').prop('required', false).val('');
            $('.grid-adjust').removeClass('col-md-4').addClass('col-md-5');
        }
    });

    setInterval(function() {
        $.getJSON('<?= uri() ?>/modules/race/check-access.php', function(data) {
            if (data && data.access === false) {
                document.body.innerHTML = '<div class="container py-5 text-center">' +
                    '<div class="text-danger mb-3" style="font-size:4rem;"><i class="fas fa-ban"></i></div>' +
                    '<h3 class="text-danger font-weight-bold">Access Revoked</h3>' +
                    '<p class="text-muted">Your access to Rewards and Recognition has been removed by the administrator.</p>' +
                    '<a href="<?= uri() ?>" class="btn btn-primary mt-3">Go to Homepage</a></div>';
            }
        });
    }, 30000);
});
</script>
