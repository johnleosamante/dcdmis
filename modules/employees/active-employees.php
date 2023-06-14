<?php
// modules/employees/active-employees.php
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Active Employees', uri() . '/hrmis'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="10%">Employee Number</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="5%">Age</th>
            <th class="align-middle" width="15%">Position</th>
            <th class="align-middle" width="20%">Station</th>
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
                <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                  <img height="100%" src="<?php echo $photo; ?>" alt="<?php echo $employeeName; ?>">
                </span>
              </td>
              <td class="align-middle"><?php echo toHandleNull($row['agency_id'], 'N/A'); ?></td>
              <td class="align-middle text-left"><?php echo $employeeName; ?></td>
              <td class="align-middle"><?php sex($row['sex']); ?></td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle"><?php echo getAge($row['year'], $row['month'], $row['day']); ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
                    modalDropdownItem(uri() . '/modules/employees/transfer-employee-dialog.php?id=' . cipher($row['id']), 'Transfer', 'fa-share', 'Transfer Employee');
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee'); ?>
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