<?php
// modules/employees/view/reference.php
?>

<div class="tab-pane fade" id="reference">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="40%">Name</th>
            <th class="align-middle" width="45%">Address</th>
            <th class="align-middle" width="15%">Contact Number</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $references = reference($employee['id']);

          if (num_rows($references) > 0) {
            while ($reference = fetch_assoc($references)) : ?>
              <tr>
                <td class="align-middle"><?php echo $reference['name']; ?></td>
                <td class="align-middle"><?php echo to_handle_null($reference['address'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo to_handle_null($reference['telephone'], 'N/A'); ?></td>
              </tr>
          <?php
            endwhile;
          } else { ?>
            <tr>
              <td colspan="3" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->