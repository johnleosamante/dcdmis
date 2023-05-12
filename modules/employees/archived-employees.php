<?php
// modules/employees/active-employees.php
$page_title = 'Archived Employees';
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
            <th class="align-middle" width="30%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-mdille" width="10">Status</th>
            <th class="align-middle" width="20%">Last Position</th>
            <th class="align-middle" width="25%">Last Station</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = archived_employees();
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
              <td class="align-middle">
                <?php
                $color = null;
                $status = strtolower($row['status']);

                switch ($status) {
                  case 'transferred':
                  case 'resigned':
                    $color = 'warning';
                    break;
                  case 'retired':
                  case 'deceased':
                    $color = 'danger';
                    break;
                  default:
                    $color = 'secondary';
                    break;
                }

                round_pill($row['status'], $color);
                ?>
              </td>
              <td class="align-middle"><?php echo fetch_assoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetch_assoc(school_by_id($row['station']))['name']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdown_ellipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php
                    link_dropdown_item(custom_uri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee');
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