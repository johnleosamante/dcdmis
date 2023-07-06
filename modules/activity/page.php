<?php
// modules/activity/page.php
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle('Activity Log'); ?>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="align-middle" width="5%">#</th>
            <th class="align-middle" width="15%">Date/Time</th>
            <th class="align-middle" width="65%">Activity</th>
            <th class="align-middle" width="15%">IP Address</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = userLog($userId);
          $no = 0;
          while ($row = fetchAssoc($query)) : ?>
            <tr class="text-uppercase">
              <td class="align-middle"><?php echo ++$no; ?></td>
              <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
              <td class="text-left align-middle"><?php echo $row['activity']; ?></td>
              <td class="align-middle"><?php echo $row['ip']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>