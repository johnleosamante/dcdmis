<?php
// export/training-details.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect("$baseUri/login");
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/utility.php');

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$training = training($trainingId);
$participants = trainingParticipants($trainingId);

if ($training) {
    $trainingId = $training['id'];
} else {
    return;
}
?>

<table>
    <thead>
        <tr>
            <th>Code</th>
            <td colspan="3"><?= e($training['id']) ?></td>
        </tr>
        <tr>
            <th>Title</th>
            <td colspan="3"><?= strtoupper($training['title']) ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td colspan="3">
                <?= strtoupper(empty($training['unconsecutive_dates']) ? toLongDate($training['start_date']) . ' - ' . toLongDate($training['end_date']) : $training['unconsecutive_date']) ?>
            </td>
        </tr>
        <?php if (!empty($training['number_of_hours'])): ?>
            <tr>
                <th>Hours</th>
                <td colspan="3"><?= e($training['number_of_hours']) ?></td>
            </tr>
        <?php endif ?>
        <tr>
            <th>Type</th>
            <td colspan="3"><?= strtoupper(trainingType($training['training_type_id'])) ?></td>
        </tr>
        <tr>
            <th>Level</th>
            <td colspan="3"><?= strtoupper(trainingSponsor($training['conducted_by'])) ?></td>
        </tr>
        <?php if (!empty($training['sponsored_by'])): ?>
            <tr>
                <th>Sponsor</th>
                <td colspan="3"><?= strtoupper($training['sponsored_by']) ?></td>
            </tr>
        <?php endif ?>
        <?php if (!empty($training['venue'])): ?>
            <tr>
                <th>Venue</th>
                <td colspan="3"><?= strtoupper($training['venue']) ?></td>
            </tr>
        <?php endif ?>
        <tr>
            <th>Participants</th>
            <td colspan="3"><?= strtoupper(count($participants)) ?></td>
        </tr>
        <tr>
            <th>#</th>
            <th>Participant Name</th>
            <th>Position</th>
            <th>Station</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;

        foreach ($participants as $row):
            $employeeName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($employeeName) ?></td>
                <td><?= strtoupper(positions($row['position_id'])['official_title']) ?></td>
                <td><?= strtoupper(schoolById($row['station_id'])['name']) ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="4"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>