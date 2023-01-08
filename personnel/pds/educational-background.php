<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'educational-background'); ?>" id="educational-background">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Educational Background</h3>
    <a href="#AddEducationModal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
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
          $educationalBackground = mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($educationalBackground) > 0) {
            while ($row2 = mysqli_fetch_array($educationalBackground)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row2['Level']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['Name_of_School']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['Course']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['From']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['To']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['Highest_Level']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['Year_Graduated']; ?></td>
                <td class="text-center align-middle"><?php echo $row2['Honor_Recieved']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="my_educate.php?id='<?php echo urlencode(base64_encode($row2['No'])); ?>" data-toggle="modal" data-target="#UpdateEducationModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" id="<?php echo $row2['No']; ?>" onclick="delete_educ(this.id)" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
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
        function delete_educ(id) {
          if (confirm("Are you sure you want to deleted this row?")) {
            window.location.href = 'pds/delete/delete-education.php?id=' + id;
          }
        }
      </script>
    </div>
  </div>

  <div class="modal fade" id="AddEducationModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Education</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="level" class="mb-0">Level:</label>
              <select name="level" id="level" class="form-control" required>
                <option value="">Level</option>
                <option value="Doctoral">Doctoral</option>
                <option value="Masteral">Masteral</option>
                <option value="Vocational">Vocational</option>
                <option value="College">College</option>
                <option value="High School">High School</option>
                <option value="Elementary">Elementary</option>
              </select>
            </div>

            <div class="form-group">
              <label for="school" class="mb-0">Name of School (Write in full):</label>
              <input id="school" type="text" name="school" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="education" class="mb-0">Basic Education / Degree / Course (Write in full):</label>
              <input id="education" type="text" name="education" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="from" class="mb-0">Attendance from:</label>
                  <input id="from" type="text" name="from" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="to" class="mb-0">Attendance to:</label>
                  <input id="to" type="text" name="to" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="unit" class="mb-0">Highest Level / Units Earned (if not graduated)</label>
              <select id="unit" name="unit" class="form-control" required>
                <Option value="0">0</option>
                <Option value="3">3</option>
                <Option value="6">6</option>
                <Option value="9">9</option>
                <Option value="12">12</option>
                <Option value="15">15</option>
                <Option value="18">18</option>
                <Option value="21">21</option>
                <Option value="24">24</option>
                <Option value="27">27</option>
                <Option value="30">30</option>
                <Option value="GRADUATED">GRADUATED</option>
              </select>
            </div>

            <div class="form-group">
              <label for="year" class="mb-0">Year Graduated:</label>
              <input type="text" name="year" class="form-control" required>
            </div>

            <div class="form-group mb-0">
              <label for="honor" class="mb-0">Scholarship / Academic Honors Received:</label>
              <input type="text" name="honor" class="form-control" required>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="AddEducation">Save</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->

  <div class="modal fade" id="UpdateEducationModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->