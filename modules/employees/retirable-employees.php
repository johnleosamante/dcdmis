<?php
// modules/employees/active-employees.php
$page_title = 'Retirable Employees';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink($page_title, uri() . '/hrmis'); ?>
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
          $query = retirableEmployees();
          while ($row = fetchArray($query)) :
            $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
            $photo = uri() . '/' . $row['picture'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <span class="employee-photo rounded-circle overflow-hidden">
                  <img width="100%" src="<?php echo $photo; ?>" alt="<?php echo $employeeName; ?>">
                </span>
              </td>
              <td class="align-middle"><?php echo toHandleNull($row['agency_id'], 'N/A'); ?></td>
              <td class="align-middle text-left"><?php echo $employeeName; ?></td>
              <td class="align-middle"><?php sex($row['sex']); ?></td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle">
                <?php echo getAge($row['year'], $row['month'], $row['day']); ?>
              </td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
                    linkDropdownItem(customUri('hrmis', 'Transfer Employee', $row['id']), 'Transfer', 'fa-share', 'Transfer Employee'); ?>
                    <div class="dropdown-divider"></div>
                    <?php linkDropdownItem(customUri('hrmis', 'Remove Employee', $row['id']), 'Remove', 'fa-times-circle', 'Remove Employee', 'text-danger', false);
                    ?>
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