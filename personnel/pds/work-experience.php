<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'work-experience'); ?>" id="work-experience">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Work Experience</h3>
    <a href="#AddExperienceModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
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
                  <a class="btn btn-success my-1" id="<?php echo $experience['No']; ?>" onclick="viewdata('UpdateModal', 'pds/update/update-work-experience.php?id=' + this.id)" data-toggle="modal" data-target="#UpdateModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_work(this.id)" id="<?php echo $experience['No']; ?>" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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

      <script>
        function delete_work(id) {
          if (confirm("Are you sure you want to deleted this row?")) {
            window.location.href = 'pds/delete/delete-work-experience.php?id=' + id;
          }
        }
      </script>
    </div><!-- .col -->
  </div><!-- .row -->

  <div class="modal fade" id="AddExperienceModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Work Experience</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="from" class="mb-0">Inclusive Dates From:</label>
                  <input id="from" type="date" name="from" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="to" class="mb-0">Inclusive Dates To:</label>
                  <input id="to" type="date" name="to" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="position" class="mb-0">Position Title:</label>
              <input id="position" type="text" name="position" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="organization" class="mb-0">Department / Agency / Office / Company:</label>
              <input id="organization" type="text" name="organization" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="monthly" class="mb-0">Monthly<br>Salary:</label>
                  <input id="monthly" type="text" name="monthly" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="step" class="mb-0">Salary/Job/Pay Grade &amp; Step Increment:</label>
                  <input id="step" type="text" name="step" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label for="status" class="mb-0">Status of Appointment:</label>
                  <select name="status" id="status" class="form-control" required>
                    <option value="Permanent">Permanent</option>
                    <option value="Temporary">Temporary</option>
                    <option value="Coterminus">Coterminus</option>
                    <option value="Fixed Term">Fixed Term</option>
                    <option value="Contractual">Contractual</option>
                    <option value="Substitute">Substitute</option>
                    <option value="Provisional">Provisional</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label for="government" class="mb-0">Government Service:</label>
                  <select name="government" id="government" class="form-control" required>
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                  </select>
                </div>
              </div>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddExperience">Save</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->