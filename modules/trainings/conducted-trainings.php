<?php
// modules/trainings/scheduled-trainings.php
messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center flex-row-reverse mt-2 mb-3">
  <div class="d-inline-block">
    <?php modalButtonSplit(uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus'); ?>
  </div>
</div>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle('Conducted Trainings'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="15%" rowspan="2">Code</th>
            <th class="align-middle" width="30%" rowspan="2">Title of Learning &amp; Development Interventions / Training Programs</th>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="15%" rowspan="2">Type of Learning &amp; Development</th>
            <th class="align-middle" width="25%" rowspan="2">Conducted / Sponsored by</th>
            <th class="align-middle" width="5%" rowspan="2">Action</th>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $trainings = conductedTrainings();
          while ($training = fetchAssoc($trainings)) : ?>
          <tr>
            <td class="align-middle">
              <?php linkItem(customUri('hrtdms', 'Training Details', $training['no']), $training['no']); ?>
            </td>
            <td class="align-middle text-left"><?php echo $training['title']; ?></td>
            <td class="align-middle"><?php echo toDate($training['from']); ?></td>
            <td class="align-middle"><?php echo toDate($training['to']); ?></td>
            <td class="align-middle"><?php echo trainingType($training['type']); ?></td>
            <td class="align-middle"><?php echo $training['sponsor']; ?></td>
            <td class="align-middle text-capitalize">
              <div class="dropdown no-arrow">
                <?php dropdownEllipsis(); ?>
                <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                  <?php linkDropdownItem(customUri('hrtdms', 'Training Details', $training['no']), 'View', 'fa-eye', 'View Training');
                  linkDropdownItem(customUri('hrtdms', 'Add Training Participants', $training['no']), 'Add', 'fa-user-plus', 'Add Participants');
                  modalDropdownItem(uri() . '/modules/trainings/save-training-dialog.php?id=' . cipher($training['no']), 'Edit', 'fa-edit', 'Edit Training'); ?>
                </div>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="15%" rowspan="2">Code</th>
            <th class="align-middle" width="30%" rowspan="2">Title of Learning &amp; Development Interventions / Training Programs</th>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
            <th class="align-middle" width="15%" rowspan="2">Type of Learning &amp; Development</th>
            <th class="align-middle" width="25%" rowspan="2">Conducted / Sponsored by</th>
            <th class="align-middle" width="5%" rowspan="2">Action</th>
          </tr>
          <tr>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>