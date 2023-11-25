<?php
// modules/schools/page.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
  require_once(root() . '/modules/error/403.php');
  return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($activeApp === 'dmis') {
      contentTitleWithModal('Schools', uri() . '/modules/schools/save-school-dialog.php', 'Add', 'fa-plus');
    } else {
      contentTitle('Schools');
    }
    ?>
  </div>

  <div class="card-body">
    <?php if ($isHrmis || $isDmis) { ?>
      <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
        <div class="d-inline-block">
          <?php linkButtonSplit(customUri('export', 'schools'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success'); ?>
        </div>
      </div>
    <?php } ?>

    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Logo</th>
            <th class="align-middle" width="25%">School Name / Alias / ID / Address</th>
            <th class="align-middle" width="10%">District</th>
            <th class="align-middle" width="10%">Category</th>
            <th class="align-middle" width="20%">Head of Office</th>
            <th class="align-middle text-mars" width="5%"><i class="fa fa-user fw"></i> Male</th>
            <th class="align-middle text-venus" width="5%"><i class="fa fa-user fw"></i> Female</th>
            <th class="align-middle" width="5%" title="Total Personnel"><i class="fa fa-user-friends fw"></i> Total</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = schoolEmployeeCount();
          while ($row = fetchArray($query)) :
            $logo = !empty($row['logo']) ? uri() . '/' . $row['logo'] : uri() . '/uploads/division/division.png';
            $schoolName = $row['name'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <div class="image-container">
                  <span class="d-flex justify-content-center align-middle school-logo overflow-hidden">
                    <img height="100%" src="<?php echo $logo; ?>" alt="<?php echo $schoolName; ?>">
                  </span>
                </div>
              </td>
              <td class="align-middle text-left">
                <div><?php linkItem(customUri($activeApp, 'School Information', $row['id']), $schoolName . ' (' . $row['alias'] . ')'); ?></div>
                <div class="small"><?php echo $row['id'] . ' | ' . $row['address']; ?></div>
              </td>
              <td class="align-middle">
                <?php linkItem(customUri($activeApp, 'District Information', $row['districtId']), $row['district']); ?>
              </td>
              <td class="align-middle"><?php echo $row['category']; ?></td>
              <td class="align-middle">
                <div>
                  <?php if ($isHrmis) {
                    linkItem(customUri('hrmis', 'Employee Information', $row['head']), userName($row['head']));
                  } else {
                    modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['head']), userName($row['head']));
                  } ?>
                </div>
                <?php
                $positions = position($row['head']);
                echo numRows($positions) > 0 ? '<div class="small">' . fetchAssoc($positions)['position'] . '</div>' : '';
                ?>
              </td>
              <td class="align-middle text-mars"><strong><?php echo $row['male']; ?></strong></td>
              <td class="align-middle text-venus"><strong><?php echo $row['female']; ?></strong></td>
              <td class="align-middle"><strong><?php echo $row['total']; ?></strong></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php linkDropdownItem(customUri($activeApp, 'School Information', $row['id']), 'View', 'fa-eye', 'View School');

                    if ($isDmis) {
                      modalDropdownItem(uri() . '/modules/schools/save-school-dialog.php?id=' . cipher($row['id']) . '&e=' . cipher($row['alias']), 'Edit', 'fa-edit', 'Edit School');
                    } ?>
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