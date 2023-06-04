<?php
// modules/employees/celebrant-employees.php
$page_title = 'Celebrant Employees';
$now = date('Y-m-d');
//date('F Y', strtotime($now . ' + 1 month')
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitleWithLink($page_title, uri() . '/hrmis'); ?>
  </div>

  <div class="card-body">
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#previous-month" data-toggle="tab"><?php echo date('F Y', strtotime($now . ' - 1 month')); ?></a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary active" href="#current-month" data-toggle="tab"><?php echo date('F Y'); ?></a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#next-month" data-toggle="tab"><?php echo date('F Y', strtotime($now . ' + 1 month')); ?></a>
      </li><!-- .nav-item -->
    </ul><!-- nav-tabs -->

    <div class="tab-content">
      <?php
      $months = 0;
      while ($months < 3) {
        switch ($months) {
          case 0:
            $datetimeString = $now . ' - 1 month';
            $tabID = 'previous-month';
            break;
          case 2:
            $datetimeString = $now . ' + 1 month';
            $tabID = 'next-month';
            break;
          default:
            $datetimeString = $now;
            $tabID = 'current-month';
            break;
        }
      ?>
        <div class="tab-pane fade <?php echo setActiveItem($months, 1, 'show active'); ?>" id="<?php echo $tabID; ?>">
          <?php $bmonth = date('m', strtotime($datetimeString)); ?>
          <div class="row">
            <div class="col table-responsive">
              <table class="table table-hover mb-0 text-center" <?php echo $months === 1 ? 'id="dataTable"' : ''; ?>width="100%" cellspacing="0">
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
                  $query = celebrantEmployees($bmonth);
                  if (numRows($query) > 0) {
                    while ($row = fetchArray($query)) :
                      $employee_name =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
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
                    <?php endwhile;
                  } else { ?>
                    <tr>
                      <td colspan="8" class="align-middle">No data available in table</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php
        $months++;
      } ?>
    </div>
  </div>
</div>