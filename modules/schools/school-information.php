<?php
// modules/schools/school-information.php
$schoolId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$schools = schoolDetailsById($schoolId);
$school = $schoolName = $alias = $address = $district = $head = $telephone = $email = $website = $fbPage = null;
$personnel = 0;
$isHrmis = $activeApp === 'hrmis';

if (numRows($schools) > 0) {
  $school = fetchAssoc($schools);
  $schoolName = $school['name'];
  $alias = $school['alias'];
  $address = $school['address'];
  $districts = district($school['district']);
  $district = numRows($districts) > 0 ? fetchAssoc($districts)['name'] : '';
  $category = $school['category'];
  $head = $school['head'];
  $telephone = $school['telephone'];
  $email = $school['email'];
  $website = $school['website'];
  $fbPage = $school['fb_page'];
  $count = schoolEmployeeCount($schoolId);
  $personnel = numRows($count) > 0 ? fetchAssoc($count)['total'] : 0;
  $logo = uri() . '/' . $school['logo'];
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php
    if ($activeApp === 'dmis') {
      contentTitleWithModal('School Information: ' . strtoupper($schoolName), uri() . '/modules/schools/save-school-dialog.php?id=' . cipher($schoolId), 'Edit', 'fa-edit');
    } elseif ($activeApp === 'hrmis') {
      contentTitleWithModal('School Information: ' . strtoupper($schoolName), uri() . '/modules/employees/new-employee-dialog.php?s=' . cipher($schoolId), 'New Employee', 'fa-user-plus');
    } else {
      contentTitle('School Information: ' . strtoupper($schoolName));
    } ?>
  </div>

  <div class="card-body">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-4 col-xl-2">
        <img src="<?php echo $logo; ?>" width="100%">
      </div>
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-10">
        <div class="table-responsive pt-3">
          <table cellspacing="0">
            <tr>
              <th class="pr-5 align-top" scoper="row">School ID</th>
              <td class="text-uppercase"><?php echo $schoolId; ?></td>
            </tr>
            <tr>
              <th class="pr-5 align-top" scoper="row">Name</th>
              <td class="text-uppercase"><?php echo $schoolName . ' (' . $alias . ')'; ?></td>
            </tr>
            <tr>
              <th class="pr-5 align-top" scoper="row">Address</th>
              <td class="text-uppercase"><?php echo $address; ?></td>
            </tr>
            <tr>
              <th class="pr-5 align-top" scoper="row">District</th>
              <td class="text-uppercase"><?php echo $district; ?></td>
            </tr>
            <tr>
              <th class="pr-5 align-top" scoper="row">Category</th>
              <td class="text-uppercase"><?php echo $category; ?></td>
            </tr>
            <?php if (!empty($head)) : ?>
              <tr>
                <th class="pr-5 align-top" scoper="row">Head of Office</th>
                <td class="text-uppercase">
                  <div><?php echo userName($head); ?></div>
                  <?php
                  $positions = position($head);
                  echo numRows($positions) > 0 ? '<div class="small">' . fetchAssoc($positions)['position'] . '</div>' : '';
                  ?>
                </td>
              </tr>
            <?php endif; ?>
            <?php if (!empty($telephone)) : ?>
              <tr>
                <th class="pr-5 align-top" scoper="row">Telephone</th>
                <td class="text-uppercase"><?php echo $telephone; ?></td>
              </tr>
            <?php endif; ?>
            <?php if (!empty($email)) : ?>
              <tr>
                <th class="pr-5 align-top" scoper="row">Email Address</th>
                <td class="text-lowercase"><?php echo $email; ?></td>
              </tr>
            <?php endif; ?>
            <?php if (!empty($website)) : ?>
              <tr>
                <th class="pr-5 align-top" scoper="row">Website</th>
                <td class="text-lowercase"><?php echo $website; ?></td>
              </tr>
            <?php endif; ?>
            <?php if (!empty($fbPage)) : ?>
              <tr>
                <th class="pr-5 align-top" scoper="row">Facebook Page</th>
                <td class="text-lowercase"><?php echo $fbPage; ?></td>
              </tr>
            <?php endif; ?>
            <tr>
              <th class="pr-5 align-top" scoper="row">Personnel</th>
              <td class="text-lowercase"><?php echo $personnel; ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <?php if ($isHrmis) { ?>
      <div class="d-sm-flex align-items-center flex-row-reverse my-2">
        <div class="d-inline-block">
          <?php linkButtonSplit(customUri('export', 'active-employees', $schoolId), 'Export', 'fa-file-excel', 'Export as Excel file', 'success'); ?>
        </div>
      </div>
    <?php } ?>

    <div class="table-responsive mt-3">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="5%">Employee Number</th>
            <th class="align-middle" width="25%">Name</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="5%">Age</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="15%">Email Address</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middel" width="10%">Progress</th>
              <th class="align-middle" width="5%">Action</th>
            <?php else : ?>
              <th class="align-middle" width="10%">Contact #</th>
            <?php endif; ?>

          </tr>
        </thead>
        <tbody>
          <?php
          $query = activeEmployees($schoolId);
          while ($row = fetchArray($query)) :
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
              <td class="align-middle"><?php echo toHandleNull($row['agency_id'], 'N/A'); ?></td>
              <td class="align-middle text-left">
                <?php if ($isHrmis) {
                  linkItem(customUri('hrmis', 'Employee Information', $row['id']), $employeeName, true);
                } else {
                  echo $employeeName;
                } ?>
              </td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle"><?php echo getAge($row['year'], $row['month'], $row['day']); ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle text-lowercase"><?php echo $row['email']; ?></td>
              <?php if ($isHrmis) { ?>
                <td class="align-middle">
                  <?php progressBar(pdsProgress($row['id'])); ?>
                </td>
                <td class="align-middle text-capitalize">
                  <div class="dropdown no-arrow">
                    <?php dropdownEllipsis(); ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <?php
                      linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee', true);
                      modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee');
                      modalDropdownItem(uri() . '/modules/schools/set-school-head-dialog.php?e=' . cipher($schoolId) . '&id=' . cipher($row['id']), 'Set Head', 'fa-user-tie', 'Set Head of Office'); ?>
                      <div class="dropdown-divider"></div>
                      <?php modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee'); ?>
                    </div>
                  </div>
                </td>
              <?php } else { ?>
                <td class="align-middle"><?php echo $row['mobile']; ?></td>
              <?php } ?>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>