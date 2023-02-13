<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'reference'); ?>" id="reference">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">References</h3>
    <a onclick="viewdata('Modal', 'pds/update/update-reference.php?id=')" data-toggle="modal" data-target="#Modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="30%">Name</th>
            <th class="align-middle" width="45%">Address</th>
            <th class="align-middle" width="15%">Contact Number</th>
            <th class="align-middle" width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $references = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY 'Name';");

          if (mysqli_num_rows($references)) {
            while ($reference = mysqli_fetch_array($references)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $reference['Name']; ?></td>
                <td class="text-center align-middle"><?php echo $reference['Address']; ?></td>
                <td class="text-center align-middle"><?php echo $reference['Tel_No']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" onclick="viewdata('Modal', 'pds/update/update-reference.php?id=<?php echo $reference['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="viewdata('Modal', 'pds/delete/delete-reference.php?id=<?php echo $reference['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="4">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->