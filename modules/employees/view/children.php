<?php
// modules/employees/view/children.php
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'children', 'show active'); ?>" id="children">
  <?php if ($editMode) : ?>
    <div class="d-sm-flex justify-content-end my-3">
      <?php modal_button_split(uri() . '/modules/employees/update/update-child.php', 'Add', 'fa-plus', 'Add Child', 'primary'); ?>
    </div>
  <?php endif; ?>

  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="70%">Name of Child</th>
            <th class="align-middle" width="30%">Date of Birth</th>
            <?php if ($editMode) : ?>
              <th class="align-middle" width="5%">Action</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $children = children($employee['id']);

          if (num_rows($children) > 0) {
            while ($child = fetch_assoc($children)) : ?>
              <tr>
                <td class="align-middle"><?php echo to_name($child['last'], $child['first'], $child['middle'], $child['ext']); ?></td>
                <td class="align-middle"><?php echo to_date($child['dob']); ?></td>
                <?php if ($editMode) : ?>
                  <td class="align-middle text-capitalize">
                    <div class="dropdown no-arrow">
                      <?php dropdown_ellipsis(); ?>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php modal_dropdown_item(uri() . '/modules/employees/update/update-child.php?id=' . encode($child['no']), 'Edit', 'fa-edit', 'Edit Child'); ?>
                        <div class="dropdown-divider"></div>
                        <?php modal_dropdown_item(uri() . '/modules/employees/delete/delete-child.php?id=' . encode($child['no']), 'Delete', 'fa-trash', 'Delete Child', 'text-danger'); ?>
                      </div>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="<?php echo $editMode ? '3' : '2'; ?>" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->