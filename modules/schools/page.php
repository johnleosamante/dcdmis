<?php
// modules/schools/page.php
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
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" rowspan="2" width="5%">Logo</th>
            <th class="align-middle" rowspan="2" width="40%">School Name / Alias / ID / Address</th>
            <th class="align-middle" rowspan="2" width="15%">District</th>
            <th class="align-middle" rowspan="2" width="20%">Head of Office</th>
            <th class="align-middle" colspan="3" width="15%">Personnel Count</th>
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
          $query = schools();
          while ($row = fetchArray($query)) :
            $logo = uri() . '/' . $row['logo'];
            $schoolName = $row['name'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <div class="image-container">
                  <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                    <img height="100%" src="<?php echo $logo; ?>" alt="<?php echo $schoolName; ?>">
                  </span>
                </div>
              </td>
              <td class="align-middle text-left">
                <div><?php echo $schoolName . ' (' . $row['alias'] . ')'; ?></div>
                <div class="small"><?php echo $row['id'] . ' | ' . $row['address']; ?></div>
              </td>
              <td class="align-middle"><?php
                                        $districts = district($row['district']);
                                        echo numRows($districts) > 0 ? fetchAssoc($districts)['name'] : '';
                                        ?></td>
              <td class="align-middle">
                <div><?php echo userName($row['head']); ?></div>
                <?php
                $positions = position($row['head']);
                echo numRows($positions) > 0 ? '<div class="small">' . fetchAssoc($positions)['position'] . '</div>' : '';
                ?>
              </td>

              <?php
              $employeeCount = schoolEmployeeCount($row['id']);
              $male = $female = $total = 0;

              if (numRows($employeeCount) > 0) {
                $count = fetchAssoc($employeeCount);
                $male = $count['male'];
                $female = $count['female'];
                $total = $count['total'];
              }
              ?>

              <td class="align-middle"><?php echo $male; ?></td>
              <td class="align-middle"><?php echo $female; ?></td>
              <td class="align-middle"><?php echo $total; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php linkDropdownItem(customUri($activeApp, 'School Information', $row['id']), 'View', 'fa-eye', 'View School'); ?>
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