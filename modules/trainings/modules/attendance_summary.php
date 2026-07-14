<?php
require_once(root() . '/includes/database/database.php');
require_once(root() . '/modules/trainings/modules/action.php');

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if (!$trainingId) {
    die("<div class='alert alert-danger'>Invalid Training ID.</div>");
}

$training = training($trainingId);

if (!$training) {
    die("<div class='alert alert-danger'>Training not found.</div>");
}

$participants = trainingParticipants($trainingId);
$participantsCount = count($participants);

/*
  |--------------------------------------------------------------------------
  | Attendance Days
  |--------------------------------------------------------------------------
 */

$dayRows = query("
    SELECT DISTINCT DATE(date_in) AS day
    FROM training_attendees
    WHERE training_id = ?
    ORDER BY day ASC
", [$trainingId]);

$days = [];

foreach ($dayRows as $row) {
    $days[] = $row['day'];
}

/*
  |--------------------------------------------------------------------------
  | Employees
  |--------------------------------------------------------------------------
 */

$employees = query("
    SELECT DISTINCT
        ta.id AS attendance_id,
        e.id,
        CONCAT(
            e.first_name, ' ',
            IF(
                e.middle_name IS NOT NULL
                AND e.middle_name <> '',
                CONCAT(LEFT(e.middle_name,1), '. '),
                ''
            ),
            e.last_name
        ) AS fullname,
        p.official_title,
        e.email_address,
        ta.is_mail

    FROM training_attendees ta

    INNER JOIN employees e
        ON e.id = ta.employee_id

    LEFT JOIN station_assignments sa
        ON sa.employee_id = e.id

    LEFT JOIN positions p
        ON p.id = sa.position_id

    WHERE ta.training_id = ?

    GROUP BY ta.id
    ORDER BY fullname ASC
", [$trainingId]);

/*
  |--------------------------------------------------------------------------
  | Attendance Map
  |--------------------------------------------------------------------------
  |
  | Creates:
  | $attendanceMap[employee_id][date] = true
  |
 */

$attendanceRows = query("
    SELECT id, training_id,
        employee_id,
        DATE(date_in) AS day,
        is_mail
    FROM training_attendees
    WHERE training_id = ?
", [$trainingId]);

$attendanceMap = [];

foreach ($attendanceRows as $row) {
    $attendanceMap[$row['employee_id']][$row['day']] = true;
}

/*
  |--------------------------------------------------------------------------
  | Statistics
  |--------------------------------------------------------------------------
 */

$attendancePerDay = [];

foreach ($days as $day) {

    $attendancePerDay[$day] = 0;

    foreach ($employees as $emp) {

        if (isset($attendanceMap[$emp['id']][$day])) {
            $attendancePerDay[$day]++;
        }
    }
}

$totalEmployees = count($employees);
$totalDays = count($days);

$totalPossible = $totalEmployees * $totalDays;
$totalPresent = array_sum($attendancePerDay);

$completionRate = $totalPossible > 0 ? round(($totalPresent / $totalPossible) * 100) : 0;
?>

<div class="row g-3">

    <!-- LEFT SIDE (70%) -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100"
             style="background-color:#f6f4f1;">

            <div class="card-body">

                <div class="text-center">

                    <!-- DATE RANGE -->
                    <div class="d-flex align-items-center justify-content-center mb-3">

                        <div style="width:60px;height:2px;background:#4f46e5;"></div>

                        <span class="mx-3 text-uppercase fw-semibold"
                              style="letter-spacing:1px;color:#4f46e5;font-size:13px;">

                            <?=
                            empty($training['unconsecutive_date']) ? toDateRange($training['start_date'], $training['end_date']) : toHandleEncoding($training['unconsecutive_date'])
                            ?>

                        </span>

                        <div style="width:60px;height:2px;background:#4f46e5;"></div>

                    </div>

                    <!-- TITLE -->
                    <h3 class="fw-bold mb-3">
                        <?= htmlspecialchars($training['title']) ?>
                    </h3>

                    <!-- DETAILS -->
                    <div class="text-muted" style="font-size:14px; line-height:1.8;">

                        <div>
                            <strong>Venue:</strong>
                            <?= htmlspecialchars($training['venue']) ?>
                        </div>

                        <div>
                            <strong>Sponsored By:</strong>
                            <?= htmlspecialchars($training['sponsored_by']) ?>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT SIDE (30%) -->
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-uppercase text-muted mb-3"
                    style="font-size:12px; letter-spacing:1px;">
                    Attendance Summary
                </h6>

                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Participants</span>
                        <strong><?= $totalEmployees ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Attendance Days</span>
                        <strong><?= $totalDays ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Total Attendance</span>
                        <strong><?= $totalPresent ?></strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>Completion</span>
                        <strong><?= $completionRate ?>%</strong>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>
<br>
<input type="hidden" value="<?= $training['id'] ?>" id="training-id">
<input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
<!--<button class="btn btn-primary"
        onclick="sendBulkEmail()">
    <i class="fa fa-envelope"></i> Send Email to Participants
</button>-->

<div class="tab-content mt-3 bg-white p-3">

    <div class="tab-pane fade show active">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <table
            class="table table-bordered table-hover table-striped text-center"
            id="attendanceSummaryTable">

            <thead class="table-light">

                <tr>

                    <th>No.</th>
                    <th class="text-start">Employee</th>
                    <th class="text-start">Position</th>
                    <th class="text-start">Email Address</th>

                    <?php foreach ($days as $day): ?>

                        <th>
                            <?= date('M d', strtotime($day)) ?>
                        </th>

                    <?php endforeach; ?>
                    <th class="text-start">Send Email</th>
                </tr>

            </thead>

            <tbody>

                <?php $count = 1; ?>

                <?php foreach ($employees as $emp): ?>

                    <tr>

                        <td>
                            <?= $count++ ?>
                        </td>

                        <td class="text-start fw-semibold">
                            <?= strtoupper(htmlspecialchars($emp['fullname'])) ?>
                        </td>

                        <td class="text-start">
                            <?= strtoupper(htmlspecialchars($emp['official_title'] ?? '')) ?>
                        </td>

                        <td class="text-start text-primary">
                            <?= htmlspecialchars($emp['email_address'] ?? '') ?>
                        </td>

                        <?php foreach ($days as $day): ?>

                            <td>

                                <?=
                                isset($attendanceMap[$emp['id']][$day]) ? '✔' : '✖'
                                ?>

                            </td>

                        <?php endforeach; ?>
                        <td class="text-start text-primary">
                            <button
                                onclick="sendEmailSubmit(this)"
                                class="btn btn-sm <?= ($emp['is_mail'] == 1) ? 'btn-secondary' : 'btn-success' ?>"
                                data-attendance-id="<?= $emp['attendance_id'] ?>"
                                data-employee-id="<?= $emp['id'] ?>"
                                data-training-id="<?= $trainingId ?>"
                                data-email="<?= htmlspecialchars($emp['email_address']) ?>"
                                <?= ($emp['is_mail'] == 1) ? 'disabled' : '' ?>>

                                <?= ($emp['is_mail'] == 1) ? "DONE" : "SEND" ?>
                            </button>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<div id="loadingOverlay"
     style="
     display:none;
     position:fixed;
     top:0; left:0;
     width:100%; height:100%;
     background:rgba(0,0,0,0.5);
     z-index:9999;
     color:white;
     font-size:20px;
     text-align:center;
     padding-top:20%;
     ">

    <div>
        <i class="fa fa-spinner fa-spin" style="font-size:40px;"></i>
        <br><br>
        Sending emails to participants...
        <br>
        <small>Please wait</small>
    </div>

</div>
<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/assets/vendor/toastr/toastr.min.css">