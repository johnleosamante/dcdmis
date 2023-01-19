<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'reference'); ?>" id="reference">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">References</h3>
    <a href="#AddReferenceModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
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
          $references = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($references)) {
            while ($reference = mysqli_fetch_array($references)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $reference['Name']; ?></td>
                <td class="text-center align-middle"><?php echo $reference['Address']; ?></td>
                <td class="text-center align-middle"><?php echo $reference['Tel_No']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" onclick="viewdata('UpdateModal', 'pds/update/update-reference.php?id=<?php echo $reference['No']; ?>')" data-toggle="modal" data-target="#UpdateModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_reference(<?php echo $reference['No']; ?>)" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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

      <script>
        function delete_reference(id) {
          if (confirm("Are you sure you want to delete this entry?")) {
            window.location.href = 'pds/delete/delete-reference.php?id=' + id;
          }
        }
      </script>
    </div><!-- .col -->
  </div><!-- .row -->

  <div class="modal fade" id="AddReferenceModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">References</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="Ref_Name" class="mb-0">Name:</label>
              <input type="text" id="Ref_Name" name="Ref_Name" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="Address" class="mb-0">Address:</label>
              <input type="text" id="Address" name="Address" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="Cell" class="mb-0">Contact Number:</label>
              <input type="text" id="Cell" name="Cell" class="form-control" required>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddReference">Save</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->