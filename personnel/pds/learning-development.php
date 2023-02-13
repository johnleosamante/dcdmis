<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'learning-development'); ?>" id="learning-development">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Learning &amp; Development (L&D) Interventions / Training Programs</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-learning-development.php?id=')" data-toggle="modal" data-target="#Modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="30%" rowspan="2">Title Learning and Development Interventions / Training Programs</th>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="10%" rowspan="2">Number of Hours</th>
            <th class="align-middle" width="10%" rowspan="2">Type of Learning &amp; Development</th>
            <th class="align-middle" width="30%" rowspan="2">Conducted / Sponsored by</th>
            <th class="align-middle" rowspan="2" width="10%">Action</th>
          </tr>
          <tr class="text-center">
            <th class="align-middle" width="5%">From</th>
            <th class="align-middle" width="5%">To</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $trainings = mysqli_query($con, "SELECT * FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY `From` DESC;");

          if (mysqli_num_rows($trainings) > 0) {
            while ($training = mysqli_fetch_array($trainings)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $training['Title_of_Training']; ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($training['From']); ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($training['To']); ?></td>
                <td class="text-center align-middle"><?php echo $training['Number_of_Hours']; ?></td>
                <td class="text-center align-middle"><?php echo $training['Managerial']; ?></td>
                <td class="text-center align-middle"><?php echo $training['Conducted']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-learning-development.php?id=<?php echo $training['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-learning-development.php?id=<?php echo $training['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="7">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->