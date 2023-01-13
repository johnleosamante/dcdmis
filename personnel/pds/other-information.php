<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'other-information'); ?>" id="other-information">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Other Information</h3>
    <a href="#AddOtherInformationModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th class="align-middle" width="30%">Special Skills &amp; Hobbies</th>
            <th class="align-middle" width="30%">Non-Academic Distinctions / Recognition</th>
            <th class="align-middle" width="30%">Membership in Association / Organization</th>
            <th class="align-middle" width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $information = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($information) > 0) {
            while ($row7 = mysqli_fetch_array($information)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row7['Special_Skills']; ?></td>
                <td class="text-center align-middle"><?php echo $row7['Recognation']; ?></td>
                <td class="text-center align-middle"><?php echo $row7['Organization']; ?></td>

                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="update_skills.php?id=<?php echo urlencode(base64_encode($row7['No'])); ?>" data-toggle="modal" data-target="#UpdateOtherInformationModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_other(this.id)" id="<?php echo $row7['No']; ?>" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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
        function delete_other(id) {
          if (confirm("Are you sure you want to deleted this row?")) {
            window.location.href = 'pds/delete/delete-other-information.php?id=' + id;
          }
        }
      </script>
    </div><!-- .col -->
  </div><!-- .row -->

  <div class="modal fade" id="AddOtherInformationModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Other Information</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div><!-- .modal-header -->

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="skills" class="mb-0">Special Skills &amp; Hobbies:</label>
              <input id="skills" type="text" name="skills" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="awards" class="mb-0">Non-Academic Distinctions / Recognition (Write in full):</label>
              <input id="awards" type="text" name="awards" class="form-control" required>
            </div>

            <div class="form-group mb-0">
              <label for="member" class="mb-0">Membership in Association / Organization (Write in full):</label>
              <input id="member" type="text" name="member" class="form-control" required>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddOtherInformation">Save</button>
          </div>
        </form>
      </div><!-- .modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->