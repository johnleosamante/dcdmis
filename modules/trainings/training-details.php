<?php
// modules/trainings/training-details.php
$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$trainings = training($trainingId);
$participants = trainingParticipants($trainingId);
$participantsCount = numRows($participants);

if (numRows($trainings) > 0) {
  $training = fetchAssoc($trainings);
  $trainingId = $training['no'];
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php 
    if (isConductedTraining($trainingId)) {
      contentTitleWithLink('Training Details', customUri('hrtdms', 'Add Training Participants', $trainingId), 'Add Participants', 'fa-plus');
    } else {
      contentTitleWithLink('Training Details', customUri('hrtdms', 'Scheduled Trainings'));
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table cellspacing="0">
        <tr>
          <th class="pr-5" scope="row">Code</th>
          <td class="text-uppercase"><?php echo $training['no']; ?></td>
        </tr>
        <tr>
          <th class="align-top pr-5" scope="row">Title</th>
          <td class="text-uppercase"><?php echo $training['title']; ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">Date</th>
          <td class="text-uppercase"><?php echo empty($training['unconsecutive_date']) ? toLongDate($training['from']) . ' - ' . toLongDate($training['to']) : $training['unconsecutive_date']; ?></td>
        </tr>
        <?php if (!empty($training['hours'])) : ?>
        <tr>
          <th class="pr-5" scope="row">Hours</th>
          <td class="text-uppercase"><?php echo $training['hours']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
          <th class="pr-5" scope="row">Type</th>
          <td class="text-uppercase"><?php echo trainingType($training['type']); ?></td>
        </tr>
        <tr>
          <th class="pr-5" scope="row">Level</th>
          <td class="text-uppercase"><?php echo trainingSponsor($training['level']); ?></td>
        </tr>
        <?php if (!empty($training['sponsor'])) : ?>
        <tr>
          <th class="align-top pr-5" scope="row">Sponsor</th>
          <td class="text-uppercase"><?php echo $training['sponsor']; ?></td>
        </tr>
        <?php endif; ?>
        <?php if (!empty($training['venue'])) : ?>
        <tr>
          <th class="align-top pr-5" scope="row">Venue</th>
          <td class="text-uppercase"><?php echo $training['venue']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
          <th class="align-top pr-5" scope="row">Participants</th>
          <td class="text-uppercase"><?php echo numRows($participants); ?></td>
        </tr>
      </table>
    </div>

    <div class="table-responsive mt-3">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="35%">Name</th>
            <th class="align-mdille" width="10%">Status</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="25%">Station</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          while ($row = fetchArray($participants)) :
            $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
            $photo = uri() . '/' . $row['picture'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <div class="image-container">
                  <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                    <img height="100%" src="<?php echo $photo; ?>" alt="<?php echo $employeeName; ?>">
                  </span>
                  <div class="sex-sign"><?php sex($row['sex']); ?></div>
                </div>
              </td>
              <td class="align-middle text-left">
                <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' .cipher($row['id']), $employeeName); ?>
              </td>
              <td class="align-middle">
                <?php
                $status = strtolower($row['status']);
                roundPill($status);
                ?>
              </td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php modalDropdownItem(uri() .'/modules/trainings/remove-participant-dialog.php?e=' . cipher($row['id']) . '&id=' . cipher($trainingId), 'Remove', 'fa-trash', 'Remove Participant'); ?>
                  </div>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>