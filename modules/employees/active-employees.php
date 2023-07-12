<?php
// modules/employees/active-employees.php
messageAlert($showAlert, $message, $success);
$isHrmis = $activeApp === 'hrmis';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($isHrmis) {
      contentTitleWithLink('Active Employees', uri() . '/hrmis');
    } else {
      contentTitle('Employees');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="25%">Name</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="5%">Age</th>
            <th class="align-middle" width="15%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="10%">Progress</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = activeEmployees();
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
              <td class="align-middle text-left"><?php echo $employeeName; ?></td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle"><?php echo getAge($row['year'], $row['month'], $row['day']); ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle">
                <?php progressBar(pdsProgress($row['id'])); ?>
              </td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    if ($isHrmis) {
                      linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
                      modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee');
                    ?>
                      <div class="dropdown-divider"></div>
                    <?php modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee');
                    } else {
                      modalDropdownItem(uri() . '/modules/users/edit-user-dialog.php?id=' . cipher($row['id']), 'Set User', 'fa-user-cog', 'Set User Access');
                      modalDropdownItem(uri() . '/modules/users/reset-user-dialog.php?id=' . cipher($row['id']), 'Reset', 'fa-undo-alt', 'Reset User');
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