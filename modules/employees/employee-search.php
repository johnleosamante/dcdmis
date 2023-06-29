<?php
// modules/employees/employee-search.php
$search = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$employees = employeeSearch($search);

if (numRows($employees) === 0) {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink("Employee Search : \"{$search}\"", uri() . '/hrmis'); ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-mdille" width="10%">Status</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="5%">Age</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          while ($row = fetchArray($employees)) :
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
              <td class="align-middle">
                <?php
                $status = strtolower($row['status']);
                roundPill($status);
                ?>
              </td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle"><?php echo getAge($row['year'], $row['month'], $row['day']); ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <?php if ($status !== 'duplicate') : ?>
                  <div class="dropdown no-arrow">
                    <?php dropdownEllipsis(); ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <?php
                      linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
                      if ($status === 'active') {
                        modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee'); ?>
                        <div class="dropdown-divider"></div>
                      <?php modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee');
                      } ?>
                    </div>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>