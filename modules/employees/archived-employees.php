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
      <table class="table table-striped table-hover table-bordered mb-0 text-center" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">Photo</th>
            <th class="align-middle" width="25%">Name</th>
            <th class="align-middle" width="5%">Sex</th>
            <th class="align-middle" width="15%">Date of Birth</th>
            <th class="align-mdille" width="10">Status</th>
            <th class="align-middle" width="15%">Last Position</th>
            <th class="align-middle" width="20%">Last Station</th>
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
              <td class="align-middle"><?php echo $row['sex']; ?></td>
              <td class="align-middle"><?php echo to_date($row['month'] . '/' . $row['day'] . '/' . $row['year'], '', 'F d, Y'); ?></td>
              <td class="align-middle"><?php echo $row['status']; ?></td>
              <td class="align-middle"><?php echo fetch_assoc(positions($row['position']))['position']; ?></td>
              <td class="align-middle"><?php echo fetch_assoc(school_by_id($row['station']))['name']; ?></td>
              <td class="align-middle">
                <?php
                link_button_icon(custom_uri('hrmis', 'View Employee', $row['id']), 'fa-eye', 'success', 'View Employee');
                ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>