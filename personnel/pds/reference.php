<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'reference'); ?>" id="references">
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
          $reference = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($reference)) {
            while ($row8 = mysqli_fetch_array($reference)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row8['Name']; ?></td>
                <td class="text-center align-middle"><?php echo $row8['Address']; ?></td>
                <td class="text-center align-middle"><?php echo $row8['Tel_No']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="my_references.php?id=<?php echo urlencode(base64_encode($row8['No'])); ?>" data-toggle="modal" data-target="#UpdateReferenceModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_reference(this.id)" id="<?php echo $row8['No']; ?>" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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
          if (confirm("Are you sure you want to deleted this row?")) {
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
              
            </div>

            <div class="form-group">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th style="text-align:center;">Name</th>
                  <th style="text-align:center;">Address</th>
                  <th style="text-align:center;">Contact Number</th>
                </tr>

                <tr>
                  <th><input type="text" name="Ref_Name" class="form-control" required></th>
                  <th><input type="text" name="Address" class="form-control" required></th>
                  <th><input type="text" name="Cell" class="form-control" required></th>
                </tr>
              </table>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddReference">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>