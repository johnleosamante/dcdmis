<?php
// modules/race/nominate-reminder-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$scheduleParam = isset($_GET['e']) ? $_GET['e'] : null;
$awardParam = isset($_GET['award_id']) ? $_GET['award_id'] : null;
$awardId = $awardParam ? sanitize(decipher($awardParam)) : null;
$award = $awardId ? recognitionAward($awardId) : null;
$awardName = $award ? $award['name'] : 'Award';

if ($scheduleParam && $awardParam) {
    $nextUrl = uri() . '/modules/race/save-nominee-dialog.php?e=' . urlencode($scheduleParam) . '&award_id=' . urlencode($awardParam);
} else {
    $nextUrl = uri() . '/modules/race/nominate-select-schedule-dialog.php';
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
            <p><strong>Nature:</strong> The award is a surprise, “pop-up” event. Nominations are confidential, and nominees are unaware they are being considered until the moment of the award.</p>
            <p><strong>Nominations:</strong> The School Head shall nominate three (3) teachers per school with at least one (1) year in the teaching profession. A nomination form shall be used, requiring only the nominee’s name and a short reason for the nomination, such as “For always helping struggling readers.”</p>
            <p><strong>Selection Committee:</strong> A small, quick-response committee composed of the Public Schools District Supervisors and the Division RACE Committee will review nominations and select awardees on a rolling basis.</p>

            <h5 class="font-weight-bold mt-4">3. Selection Criteria</h5>
            <p>The award is based on observable acts that embody the spirit of a dedicated educator. Nominations should highlight a teacher’s demonstration of one or more of the following:</p>
            <ol type="a">
                <li><strong>Malasakit (Compassion):</strong> Showing extraordinary care for student well-being beyond academic duties.</li>
                <li><strong>Nobility (Dedication):</strong> Consistently going above and beyond the job description without fanfare, publicity, or media attention.</li>
                <li><strong>Creativity:</strong> Developing innovative solutions to teaching challenges with limited resources.</li>
                <li><strong>Positive Influence:</strong> Creating a significant positive impact on the school climate or a specific group of students.</li>
            </ol>

            <h5 class="font-weight-bold mt-4">4. Awarding Process</h5>
            <p><strong>The “Pop-Up”:</strong> The committee, along with a small group of colleagues, will “pop up” in the teacher’s classroom or a common area, such as the faculty room, during a non-disruptive time.</p>
            <p><strong>The Presentation:</strong> A short citation will be read aloud, highlighting the specific reason for the award, followed by the presentation of a symbolic token.</p>
            <p><strong>Documentation:</strong> A quick photo is taken to commemorate the moment and may be posted on the school’s bulletin board or social media page to inspire others.</p>

            <h5 class="font-weight-bold mt-4">5. Award Components</h5>
            <p><strong>Token:</strong> A certificate of recognition and a simple, meaningful gift shall be provided. This could be a small cash prize, a gift certificate for a local café or bookstore, a privilege pass, such as one free day from an assigned non-teaching task, or a simple hamper of essentials.</p>
            <p><strong>Gantimpala Agad</strong> means “instant reward,” so the token should be given on the spot.</p>

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
