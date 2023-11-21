<?php
// modules/201-file/page.php
if (!$isPis && !$isHrmis) {
  require_once(root() . '/modules/error/403.php');
  return;
}

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

$uploadDirectory = root() . '/uploads/201_files/' . $employeeId;

if (!is_dir($uploadDirectory)) {
  mkdir($uploadDirectory, 0777, true);
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($isHrmis) {
      contentTitleWithModal('201 Files : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/modules/201-file/save-201-file-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus');
    } else {
      contentTitleWithLink('201 Files', uri() . '/pis');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="25%">Uploaded on</th>
            <th class="align-middle" width="75%">Description</th>
            <th class="align-middle" width="5%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $results = fileAttachments($employeeId);

          while ($row = fetchAssoc($results)) : ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
              <td class="align-middle text-left"><?php echo $row['description']; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                    <?php
                    downloadLinkDropdownItem(uri() . '/' . $row['filename'], 'Download', 'fa-download', 'Download ' . $row['description'], $row['description'] . '.' . $row['ext'], true);

                    if ($isHrmis) {
                      modalDropdownItem(uri() . '/modules/201-file/save-201-file-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($row['no']), 'Edit', 'fa-edit', 'Edit 201 File');
                      modalDropdownItem(uri() . '/modules/201-file/save-201-file-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($row['no']), 'Copy', 'fa-copy', 'Copy 201 File'); ?>
                    <div class="dropdown-divider"></div>
                    <?php modalDropdownItem(uri() . '/modules/201-file/delete-201-file-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($row['no']), 'Delete', 'fa-trash', 'Delete 201 File');
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