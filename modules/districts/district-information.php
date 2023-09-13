<?php
// modules/districts/district-information.php
$districtId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$districts = district($districtId);
$district = $districtName = $psds = null;

messageAlert($showAlert, $message, $success);

if (numRows($districts) > 0) {
  $district = fetchAssoc($districts);
  $districtName = $district['name'];
  $psds = $district['psds'];
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($isDmis) {
      contentTitleWithModal('District Information: ' . strtoupper($districtName), uri() . '/modules/districts/save-district-dialog.php?id=' . cipher($districtId), 'Edit', 'fa-edit');
    } else {
      contentTitle('District Information: ' . strtoupper($districtName));
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive pb-3">
      <table cellspacing="0">
        <tr>
          <th class="pr-5 align-top" scope="row">District</th>
          <td class="text-uppercase"><?php echo $districtName; ?></td>
        </tr>
        <tr>
          <th class="pr-5 align-top" scope="row">Supervisor</th>
          <td class="text-uppercase">
            <div>
              <?php if ($isHrmis) {
                linkItem(customUri('hrmis', 'Employee Information', $psds), userName($psds));
              } else {
                echo userName($psds);
              } ?>
            </div>
            <div class="small"><?php echo fetchAssoc(position($psds))['position']; ?></div>
          </td>
        </tr>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" rowspan="2" width="5%">Logo</th>
            <th class="align-middle" rowspan="2" width="25%">School Name / Alias / ID / Address</th>
            <th class="align-middle" rowspan="2" width="15%">District</th>
            <th class="align-middle" rowspan="2" width="15%">Category</th>
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
          $query = districtSchools($districtId);
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
                <div><?php linkItem(customUri($activeApp, 'School Information', $row['id']), $schoolName . ' (' . $row['alias'] . ')'); ?></div>
                <div class="small"><?php echo $row['id'] . ' | ' . $row['address']; ?></div>
              </td>
              <td class="align-middle">
                <?php
                $districts = district($row['district']);
                if (numRows($districts) > 0) {
                  $district = fetchAssoc($districts);
                  linkItem(customUri($activeApp, 'District Information', $district['id']), $district['name']);
                } ?>
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