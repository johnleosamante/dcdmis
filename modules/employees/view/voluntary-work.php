<?php
// modules/employees/view/voluntary-work.php
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'voluntary-work', 'show active'); ?>" id="voluntary-work">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="45" rowspan="2">Name &amp; Address of Organization</th>
            <th class="align-middle" width="10%" rowspan="2">Inclusive Dates</th>
            <th class="align-middle" width="10%" colspan="2">Number of Hours</th>
            <th class="align-middle" width="30%" rowspan="2">Position / Nature of Work</th>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $voluntary_work = voluntary_works($employee['id']);

          if (num_rows($voluntary_work) > 0) {
            while ($voluntary = fetch_assoc($voluntary_work)) : ?>
              <tr>
                <td class="align-middle"><?php echo $voluntary['organization']; ?></td>
                <td class="align-middle"><?php echo to_date($voluntary['from']); ?></td>
                <td class="align-middle"><?php echo to_date($voluntary['to']); ?></td>
                <td class="align-middle"><?php echo $voluntary['hours']; ?></td>
                <td class="align-middle"><?php echo $voluntary['position']; ?></td>
              </tr>
            <?php endwhile;
          } else {
            ?>
            <tr>
              <td colspan="5" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->