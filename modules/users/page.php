<?php
// modules/users/active-users.php
messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithModal('Users', uri() . '/users/update-user.php', 'New User', 'fa-user-plus'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="20%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-middle" width="15%">Email Address</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="10%">Status</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = users();
          while ($row = fetchArray($query)) :
            $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
            $photo = uri() . '/' . $row['picture'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                  <img height="100%" src="<?php echo $photo; ?>" alt="<?php echo $employeeName; ?>">
                </span>
              </td>
              <td class="align-middle text-left"><?php echo $employeeName; ?></td>
              <td class="align-middle"><?php sex($row['sex']); ?></td>
              <td class="align-middle text-lowercase"><?php echo $row['email']; ?></td>
              <td class="align-middle"><?php echo fetchAssoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo stationName($row['station']); ?></td>
              <td class="align-middle">
                <?php
                $status = strtolower($row['status']);
                roundPill($status);
                ?>
              </td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    modalDropdownItem(uri() . '/modules/users/view-user-dialog.php?id=' . cipher($row['id']), 'View', 'fa-edit', 'View User');
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php modalDropdownItem(uri() . '/modules/users/remove-user-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove User'); ?>
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