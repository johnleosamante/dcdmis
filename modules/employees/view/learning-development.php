<?php
// modules/employees/view/learning-development.php
?>

<div class="tab-pane fade<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'learning-development', 'show active'); ?>" id="learning-development">
  <?php if ($editMode) : ?>
    <div class="d-sm-flex justify-content-end my-3">
      <?php modalButtonSplit(uri() .'/modules/employees/update/update-learning-development.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Learning &amp; Development', 'primary'); ?>
    </div>
  <?php endif; ?>

  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="45%" rowspan="2">Title of Learning &amp; Development Interventions / Training Programs</th>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="5%" rowspan="2">Number of Hours</th>
            <th class="align-middle" width="10%" rowspan="2">Type of Learning &amp; Development</th>
            <th class="align-middle" width="30%" rowspan="2">Conducted / Sponsored by</th>
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
          $learnings = learningAndDevelopments($employeeId);

          if (numRows($learnings) > 0) {
            while ($learning = fetchAssoc($learnings)) : ?>
              <tr>
                <td class="align-middle"><?php echo $learning['title']; ?></td>
                <td class="align-middle"><?php echo toDate($learning['from']); ?></td>
                <td class="align-middle"><?php echo toDate($learning['to']); ?></td>
                <td class="align-middle"><?php echo $learning['hours']; ?></td>
                <td class="align-middle"><?php echo $learning['type']; ?></td>
                <td class="align-middle"><?php echo $learning['sponsor']; ?></td>
                <?php if ($editMode) : ?>
                  <td class="align-middle text-capitalize">
                    <div class="dropdown no-arrow">
                      <?php dropdownEllipsis(); ?>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php modalDropdownItem(uri() .'/modules/employees/update/update-learning-development.php?e=' . cipher($employeeId) . '&id=' . cipher($learning['no']), 'Edit', 'fa-edit', 'Edit Learning &amp; Development'); ?>
                        <div class="dropdown-divider"></div>
                        <?php modalDropdownItem(uri() .'/modules/employees/delete/delete-learning-development.php?e=' . cipher($employeeId) . '&id=' . cipher($learning['no']), 'Delete', 'fa-trash', 'Delete Learning &amp; Development'); ?>
                      </div>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="<?php echo $editMode ? '7' : '6'; ?>" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->