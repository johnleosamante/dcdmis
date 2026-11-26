<?php

require_once __DIR__ . '/../includes/function.php';
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/account.php');
require_once __DIR__ . '/../assets/vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if (empty($userId) || !userRole($userId, 'hrtdms')) {
    http_response_code(403);
    exit('Access denied.');
}

// HEADER / FOOTER
$headerURL = uri() . "/assets/img/sdoheader.png";
$footerURL = uri() . "/assets/img/sdofooter.png";

// GET VALUES
$training_id = isset($_GET['training_id']) ? base64_decode($_GET['training_id']) : '';
$date = isset($_GET['date']) ? base64_decode($_GET['date']) : '';

if (!$training_id || !$date) {
    die("Invalid request.");
}

// FETCH TRAINING DETAILS
$trainingResult = find(
    "SELECT title, venue, start_date, end_date FROM trainings WHERE id = ? LIMIT 1",
    [$training_id]
);

$training_title = $trainingResult['title'] ?? 'N/A';
$training_venue = $trainingResult['venue'] ?? 'N/A';
$start_date = $trainingResult['start_date'] ?? '';
$end_date = $trainingResult['end_date'] ?? '';

$dates = [];

$current = strtotime($start_date);
$end = strtotime($end_date);

while ($current && $end && $current <= $end) {
    $dates[] = date('Y-m-d', $current);
    $current = strtotime('+1 day', $current);
}

// FETCH ATTENDEES
$sql = "
    SELECT 
        ta.employee_id,
        ta.time_in,
        ta.date_in,
        CONCAT(
            UPPER(e.last_name), ', ',
            e.first_name,
            IF(
                e.name_extension IS NOT NULL AND e.name_extension != '',
                CONCAT(' ', e.name_extension),
                ''
            ),
            IF(
                e.middle_name IS NOT NULL AND e.middle_name != '',
                CONCAT(' ', LEFT(e.middle_name, 1), '.'),
                ''
            )
        ) AS name,
        e.sex,
        e.email_address,
        e.mobile_number,
        e.prc,
        e.tin,
        e.agency_id,

        p.official_title,
        p.id as abbreviation

    FROM training_attendees ta

    JOIN employees e 
        ON ta.employee_id = e.id

    LEFT JOIN station_assignments sa 
        ON sa.employee_id = e.id

    LEFT JOIN positions p 
        ON p.id = sa.position_id

    WHERE ta.training_id = ?

    ORDER BY e.last_name ASC
";

$attendees = query($sql, [$training_id]);
$attendees = is_array($attendees) ? $attendees : [];

// PDF HTML
$html = '

<style>

body {
    font-family: "Bookman Old Style", Bookman;
    font-size: 12px;
    margin: 0;
    padding: 0;
}

/* HEADER */
.header {
    text-align: center;
    margin: 0;
    padding: 0;
}

.header img {
    width: 50%;
    height: auto;
    display: inline-block;
}

/* FOOTER */
.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
}

.footer img {
    width: 50%;
    height: auto;
    display: inline-block;
}

.content {
    margin: 40px 0px 35px 0px;
}

table {
    width: 100%;
    border-collapse: collapse;
    page-break-inside: auto;
}

thead {
    display: table-header-group;
}

th, td {
    border: 1px solid #000;
    padding: 6px;
    font-size: 12px;
    text-align: left;
}

th {
    background: #f2f2f2;
    text-align: center;
}

.meta {
    margin-top: -30px;
    margin-bottom: 10px;
    font-size: 15px;
}

.meta a {
    display: inline-block;
    width: 140px;
}

.training-title {
    font-weight: bold;
    text-transform: uppercase;
}

.privacy {
    font-size: 11px;
    text-align: justify;
    margin-top: 5px;
}

tbody td {
    font-size: 13px;
}

.center {
    text-align: center;
}

</style>

<div class="header" style="margin-top:-30px !important;">
    <img src="' . $headerURL . '" />
</div>

<div class="footer" style="margin-bottom:-40px !important;">
    <img src="' . $footerURL . '" />
</div>

<div class="content">

    <div class="meta">

        <a>Title of Training:</a> 
        <span class="training-title">
            <b>' . htmlspecialchars($training_title) . '</b>
        </span>
        <br>

        <a>Venue:</a> 
        <b>' . htmlspecialchars($training_venue) . '</b>
        <br>

       <a>Date:</a> 
        <b>' . date("F d, Y", strtotime($start_date)) . ' - ' . date("F d, Y", strtotime($end_date)) . '</b>
    </div>

    <h1 style="text-align:center;">
        ATTENDANCE SHEET
    </h1>

   <div class="privacy"> <i><b><u>Data Privacy Notice:</u></b> The Department of Education complies with the Data Privacy Act of 2012 and is committed in protecting your privacy. During this activity, we will collect personal information for the purpose of documentation and verification of attendance. Information collected as well as pictures taken during the activity will be stored for as long as necessary, but they will not be shared with any third parties without your consent or any legal basis. By signing this attendance sheet, you are consenting to the collection, use, and retention of your personal information.</i> </div>

    <br>

    <table>

        <thead>

            <tr>
                <th rowspan="2" width="5%">NO.</th>
                <th rowspan="2" width="20%">NAME</th>
                <th rowspan="2" width="5%">SEX</th>
                <th rowspan="2" width="12%">
                    POSITION-<br>DESIGNATION
                </th>
                <th rowspan="2" width="20%">
                    DEPED EMAIL<br>(@deped.gov.ph)
                </th>
                <th rowspan="2" width="10%">
                    MOBILE NO.
                </th>
                
            ';
foreach ($dates as $d) {

    $html .= '

                    <th colspan="2">
                        ' . date("M d", strtotime($d)) . '
                    </th>

                ';

}
$html .= '

                    <th rowspan="2" width="10%">
                        SIGNATURE
                    </th>

                    <th rowspan="2" width="10%">
                        PRC LICENSE NO.
                    </th>

                    <th rowspan="2" width="10%">
                        TIN NO.
                    </th>

                    <th rowspan="2" width="15%">
                        EMPLOYEE ID
                    </th>

                </tr>

                <tr>

        ';
foreach ($dates as $d) {

    $html .= '

                <th>IN</th>
                <th>OUT</th>

            ';

}
$html .= '

        </tr>

    </thead>

    <tbody>

';

$counter = 1;

$counter = 1;

if (count($attendees) > 0) {

    // Store employees and attendance
    $employees = [];
    $attendance = [];

    foreach ($attendees as $row) {

        $employee_id = $row['employee_id'];
        $attendance_date = $row['date_in'];

        // Save employee information only once
        if (!isset($employees[$employee_id])) {
            $employees[$employee_id] = $row;
        }

        // Save attendance for the corresponding date
        $attendance[$employee_id][$attendance_date] = !empty($row['time_in'])
            ? date("h:i", strtotime($row['time_in']))
            : "-";
    }

    // Print one row per employee
    foreach ($employees as $employee_id => $row) {

        $html .= '

        <tr>

            <td class="center">
                ' . $counter++ . '
            </td>

            <td>
                ' . htmlspecialchars(strtoupper($row['name'])) . '
            </td>

            <td class="center">
                ' . htmlspecialchars($row['sex'] ?? '') . '
            </td>

            <td>
                ' . htmlspecialchars(strtoupper($row['abbreviation'] ?? '')) . '
            </td>

            <td>
                ' . htmlspecialchars($row['email_address'] ?? '') . '
            </td>

            <td class="center">
                ' . htmlspecialchars($row['mobile_number'] ?? '') . '
            </td>

        ';

        // Dynamic attendance columns
        foreach ($dates as $d) {

            $time_in = $attendance[$employee_id][$d] ?? '-';

            $html .= '

                <td class="center">
                    ' . $time_in . '
                </td>

                <td class="center">
                    ' . ($time_in != '-' ? '5:00' : '-') . '
                </td>

            ';
        }

        $html .= '

            <td></td>

            <td>
                ' . htmlspecialchars($row['prc'] ?? '') . '
            </td>

            <td>
                ' . htmlspecialchars($row['tin'] ?? '') . '
            </td>

            <td>
                ' . htmlspecialchars($row['agency_id'] ?? '') . '
            </td>

        </tr>

        ';
    }

} else {

    // Calculate dynamic colspan
    $dynamicColspan = 6 + (count($dates) * 2) + 4;

    $html .= '

    <tr>

        <td colspan="' . $dynamicColspan . '" class="center">
            No attendance records found.
        </td>

    </tr>

    ';
}

$html .= '

        </tbody>

    </table>

</div>

';

// GENERATE PDF
$dompdf = new Dompdf();

$dompdf->set_option('isRemoteEnabled', true);

$dompdf->setPaper('folio', 'landscape');

$dompdf->loadHtml($html);

$dompdf->render();

// PAGE NUMBER
$canvas = $dompdf->getCanvas();

$font = $dompdf->getFontMetrics()->get_font("Helvetica", "normal");

$canvas->page_text(
    800,
    560,
    "Page {PAGE_NUM} of {PAGE_COUNT}",
    $font,
    10
);

// STREAM PDF
$dompdf->stream(
    "attendance_report_" . date("Ymd", strtotime($date)) . ".pdf",
    ["Attachment" => false]
);