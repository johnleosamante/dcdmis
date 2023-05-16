<?php
// modules/employees/view/educational-background.php
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'educational-background', 'show active'); ?>" id="educational-background">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="10%" rowspan="2">Level</th>
            <th class="align-middle" width="25%" rowspan="2">Name of School</th>
            <th class="align-middle" width="20%" rowspan="2">Basic Education / Degree / Course</th>
            <th class="align-middle" width="10%" colspan="2">Period of Attendance</th>
            <th class="align-middle" width="10%" rowspan="2">Highest Level / Units Earned</th>
            <th class="align-middle" width="5%" rowspan="2">Year Graduated</th>
            <th class="align-middle" width="15%" rowspan="2">Scholarship / Academic Honors Received</th>
            <th class="align-middle" width="5%" rowspan="2">Attachment</th>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $education_background = education($employee['id']);

          if (num_rows($education_background) > 0) {
            while ($education = fetch_assoc($education_background)) : ?>
              <tr>
                <td class="align-middle"><?php echo $education['level']; ?></td>
                <td class="align-middle"><?php echo $education['school']; ?></td>
                <td class="align-middle"><?php echo to_handle_null($education['course'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo $education['from']; ?></td>
                <td class="align-middle"><?php echo $education['to']; ?></td>
                <td class="align-middle"><?php echo to_handle_null($education['highest'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo to_handle_null($education['year_graduated'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo to_handle_null($education['scholarship'], 'N/A'); ?></td>
                <td class="align-middle"><?php round_pill('None'); ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="9" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->