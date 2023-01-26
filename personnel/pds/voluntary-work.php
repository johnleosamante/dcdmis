<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'voluntary-work'); ?>" id="voluntary-work">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization</h3>
    <a class="btn btn-primary btn-icon-split btn-sm" onclick="viewdata('Modal', 'pds/update/update-voluntary-work.php?id=')" data-toggle="modal" data-target="#Modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="40%" rowspan="2">Name & Address of Organization</th>
            <th class="align-middle" width="10%" colspan="2">Inclusive Dates</th>
            <th class="align-middle" width="10%" rowspan="2">Number of Hours</th>
            <th class="align-middle" width="30%" rowspan="2">Position / Nature of Work</th>
            <th class="align-middle" width="10%" rowspan="2">Action</th>
          </tr>
          <tr class="text-center">
            <th width="5%" class="align-middle">From</th>
            <th width="5%" class="align-middle">To</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $voluntaryWorks = mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY `From` DESC;");

          if (mysqli_num_rows($voluntaryWorks) > 0) {
            while ($voluntaryWork = mysqli_fetch_array($voluntaryWorks)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $voluntaryWork['Name_of_Organization']; ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($voluntaryWork['From']); ?></td>
                <td class="text-center align-middle"><?php echo ToDateString($voluntaryWork['To']); ?></td>
                <td class="text-center align-middle"><?php echo $voluntaryWork['Number_of_Hour']; ?></td>
                <td class="text-center align-middle"><?php echo $voluntaryWork['Position']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('UpdateModal', 'pds/update/update-voluntary-work.php?id=<?php echo $voluntaryWork['No']; ?>')" data-toggle="modal" data-target="#UpdateModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="delete_volunter(<?php echo $voluntaryWork['No']; ?>)" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="6">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->