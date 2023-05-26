<?php
// modules/employees/view/learning-development.php
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'learning-development', 'show active'); ?>" id="learning-development">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="35%" rowspan="2">Title of Learning &amp; Development Interventions / Training Programs</th>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="5%" rowspan="2">Number of Hours</th>
            <th class="align-middle" width="10%" rowspan="2">Type of Learning &amp; Development</th>
            <th class="align-middle" width="30%" rowspan="2">Conducted / Sponsored by</th>
            <th class="align-middle" width="10%" rowspan="2">Attachment</th>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $learnings = learning_and_development($employee['id']);

          if (num_rows($learnings) > 0) {
            while ($learning = fetch_assoc($learnings)) : ?>
              <tr>
                <td class="align-middle"><?php echo $learning['title']; ?></td>
                <td class="align-middle"><?php echo to_date($learning['from']); ?></td>
                <td class="align-middle"><?php echo to_date($learning['to']); ?></td>
                <td class="align-middle"><?php echo $learning['hours']; ?></td>
                <td class="align-middle"><?php echo $learning['type']; ?></td>
                <td class="align-middle"><?php echo $learning['sponsor']; ?></td>
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