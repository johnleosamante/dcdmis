<?php
// modules/employees/active-employees.php
messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink('Archived Employees', uri() . '/hrmis'); ?>
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
            <th class="align-middle" width="15%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="10%">Progress</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = archivedEmployees();
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
              <td class="align-middle text-left"><?php linkItem(customUri('hrmis', 'Employee Information', $row['id']), $employeeName); ?></td>
              <td class="align-middle">
                <?php
                $status = strtolower($row['status']);
                roundPill($status);
                ?>
              </td>
              <td class="align-middle"><?php echo toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y'); ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle">
                <?php linkItem(customUri($activeApp, 'School Information', $row['station']), fetchAssoc(schoolById($row['station']))['name']); ?>
              </td>
              <td class="align-middle"><?php progressBar(pdsProgress($row['id'])); ?></td>
              <td class="align-middle text-capitalize">
                <?php if ($status !== 'duplicate') : ?>
                  <div class="dropdown no-arrow">
                    <?php dropdownEllipsis(); ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                      <?php linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee'); ?>
                    </div>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-mdille" width="10%">Status</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="15%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="10%">Progress</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>