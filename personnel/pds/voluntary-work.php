<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'voluntary-work'); ?>" id="voluntary-work">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization</h3>
    <a href="#AddVoluntaryWorkModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-2" cellspacing="0">
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
          $voluntaryWork = mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($voluntaryWork) > 0) {
            while ($row5 = mysqli_fetch_array($voluntaryWork)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row5['Name_of_Organization']; ?></td>
                <td class="text-center align-middle"><?php echo $row5['From']; ?></td>
                <td class="text-center align-middle"><?php echo $row5['To']; ?></td>
                <td class="text-center align-middle"><?php echo $row5['Number_of_Hour']; ?></td>
                <td class="text-center align-middle"><?php echo $row5['Position']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="my_volunter.php?id=<?php echo urlencode(base64_encode($row5['No'])); ?>" data-toggle="modal" data-target="#UpdateVoluntaryWorkModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_volunter(this.id)" id="<?php echo $row5['No'] ?>" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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

      <script>
        function delete_volunter(id) {
          if (confirm("Are you sure you want to deleted this row?")) {
            window.location.href = 'delete-voluntary-work.php?id=' + id;
          }
        }
      </script>
    </div><!-- .col -->
  </div><!-- .row -->

  <div class="modal fade" id="AddVoluntaryWorkModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Voluntary Work</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="Organization" class="mb-0">Name & Address of Organization (Write in full)</label>
              <input id="Organization" type="text" name="Organization" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="From" class="mb-0">Inclusive Dates From:</label>
                  <input id="From" type="date" name="From" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="To" class="mb-0">Inclusive Dates To:</label>
                  <input id="To" type="date" name="To" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="Hours" class="mb-0">Number of Hours:</label>
              <input id="Hours" type="number" name="Hours" class="form-control" required>
            </div>

            <div class="form-group mb-0">
              <label for="Position" class="mb-0">Position:</label>
              <input id="Position" type="text" name="Position" class="form-control" required>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddVoluntaryWork">Save</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->

  <div class="modal fade" id="UpdateVoluntaryWorkModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->