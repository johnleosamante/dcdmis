<?php
// modules/employees/view/work-experience.php
?>

<div class="tab-pane fade<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'work-experience', 'show active'); ?>" id="work-experience">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="20%" rowspan="2">Position Title</th>
            <th class="align-middle" width="30%" rowspan="2">Department / Agency / Office / Company</th>
            <th class="align-middle" width="10%" rowspan="2">Monthly Salary</th>
            <th class="align-middle" width="10%" rowspan="2">Salary / Job / Pay Grade &amp; Step Increment</th>
            <th class="align-middle" width="10%" rowspan="2">Status of Appointment</th>
            <th class="align-middle" width="10%" rowspan="2">Government Service</th>
          </tr>
          <tr>
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $experiences = experiences($employeeId);

          if (numRows($experiences) > 0) {
            while ($experience = fetchAssoc($experiences)) : ?>
              <tr>
                <td class="align-middle"><?php echo toDate($experience['from']); ?></td>
                <td class="align-middle"><?php echo $experience['ispresent'] ? 'PRESENT' : toDate($experience['to']); ?></td>
                <td class="align-middle"><?php echo $experience['position']; ?></td>
                <td class="align-middle"><?php echo $experience['organization']; ?></td>
                <td class="align-middle"><?php echo !empty($experience['salary']) ? toCurrency($experience['salary'] / 12) : 'N/A'; ?></td>
                <td class="align-middle"><?php echo toHandleNull($experience['sg'], 'N/A'); ?></td>
                <td class="align-middle"><?php echo $experience['status']; ?></td>
                <td class="align-middle"><?php echo $experience['isgovernment']; ?></td>
              </tr>
            <?php endwhile;
          } else { ?>
            <tr>
              <td colspan="8" class="align-middle">No data available in table</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>