<?php
// modules/employees/view/civil-service-eligibility.php
?>

<div class="tab-pane fade" id="civil-service-eligibility">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="30%" rowspan="2">Career Services / RA 1080 (Board / Bar) Under Special Laws / CES / CSEE Barangay Eligibility / Driver's License</th>
            <th class="align-middle" width="10%" rowspan="2">Rating</th>
            <th class="align-middle" width="10%" rowspan="2">Date of Examination / Conferment</th>
            <th class="align-middle" width="25%" rowspan="2">Place of Examination / Conferment</th>
            <th class="align-middle" width="20%" colspan="2">License</th>
            <th class="align-middle" width="5%" rowspan="2">Attachment</th>
          </tr>
          <tr>
            <th class="align-middle" width="10%">Number</th>
            <th class="align-middle" width="10%">Date of Validity</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $eligibilities = eligibility($employee['id']);

          if (num_rows($eligibilities) > 0) {
            while ($eligibility = fetch_assoc($eligibilities)) : ?>
              <tr>
                <td class="align-middle"><?php echo $eligibility['eligibility']; ?></td>
                <td class="align-middle"><?php echo to_handle_null($eligibility['rating'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo to_date($eligibility['date']); ?></td>
                <td class="align-middle"><?php echo $eligibility['place']; ?></td>
                <td class="align-middle"><?php echo to_handle_null($eligibility['license'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo to_date($eligibility['validity'], 'N/A'); ?></td>
                <td class="align-middle"><?php round_pill('None'); ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="7" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->