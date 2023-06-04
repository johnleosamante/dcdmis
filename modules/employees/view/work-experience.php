<?php
// modules/employees/view/work-experience.php
?>

<div class="tab-pane fade<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'work-experience', 'show active'); ?>" id="work-experience">
    <?php if ($editMode) : ?>
    <div class="d-sm-flex justify-content-end my-3">
      <?php modalButtonSplit(uri() . '/modules/employees/update/update-work-experience.php', 'Add', 'fa-plus', 'Add Work Experience', 'primary'); ?>
    </div>
  <?php endif; ?>

  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="20%" rowspan="2">Position Title</th>
            <th class="align-middle" width="30%" rowspan="2">Department / Agency / Office / Company</th>
            <th class="align-middle" width="10%" rowspan="2">Monthly Salary</th>
            <th class="align-middle" width="10%" rowspan="2">Salary / Job / Pay Grade &amp; Step Increment</th>
            <th class="align-middle" width="10%" rowspan="2">Status of Appointment</th>
            <th class="align-middle" width="10%" rowspan="2">Government Service</th>
            <?php if ($editMode) : ?>
              <th class="align-middle" width="5%" rowspan="2">Action</th>
            <?php endif; ?>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $experiences = experiences($employee['id']);

          if (numRows($experiences) > 0) {
            while ($experience = fetchAssoc($experiences)) : ?>
              <tr>
                <td class="align-middle"><?php echo toDate($experience['from']); ?></td>
                <td class="align-middle"><?php echo $experience['ispresent'] ? 'PRESENT' : toDate($experience['to']); ?></td>
                <td class="align-middle"><?php echo $experience['position']; ?></td>
                <td class="align-middle"><?php echo $experience['organization']; ?></td>
                <td class="align-middle"><?php echo toCurrency($experience['salary']); ?></td>
                <td class="align-middle"><?php echo $experience['sg']; ?></td>
                <td class="align-middle"><?php echo $experience['status']; ?></td>
                <td class="align-middle"><?php echo $experience['isgovernment']; ?></td>
                <?php if ($editMode) : ?>
                  <td class="align-middle text-capitalize">
                    <div class="dropdown no-arrow">
                      <?php dropdownEllipsis(); ?>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php modalDropdownItem(uri() . '/modules/employees/update/update-work-experience.php?id=' . encode($experience['no']), 'Edit', 'fa-edit', 'Edit Work Experience'); ?>
                        <div class="dropdown-divider"></div>
                        <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-work-experience.php?id=' . encode($experience['no']), 'Delete', 'fa-trash', 'Delete Work Experience', 'text-danger'); ?>
                      </div>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="<?php echo $editMode ? '9' : '8'; ?>" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->