<?php
// export/training-details.php
if (!isset($_GET['v'])) {
  return;
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/utility.php');

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$trainings = training($trainingId);
$participants = trainingParticipants($trainingId);

if (numRows($trainings) > 0) {
  $training = fetchAssoc($trainings);
  $trainingId = $training['no'];
} else {
  return;
}
?>

<table>
  <thead>
  <tr>
    <th class="pr-5" scope="row">Code</th>
    <td class="text-uppercase" colspan="3"><?php echo $training['no']; ?></td>
  </tr>
  <tr>
    <th class="align-top pr-5" scope="row">Title</th>
    <td class="text-uppercase" colspan="3"><?php echo $training['title']; ?></td>
  </tr>
  <tr>
    <th class="pr-5" scope="row">Date</th>
    <td class="text-uppercase" colspan="3"><?php echo empty($training['unconsecutive_date']) ? toLongDate($training['from']) . ' - ' . toLongDate($training['to']) : $training['unconsecutive_date']; ?></td>
  </tr>
  <?php if (!empty($training['hours'])) : ?>
    <tr>
      <th class="pr-5" scope="row">Hours</th>
      <td class="text-uppercase" colspan="3"><?php echo $training['hours']; ?></td>
    </tr>
  <?php endif; ?>
  <tr>
    <th class="pr-5" scope="row">Type</th>
    <td class="text-uppercase" colspan="3"><?php echo trainingType($training['type']); ?></td>
  </tr>
  <tr>
    <th class="pr-5" scope="row">Level</th>
    <td class="text-uppercase" colspan="3"><?php echo trainingSponsor($training['level']); ?></td>
  </tr>
  <?php if (!empty($training['sponsor'])) : ?>
    <tr>
      <th class="align-top pr-5" scope="row">Sponsor</th>
      <td class="text-uppercase" colspan="3"><?php echo $training['sponsor']; ?></td>
    </tr>
  <?php endif; ?>
  <?php if (!empty($training['venue'])) : ?>
    <tr>
      <th class="align-top pr-5" scope="row">Venue</th>
      <td class="text-uppercase" colspan="3"><?php echo $training['venue']; ?></td>
    </tr>
  <?php endif; ?>
  <tr>
    <th class="align-top pr-5" scope="row">Participants</th>
    <td class="text-uppercase" colspan="3"><?php echo numRows($participants); ?></td>
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

    while ($row = fetchArray($participants)) :
      $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
    ?>
      <tr class="text-uppercase">
        <td class="align-middle">
          <?php echo $i++; ?>
        </td>
        <td class="align-middle text-left">
          <?php echo $employeeName; ?>
        </td>
        <td class="align-middle">
          <?php echo fetchAssoc(positions($row['position']))['position']; ?>
        </td>
        <td class="align-middle">
          <?php echo fetchAssoc(schoolById($row['station']))['name']; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>