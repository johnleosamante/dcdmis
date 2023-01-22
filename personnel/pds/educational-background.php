<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'educational-background'); ?>" id="educational-background">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Educational Background</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-education.php?id=')" data-toggle="modal" data-target="#Modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="10%" rowspan="2">Level</th>
            <th class="align-middle" width="20%" rowspan="2">Name of School</th>
            <th class="align-middle" width="20%" rowspan="2">Basic Education / Degree / Course</th>
            <th class="align-middle" width="10%" colspan="2">Period of Attendance</th>
            <th class="align-middle" width="10%" rowspan="2">Highest Level / Units Earned</th>
            <th class="align-middle" width="5%" rowspan="2">Year Graduated</th>
            <th class="align-middle" width="15%" rowspan="2">Scholarship / Academic Honors Received</th>
            <th class="align-middle" width="10%" rowspan="2">Action</th>
          </tr>
          <tr class="text-center">
            <th class="align-middle">From</th>
            <th class="align-middle">To</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $educationalBackground = mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY `From` ASC;");

          if (mysqli_num_rows($educationalBackground) > 0) {
            while ($education = mysqli_fetch_array($educationalBackground)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $education['Level']; ?></td>
                <td class="text-center align-middle"><?php echo $education['Name_of_School']; ?></td>
                <td class="text-center align-middle"><?php echo $education['Course']; ?></td>
                <td class="text-center align-middle"><?php echo $education['From']; ?></td>
                <td class="text-center align-middle"><?php echo $education['To']; ?></td>
                <td class="text-center align-middle"><?php echo $education['Highest_Level']; ?></td>
                <td class="text-center align-middle"><?php echo $education['Year_Graduated']; ?></td>
                <td class="text-center align-middle"><?php echo $education['Honor_Recieved']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-education.php?id=<?php echo $education['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-education.php?id=<?php echo $education['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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
    </div>
  </div>
</div><!-- .tab-pane -->