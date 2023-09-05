<?php
// modules/sections/page.php
messageAlert($showAlert, $message, $success);
$isHrmis = $activeApp === 'hrmis';
$isDmis = $activeApp === 'dmis';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($activeApp === 'dmis') {
      contentTitleWithModal('Sections', uri() . '/modules/sections/save-section-dialog.php', 'Add', 'fa-plus');
    } else {
      contentTitle('Sections');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" rowspan="2" width="25%">Section</th>
            <th class="align-middle" rowspan="2" width="25%">Functional Division</th>
            <th class="align-middle" rowspan="2" width="30%">Section Head</th>
            <th class="align-middle" colspan="3" width="15%">Personnel</th>
            <th class="align-middle" rowspan="2" width="5%">Action</th>
          </tr>

          <tr>
            <th class="align-middle text-mars" width="5%"><i class="fa fa-user fw"></i></th>
            <th class="align-middle text-venus" width="5%"><i class="fa fa-user fw"></i></th>
            <th class="align-middle" width="5%"><i class="fa fa-user-friends fw"></i></th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = sections();
          while ($row = fetchAssoc(($query))) : ?>
            <tr class="text-uppercase">
              <td class="align-middle text-center"><?php linkItem(customUri($activeApp, 'Section Information', $row['id']), $row['name']); ?></td>
              <td class="align-middle text-center"><?php echo $row['division']; ?></td>
              <td class="align-middle">
                <div>
                  <?php if ($isHrmis) {
                    linkItem(customUri('hrmis', 'Employee Information', $row['head']), userName($row['head']));
                  } else {
                    modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['head']), userName($row['head']));
                  } ?>
                </div>
                <div class="small"><?php echo fetchAssoc(position($row['head']))['position']; ?></div>
              </td>
              <?php
              $sectionCount = sectionEmployeeCount($row['id']);
              $male = $female = $total = 0;

              if (numRows($sectionCount) > 0) {
                $count = fetchAssoc($sectionCount);
                $male = $count['male'];
                $female = $count['female'];
                $total = $count['total'];
              }
              ?>
              <td class="align-middle text-mars"><?php echo $male; ?></td>
              <td class="align-middle text-venus"><?php echo $female; ?></td>
              <td class="align-middle"><?php echo $total; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php linkDropdownItem(customUri($activeApp, 'Section Information', $row['id']), 'View', 'fa-eye', 'View Section');
                      modalDropdownItem(uri() . '/modules/sections/save-section-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Section');
                    ?>
                  </div>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
          <th class="align-middle" rowspan="2" width="25%">Section</th>
            <th class="align-middle" rowspan="2" width="25%">Functional Division</th>
            <th class="align-middle" rowspan="2" width="30%">Section Head</th>
            <th class="align-middle text-mars" width="5%"><i class="fa fa-user fw"></i></th>
            <th class="align-middle text-venus" width="5%"><i class="fa fa-user fw"></i></th>
            <th class="align-middle" width="5%"><i class="fa fa-user-friends fw"></i></th>
            <th class="align-middle" rowspan="2" width="5%">Action</th>
          </tr>

          <tr>
            <th class="align-middle" colspan="3" width="15%">Personnel</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>