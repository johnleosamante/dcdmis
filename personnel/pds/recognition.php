<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'recognition'); ?>" id="recognition">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Non-Academic Distinctions / Recognition</h3>
    <a class="btn btn-primary btn-icon-split btn-sm" onclick="viewdata('Modal', 'pds/update/update-recognition.php?id=')" data-toggle="modal" data-target="#Modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
            <th class="align-middle" width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $recognitions = mysqli_query($con, "SELECT * FROM tbl_recognition WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY `Recognition` ASC;");

          if (mysqli_num_rows($recognitions) > 0) {
            while ($recognition = mysqli_fetch_array($recognitions)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $recognition['Recognition']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-recognition.php?id=<?php echo $recognition['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-recognition.php?id=<?php echo $recognition['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="2">No data available in table</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->