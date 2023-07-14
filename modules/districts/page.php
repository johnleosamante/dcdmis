<?php
// modules/districts/page.php
messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if ($activeApp === 'dmis') {
      contentTitleWithModal('Districts', uri() . '/modules/districts/save-district-dialog.php', 'Add', 'fa-plus');
    } else {
      contentTitle('Districts');
    } ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" rowspan="2" width="5%">#</th>
            <th class="align-middle" rowspan="2" width="25%">District</th>
            <th class="align-middle" rowspan="2" width="45%">Supervisor</th>
            <th class="align-middle" colspan="4" width="20%">Schools</th>
            <th class="align-middle" rowspan="2" width="5%">Action</th>
          </tr>

          <tr>
            <th class="align-middle" width="5%">ES</th>
            <th class="align-middle" width="5%">HS</th>
            <th class="align-middle" width="5%">IS</th>
            <th class="align-middle" width="5%">Total</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $query = districts();
          $no = 0;
          while ($row = fetchAssoc(($query))) : ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo ++$no; ?></td>
              <td class="align-middle text-left"><?php linkItem(customUri($activeApp, 'District Information', $row['id']), $row['name']); ?></td>
              <td class="align-middle">
                <div><?php echo userName($row['psds']); ?></div>
                <div class="small"><?php echo fetchAssoc(position($row['psds']))['position']; ?></div>
              </td>
              <?php
              $schoolCount = districtSchoolCount($row['id']);
              $es = $hs = $is = $total = 0;

              if (numRows($schoolCount) > 0) {
                $count = fetchAssoc($schoolCount);
                $es = $count['es'];
                $hs = $count['hs'];
                $is = $count['is'];
                $total = $count['total'];
              }
              ?>
              <td class="align-middle"><?php echo $es; ?></td>
              <td class="align-middle"><?php echo $hs; ?></td>
              <td class="align-middle"><?php echo $is; ?></td>
              <td class="align-middle"><?php echo $total; ?></td>
              <td class="align-middle text-capitalize">
                <div class="dropdown no-arrow">
                  <?php dropdownEllipsis(); ?>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <?php linkDropdownItem(customUri($activeApp, 'District Information', $row['id']), 'View', 'fa-eye', 'View District'); ?>
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