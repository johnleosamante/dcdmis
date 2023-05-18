<?php
// modules/employees/active-employees.php
$page_title = 'Active Employees';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title_with_link($page_title, uri() . '/hrmis'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover mb-0 text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="25%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-middle" width="5%">Age</th>
            <th class="align-middle" width="20%">Position</th>
            <th class="align-middle" width="20%">Station</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = active_employees();
          while ($row = fetch_array($query)) :
            $employee_name =  to_name($row['lname'], $row['fname'], $row['mname'], $row['ext']);
            $photo = uri() . '/' . $row['picture'];
          ?>
            <tr class="text-uppercase">
              <td class="align-middle">
                <span class="employee-photo rounded-circle overflow-hidden">
                  <img width="100%" src="<?php echo $photo; ?>" alt="<?php echo $employee_name; ?>">
                </span>
              </td>
              <td class="align-middle text-left"><?php echo $employee_name; ?></td>
              <td class="align-middle"><?php sex($row['sex']); ?></td>
              <td class="align-middle"><?php echo to_date($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F d, Y'); ?></td>
              <td class="align-middle"><?php echo get_age($row['year'], $row['month'], $row['day']); ?></td>
              <td class="align-middle"><?php echo fetch_assoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetch_assoc(school_by_id($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdown_ellipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    link_dropdown_item(custom_uri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
                    link_dropdown_item(custom_uri('hrmis', 'Transfer Employee', $row['id']), 'Transfer', 'fa-share', 'Transfer Employee');
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php link_dropdown_item(custom_uri('hrmis', 'Remove Employee', $row['id']), 'Remove', 'fa-times-circle', 'Remove Employee','text-danger', false); ?>
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