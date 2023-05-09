<?php
// modules/employees/view/membership.php
?>

<div class="tab-pane fade" id="membership">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="90%">Membership in Association / Organization</th>
            <th class="align-middle" width="10%">Attachment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $organizations = membership($employee['id']);

          if (num_rows($organizations) > 0) {
            while ($membership = fetch_assoc($organizations)) : ?>
              <tr>
                <td class="align-middle"><?php echo $membership['organization']; ?></td>
                <td class="align-middle"><?php round_pill('None', 'danger'); ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td class="align-middle" colspan="2">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->