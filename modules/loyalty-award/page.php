<?php
// modules/loyalty-award/page.php
if (!$isHrmis) {
  require_once(root() . '/modules/error/403.php');
  return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Employees Eligible for Loyalty Award', uri() . '/hrmis'); ?>
  </div>

  <div class="card-body">
    <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
      <?php linkButtonSplit(customUri('export', 'loyalty-award'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success'); ?>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="25%">Station</th>
            <th class="align-middle" width="15">Date of Original Appointment</th>
            <th class="align-middle" width="10%">Years in Service</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = loyaltyAward();
          while ($row = fetchArray($query)) :
            $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
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
                <?php linkItem(customUri('hrmis', 'Employee Information', $row['id']), $employeeName); ?>
              </td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle">
                <?php linkItem(customUri($activeApp, 'School Information', $row['station']), fetchAssoc(schoolById($row['station']))['name']); ?>
              </td>
              <td class="align-middle"><?php echo toDate($row['doa']); ?></td>
              <td class="align-middle"><?php echo $row['work_years']; ?></td>
              <td class="align-middle text-capitalize">
              <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php modalDropdownItem(uri() . '/modules/loyalty-award/approve-loyalty-award-dialog.php?id=' . cipher($row['id']), 'Approve', 'fa-thumbs-up', 'Approve Employee Loyalty Award'); ?>
                    <div class="dropdown-divider"></div>
                    <?php 
                    modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee');
                    modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee');
                    ?>
                  </div>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="25%">Station</th>
            <th class="align-middle" width="15">Date of Original Appointment</th>
            <th class="align-middle" width="10%">Years in Service</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>