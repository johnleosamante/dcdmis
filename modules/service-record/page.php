<?php
// modules/service-record/page.php
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
      contentTitleWithModal('Service Record : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus');
    } else {
      contentTitleWithLink('Service Record', uri() . '/pis');
    } ?>
  </div>

  <div class="card-body">
    <?php if ($isHrmis) { ?>
      <div class="d-sm-flex align-items-center flex-row-reverse my-2">
        <div class="d-inline-block">
          <?php linkButtonSplit(customUri('print', 'Service Record', $employeeId), 'Print', 'fa-print', 'Print file', 'success', true); ?>
        </div>
      </div>
    <?php } ?>

    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" colspan="2" width="10%">Service<br>(Inclusive Dates)</th>
            <th class="align-middle" colspan="3" width="30%">Record of Appointment</th>
            <th class="align-middle" rowspan="2" width="15%">Office Entity/Division<br>Station/Place/Branch of Assignment</th>
            <th class="align-middle" rowspan="2" width="10%">Leave Without Pay</th>
            <th class="align-middle" colspan="2" width="10%">Separation</th>
            <th class="align-middle" rowspan="2" width="5%">Remarks</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" rowspan="2" width="5%">Actions</th>
            <?php endif; ?>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
            <th class="align-middle" width="10%">Designation</th>
            <th class="align-middle" width="10%">Employment Status</th>
            <th class="align-middle" width="10%">Salary</th>
            <th class="align-middle" width="5%">Date</th>
            <th class="align-middle" width="5%">Cause</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $services = experiences($employeeId);

          while ($service = fetchAssoc($services)) : ?>
            <tr>
              <td class="align-middle"><?php echo toDate($service['from']); ?></td>
              <td class="align-middle"><?php echo $service['ispresent'] ? 'PRESENT' : toDate($service['to']); ?></td>
              <td class="align-middle"><?php echo $service['position_code']; ?></td>
              <td class="align-middle"><?php echo $service['status']; ?></td>
              <td class="align-middle"><?php echo !empty($service['salary']) ? toCurrency($service['salary']) : 'N/A'; ?></td>
              <td class="align-middle"><?php echo $service['organization_alias']; ?></td>
              <td class="align-middle"><?php echo toHandleNull($service['leave_dates'], 'N/A'); ?></td>
              <td class="align-middle">
                <?php echo $service['isseparation'] === '1' ? toDate($service['separation_date']) : 'N/A'; ?>
              </td>
              <td class="align-middle">
                <?php echo $service['isseparation'] === '1' ? toHandleNull($service['separation_cause'], 'N/A') : 'N/A'; ?>
              </td>
              <td class="align-middle">
                <?php echo toHandleNull($service['sg']); ?>
              </td>
              <?php if ($isHrmis) : ?>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                  <?php modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($service['no']), 'Edit', 'fa-edit', 'Edit Service Record');
                  modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($service['no']), 'Copy', 'fa-copy', 'Copy Service Record'); ?>
                  <div class="dropdown-divider"></div>
                  <?php modalDropdownItem(uri() .'/modules/service-record/delete-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($service['no']), 'Delete', 'fa-trash', 'Delete Service Record'); ?>
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
            <th class="align-middle" width="10%">Designation</th>
            <th class="align-middle" width="10%">Employment Status</th>
            <th class="align-middle" width="10%">Salary</th>
            <th class="align-middle" rowspan="2" width="20%">Office Entity/Division/Station/Place/Branch of Assignment</th>
            <th class="align-middle" rowspan="2" width="10%">Leave Without Pay</th>
            <th class="align-middle" width="5%">Date</th>
            <th class="align-middle" width="5%">Cause</th>
            <th class="align-middle" rowspan="2" width="5%">Remarks</th>
            <?php if ($isHrmis) : ?>
              <th class="align-middle" rowspan="2" width="5%">Actions</th>
            <?php endif; ?>
          </tr>
          <tr>
            <th class="align-middle" colspan="2" width="10%">Service<br>(Inclusive Dates)</th>
            <th class="align-middle" colspan="3" width="30%">Record of Appointment</th>
            <th class="align-middle" colspan="2" width="10%">Separation</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>