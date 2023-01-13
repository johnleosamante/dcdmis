<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Update Education</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <?php
      include_once('../../../_includes_/function.php');
      include_once('../../../_includes_/database/database.php');

      foreach ($_GET as $key => $data) {
        $id = $_GET[$key] = $data;
      }

      $_SESSION['No'] = $id;

      $educational_background = mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

      if (mysqli_num_rows($educational_background) > 0) {
        $education = mysqli_fetch_array($educational_background);
        $level = $education['Level'];
        $school = $education['Name_of_School'];
        $course = $education['Course'];
        $from = $education['From'];
        $to = $education['To'];
        $highest_level = $education['Highest_Level'];
        $year_graduated = $education['Year_Graduated'];
        $honor_received = $education['Honor_Recieved'];
      } else {
        $education = $level = $school = $course = $from = $to = $highest_level = $year_graduated = $honor_received = '';
      }
      ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="level" class="mb-0">Level:</label>
          <select name="ELevel" id="level" class="form-control" required>
            <option value="Elementary" <?php echo SetOptionSelected("Elementary", $level); ?>>Elementary</option>
            <option value="High School" <?php echo SetOptionSelected("High School", $level); ?>>High School</option>
            <option value="College" <?php echo SetOptionSelected("College", $level); ?>>College</option>
            <option value="Vocational" <?php echo SetOptionSelected("Vocational", $level); ?>>Vocational</option>
            <option value="Masteral" <?php echo SetOptionSelected("Masteral", $level); ?>>Masteral</option>
            <option value="Doctoral" <?php echo SetOptionSelected("Doctoral", $level); ?>>Doctoral</option>
          </select>
        </div>

        <div class="form-group">
          <label for="school" class="mb-0">Name of School (Write in full):</label>
          <input id="school" type="text" name="ESchool" class="form-control" required value="<?php echo $school; ?>">
        </div>

        <div class="form-group">
          <label for="education" class="mb-0">Basic Education / Degree / Course (Write in full):</label>
          <input id="education" type="text" name="ECourse" class="form-control" required value="<?php echo $course; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Attendance from:</label>
              <input id="from" type="text" name="EFrom" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="to" class="mb-0">Attendance to:</label>
              <input id="to" type="text" name="ETo" class="form-control" required value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="unit" class="mb-0">Highest Level / Units Earned (if not graduated)</label>
          <select id="unit" name="EHighest" class="form-control" required>
            <Option value="0" <?php echo SetOptionSelected("0", $highest_level); ?>>0</option>
            <Option value="3" <?php echo SetOptionSelected("3", $highest_level); ?>>3</option>
            <Option value="6" <?php echo SetOptionSelected("6", $highest_level); ?>>6</option>
            <Option value="9" <?php echo SetOptionSelected("9", $highest_level); ?>>9</option>
            <Option value="12" <?php echo SetOptionSelected("12", $highest_level); ?>>12</option>
            <Option value="15" <?php echo SetOptionSelected("15", $highest_level); ?>>15</option>
            <Option value="18" <?php echo SetOptionSelected("18", $highest_level); ?>>18</option>
            <Option value="21" <?php echo SetOptionSelected("21", $highest_level); ?>>21</option>
            <Option value="24" <?php echo SetOptionSelected("24", $highest_level); ?>>24</option>
            <Option value="27" <?php echo SetOptionSelected("27", $highest_level); ?>>27</option>
            <Option value="30" <?php echo SetOptionSelected("30", $highest_level); ?>>30</option>
            <Option value="GRADUATED" <?php echo SetOptionSelected("GRADUATED", $highest_level); ?>>GRADUATED</option>
          </select>
        </div>

        <div class="form-group">
          <label for="year" class="mb-0">Year Graduated:</label>
          <input type="text" name="EGraduated" class="form-control" required value="<?php echo $year_graduated; ?>">
        </div>

        <div class="form-group mb-0">
          <label for="honor" class="mb-0">Scholarship / Academic Honors Received:</label>
          <input type="text" name="EHonor" class="form-control" required value="<?php echo $honor_received; ?>">
        </div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="UpdateEducation">Save</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->