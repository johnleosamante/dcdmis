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
            <th class="align-middle" width="10%">Employee Number</th>
            <th class="align-middle" width="30%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-mdille" width="10">Status</th>
            <th class="align-middle" width="15%">Position</th>
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
                <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                  <img height="100%" src="<?php echo $photo; ?>" alt="<?php echo $employeeName; ?>">
                </span>
              </td>
              <td class="align-middle"><?php echo toHandleNull($row['agency_id'], 'N/A'); ?></td>
              <td class="align-middle text-left"><?php echo $employeeName; ?></td>
              <td class="align-middle"><?php sex($row['sex']); ?></td>
              <td class="align-middle">
                <?php
                $color = null;
                $status = strtolower($row['status']);

                roundPill($row['status']);
                ?>
              </td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(schoolById($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
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
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>