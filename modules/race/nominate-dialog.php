<?php
// modules/race/nominate-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$step = $_GET['step'] ?? 'schedule';
$scheduleParam = isset($_GET['e']) ? $_GET['e'] : null;
$awardParam = isset($_GET['award_id']) ? $_GET['award_id'] : null;
$scheduleId = $scheduleParam ? sanitize(decipher($scheduleParam)) : null;
$awardId = $awardParam ? sanitize(decipher($awardParam)) : null;

if ($step === 'schedule'):
    $schedules = awardSchedules();
    $modalTitle = 'Select Event Schedule';
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php modalHeader($modalTitle); ?>
            <div class="modal-body p-0">
                <p class="px-4 pt-3 mb-2 text-muted large">Choose an event schedule to nominate under:</p>
                <?php if (!empty($schedules)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($schedules as $sched):
                            $nomStatus = nominationStatus($sched);
                            $isOpen = isNominationOpen($sched);
                        ?>
                            <?php if ($isOpen): ?>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3 px-4"
                                   onclick="loadData('<?= uri() ?>/modules/race/nominate-dialog.php?step=award&e=<?= cipher($sched['id']) ?>'); return false;">
                            <?php else: ?>
                                <div class="list-group-item d-flex align-items-center justify-content-between py-3 px-4 bg-light">
                            <?php endif; ?>
                                <div>
                                    <div class="font-weight-bold <?= $isOpen ? 'text-dark' : 'text-muted' ?> text-uppercase"><?= e($sched['title']) ?></div>
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar-alt fa-fw mr-1"></i> <?= toLongDate($sched['date']) ?>
                                        &nbsp;&bull;&nbsp;
                                        <i class="fas fa-map-marker-alt fa-fw mr-1"></i> <?= e($sched['venue']) ?>
                                        <?php if (!empty($sched['nomination_deadline'])): ?>
                                            &nbsp;&bull;&nbsp;
                                            <span class="<?= $isOpen ? 'text-danger' : 'text-muted' ?>"><i class="fas fa-clock fa-fw mr-1"></i>Deadline: <?= toLongDate($sched['nomination_deadline']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-<?= $nomStatus['color'] ?> px-2 py-1 mr-2"><?= $nomStatus['label'] ?></span>
                                    <?php if ($isOpen): ?>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    <?php else: ?>
                                        <i class="fas fa-lock text-gray-400"></i>
                                    <?php endif; ?>
                                </div>
                            <?php if ($isOpen): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <div class="mb-2" style="font-size: 2rem;"><i class="fas fa-calendar-times"></i></div>
                        <p>No event schedules available.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </div>
    </div>

<?php elseif ($step === 'award'):
    $schedule = $scheduleId ? awardSchedule($scheduleId) : null;
    $awards = $scheduleId ? scheduleAwards($scheduleId) : [];
    $nomineeCounts = $scheduleId ? nomineesCountByAward($scheduleId) : [];
    $modalTitle = 'Select Award';
    if ($schedule) {
        $modalTitle = 'Select Award — ' . $schedule['title'];
    }
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php modalHeader($modalTitle); ?>
            <div class="modal-body p-0">
                <div class="px-4 pt-3 pb-2 d-flex align-items-center justify-content-between">
                    <p class="mb-0 text-muted small">Choose an award to nominate for:</p>
                    <a href="#" class="btn btn-outline-secondary btn-sm"
                       onclick="loadData('<?= uri() ?>/modules/race/nominate-dialog.php?step=schedule'); return false;">
                        <i class="fas fa-arrow-left fa-fw"></i> Back
                    </a>
                </div>
                <?php if ($schedule): ?>
                    <div class="px-4 pb-2">
                        <span class="badge badge-primary font-weight-bold text-uppercase p-2 text-xs">
                            Event: <?= e($schedule['title']) ?> &mdash; <?= toLongDate($schedule['date']) ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($awards)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($awards as $aw):
                            $count = $nomineeCounts[$aw['id']] ?? 0;
                        ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3 px-4"
                               onclick="loadData('<?= uri() ?>/modules/race/nominate-dialog.php?step=reminder&e=<?= cipher($scheduleId) ?>&award_id=<?= cipher($aw['id']) ?>'); return false;">
                                <div>
                                    <div class="font-weight-bold text-dark text-uppercase"><?= e($aw['name']) ?></div>
                                    <div class="text-muted small"><?= e($aw['category_name']) ?></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-pill badge-info font-weight-bold px-2 py-1 mr-3" title="Current nominees"><?= $count ?></span>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <div class="mb-2" style="font-size: 2rem;"><i class="fas fa-award"></i></div>
                        <p>No awards have been added to this schedule yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </div>
    </div>

<?php elseif ($step === 'reminder'):
    $award = $awardId ? recognitionAward($awardId) : null;
    $awardName = $award ? $award['name'] : 'Award';
    if ($scheduleParam && $awardParam) {
        $nextUrl = uri() . '/modules/race/save-nominee-dialog.php?e=' . urlencode($scheduleParam) . '&award_id=' . urlencode($awardParam);
    } else {
        $nextUrl = uri() . '/modules/race/nominate-dialog.php?step=schedule';
    }
    ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php modalHeader('Guidelines for the Pop-Up Gantimpala Agad Awards'); ?>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <h5 class="font-weight-bold">1. Title, Purpose and Scope</h5>
                <p><strong>Award Title:</strong> Pop-Up Gantimpala Agad Awards for Unsung Heroes</p>
                <p><strong>Purpose:</strong> To provide instant, on-the-spot recognition to teachers who demonstrate exceptional dedication, creativity, or compassion in teaching. The goal is to foster a culture of immediate appreciation and gratitude.</p>

                <h5 class="font-weight-bold mt-4">2. Mechanics</h5>
                <p><strong>Nature:</strong> The award is a surprise, "pop-up" event. Nominations are confidential, and nominees are unaware they are being considered until the moment of the award.</p>
                <p><strong>Nominations:</strong> The School Head shall nominate three (3) teachers per school with at least one (1) year in the teaching profession. A nomination form shall be used, requiring only the nominee's name and a short reason for the nomination, such as "For always helping struggling readers."</p>
                <p><strong>Selection Committee:</strong> A small, quick-response committee composed of the Public Schools District Supervisors and the Division RACE Committee will review nominations and select awardees on a rolling basis.</p>

                <h5 class="font-weight-bold mt-4">3. Selection Criteria</h5>
                <p>The award is based on observable acts that embody the spirit of a dedicated educator. Nominations should highlight a teacher's demonstration of one or more of the following:</p>
                <ol type="a">
                    <li><strong>Malasakit (Compassion):</strong> Showing extraordinary care for student well-being beyond academic duties.</li>
                    <li><strong>Nobility (Dedication):</strong> Consistently going above and beyond the job description without fanfare, publicity, or media attention.</li>
                    <li><strong>Creativity:</strong> Developing innovative solutions to teaching challenges with limited resources.</li>
                    <li><strong>Positive Influence:</strong> Creating a significant positive impact on the school climate or a specific group of students.</li>
                </ol>

                <h5 class="font-weight-bold mt-4">4. Awarding Process</h5>
                <p><strong>The "Pop-Up":</strong> The committee, along with a small group of colleagues, will "pop up" in the teacher's classroom or a common area, such as the faculty room, during a non-disruptive time.</p>
                <p><strong>The Presentation:</strong> A short citation will be read aloud, highlighting the specific reason for the award, followed by the presentation of a symbolic token.</p>
                <p><strong>Documentation:</strong> A quick photo is taken to commemorate the moment and may be posted on the school's bulletin board or social media page to inspire others.</p>

                <h5 class="font-weight-bold mt-4">5. Award Components</h5>
                <p><strong>Token:</strong> A certificate of recognition and a simple, meaningful gift shall be provided. This could be a small cash prize, a gift certificate for a local cafe or bookstore, a privilege pass, such as one free day from an assigned non-teaching task, or a simple hamper of essentials.</p>
                <p><strong>Gantimpala Agad</strong> means "instant reward," so the token should be given on the spot.</p>

                <div class="custom-control custom-checkbox mt-4 border-top pt-3">
                    <input type="checkbox" class="custom-control-input" id="agree-nomination" onchange="document.getElementById('btn-next-nomination').disabled = !this.checked;">
                    <label class="custom-control-label text-dark" for="agree-nomination">
                        I have read and understood the guidelines above and agree to comply.
                    </label>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <?php cancelModalButton() ?>
                <button type="button" class="btn btn-primary" id="btn-next-nomination" disabled onclick="loadData('<?= e($nextUrl) ?>'); return false;">
                    Next <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="modal-dialog"><div class="modal-content">
        <?php modalHeader('Error'); ?>
        <div class="modal-body"><p>Invalid nomination step.</p></div>
        <div class="modal-footer"><?php cancelModalButton() ?></div>
    </div></div>
<?php endif; ?>
