<?php
// modules/certificates/page.php
$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if ($isPis && $userId !== $employeeId) {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

$employees = employee($employeeId);

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}

if ($isHrmis) {
  require_once(root() . '/modules/employees/employee-tabs.php');
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($isHrmis) {
      contentTitleWithModal('Certificates : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/modules/certificates/save-201-file-dialog.php', 'Add', 'fa-plus');
    } else {
      contentTitleWithLink('Certificates', uri() . '/pis');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="40%">Title</th>
            <th class="align-middle" width="15%">Date Issued</th>
            <th class="align-middle" width="15%">Category</th>
            <th class="align-middle" width="15%">Level</th>
            <th class="align-middle" width="15%">Date Uploaded</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" width="5%">Action</th>
            <?php endif; ?>
          </tr>
        </thead>

        <tbody>
          <?php
          $results = certificates($employeeId);

          while ($row = fetchAssoc($results)) : ?>
            <tr>
              <td class="align-middle"><?php echo $row['title']; ?></td>
              <td class="align-middle"><?php echo toDate($row['date_awarded']); ?></td>
              <td class="align-middle"><?php echo $row['category']; ?></td>
              <td class="align-middle"><?php echo $row['level']; ?></td>
              <td class="align-middle"><?php echo toDate($row['datetime'], 'm/d/y h:i:s A'); ?></td>
              <?php if ($isHrmis) : ?>
                <td class="align-middle"></td>
              <?php endif; ?>
            </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="40%">Title</th>
            <th class="align-middle" width="15%">Date Issued</th>
            <th class="align-middle" width="15%">Category</th>
            <th class="align-middle" width="15%">Level</th>
            <th class="align-middle" width="15%">Date Uploaded</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" width="5%">Action</th>
            <?php endif; ?>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>