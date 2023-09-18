<?php
// modules/service-record/page.php
messageAlert($showAlert, $message, $success);

$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$employees = employee($employeeId);

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
} else {
  require_once(root() . '/modules/error/no-results-found.php');
  return;
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($isHrmis) {
      contentTitleWithModal('Service Record : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus');
    } else {
      contentTitleWithLink('Service Record', uri() . '/pis');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" colspan="2" width="10%">Service<br>(Inclusive Dates)</th>
            <th class="align-middle" colspan="3" width="35%">Record of Appointment</th>
            <th class="align-middle" rowspan="2" width="20%">Office Entity/Division/Station/Place/Branch of Assignment</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" rowspan="2" width="5%">Actions</th>
            <?php endif; ?>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
            <th class="align-middle" width="15%">Designation</th>
            <th class="align-middle" width="10%">Employment Status</th>
            <th class="align-middle" width="10%">Salary</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $services = serviceRecords($employeeId);

          while ($service = fetchAssoc($services)) : ?>
            <tr>
              <td class="align-middle"><?php echo toDate($service['from']); ?></td>
              <td class="align-middle"><?php echo $service['ispresent'] ? 'PRESENT' : toDate($service['to']); ?></td>
              <td class="align-middle"><?php echo $service['position']; ?></td>
              <td class="align-middle"><?php echo $service['status']; ?></td>
              <td class="align-middle"><?php echo toCurrency($service['salary'] * 12); ?></td>
              <td class="align-middle"><?php echo $service['station']; ?></td>
              <?php if ($isHrmis) : ?>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                  <?php modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($service['no']), 'Edit', 'fa-edit', 'Edit Service Record'); ?>
                  </div>
                </div>
              </td>
              <?php endif; ?>
            </tr>
          <?php endwhile; ?>
        </tbody>

        <tfoot>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
            <th class="align-middle" width="15%">Designation</th>
            <th class="align-middle" width="10%">Employment Status</th>
            <th class="align-middle" width="10%">Salary</th>
            <th class="align-middle" rowspan="2" width="20%">Office Entity/Division/Station/Place/Branch of Assignment</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" rowspan="2" width="5%">Actions</th>
            <?php endif; ?>
          </tr>
          <tr>
            <th class="align-middle" colspan="2" width="10%">Service<br>(Inclusive Dates)</th>
            <th class="align-middle" colspan="3" width="35%">Record of Appointment</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>