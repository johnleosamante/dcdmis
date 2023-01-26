<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'work-experience'); ?>" id="work-experience">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Work Experience</h3>
    <a class="btn btn-primary btn-icon-split btn-sm" onclick="viewdata('Modal', 'pds/update/update-work-experience.php?id=')" data-toggle="modal" data-target="#Modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="15%" rowspan="2">Position Title</th>
            <th class="align-middle" width="25%" rowspan="2">Department / Agency / Office / Company</th>
            <th class="align-middle" width="10%" rowspan="2">Monthly Salary</th>
            <th class="align-middle" width="10%" rowspan="2">Salary / Job / Pay Grade &amp; Step Increment</th>
            <th class="align-middle" width="10%" rowspan="2">Status of Appointment</th>
            <th class="align-middle" width="10%" rowspan="2">Government Service</th>
            <th class="align-middle" width="10%" rowspan="2">Action</th>
          </tr>
          <tr class="text-center">
            <th width="5%" class="align-middle">From</th>
            <th width="5%" class="align-middle">To</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $experiences = mysqli_query($con, "SELECT * FROM work_experience WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY `From` DESC;");

          if (mysqli_num_rows($experiences) > 0) {
            while ($experience = mysqli_fetch_array($experiences)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo ToDateString($experience['From']); ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($experience['To']); ?></td>
                <td class="text-center align-middle"><?php echo $experience['Position_Title']; ?></td>
                <td class="text-center align-middle"><?php echo $experience['Organization']; ?></td>
                <td class="text-center align-middle"><?php echo $experience['Monthly_Salary']; ?></td>
                <td class="text-center align-middle"><?php echo $experience['Salary_Grade']; ?></td>
                <td class="text-center align-middle"><?php echo $experience['Job_Status']; ?></td>
                <td class="text-center align-middle"><?php echo $experience['Goverment']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-work-experience.php?id=<?php echo $experience['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-work-experience.php?id=<?php echo $experience['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="9">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->