<?php
// modules/employees/view/recognition.php
?>

<div class="tab-pane fade" id="recognition">
  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
            <th class="align-middle" width="10%">Attachment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $recognitions = recognition($employee['id']);

          if (num_rows($recognitions) > 0) {
            while ($recognition = fetch_assoc($recognitions)) : ?>
              <tr>
                <td class="align-middle"><?php echo $recognition['recognition']; ?></td>
                <td class="align-middle"><?php round_pill('None', 'danger'); ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="1" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->