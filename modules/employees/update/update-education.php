<?php
include_once('../../../includes/function.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/education.php');
include_once(root() . '/includes/layout/components.php');
include_once(root() . '/includes/string.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$employee_id = $_SESSION[alias() . '_current_employee_id'];
$education_id = $education = $level = $school = $course = $from = $to = $highest_level = $year_graduated = $honor_received = '';
$modalTitle = "Add Educational Background";

if (isset($_GET['id']) && strlen($_GET['id']) > 0) {
  $modalTitle = "Edit Educational Background";
  $_SESSION[alias() . '_current_education_id'] = $id;
  $educational_background = educational_background($employee_id, $id);

  if (num_rows($educational_background) > 0) {
    $education = fetch_array($educational_background);
    $education_id = $education['no'];
    $level = $education['level'];
    $school = $education['school'];
    $course = $education['course'];
    $from = $education['from'];
    $to = $education['to'];
    $highest_level = $education['highest'];
    $year_graduated = $education['year_graduated'];
    $honor_received = $education['scholarship'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modal_header($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="level" class="mb-0">Level: <?php show_asterisk(); ?></label>
          <select id="level" name="level" class="form-control" required>
            <option value="Elementary" <?php echo set_option_selected("Elementary", $level); ?>>Elementary</option>
            <option value="High School" <?php echo set_option_selected("High School", $level); ?>>High School</option>
            <option value="College" <?php echo set_option_selected("College", $level); ?>>College</option>
            <option value="Vocational" <?php echo set_option_selected("Vocational", $level); ?>>Vocational</option>
            <option value="Masteral" <?php echo set_option_selected("Masteral", $level); ?>>Masteral</option>
            <option value="Doctoral" <?php echo set_option_selected("Doctoral", $level); ?>>Doctoral</option>
          </select>
        </div>

        <div class="form-group">
          <label for="school" class="mb-0">Name of School (Write in full): <?php show_asterisk(); ?></label>
          <input id="school" name="school" type="text" class="form-control" required value="<?php echo $school; ?>">
        </div>

        <div class="form-group">
          <label for="course" class="mb-0">Basic Education / Degree / Course (Write in full):</label>
          <input id="course" name="course" type="text" class="form-control" value="<?php echo $course; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Attendance from: <?php show_asterisk(); ?></label>
              <input id="from" name="from" type="number" step="1" min="0" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="to" class="mb-0">Attendance to: <?php show_asterisk(); ?></label>
              <input id="to" name="to" type="number" step="1" min="0" class="form-control" required value="<?php echo $to; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="highest" class="mb-0">Highest Level / Units Earned (if not graduated):</label>
          <input id="highest" name="highest" type="text" class="form-control" value="<?php echo $highest_level; ?>">
        </div>

        <div class="form-group">
          <label for="year" class="mb-0">Year Graduated:</label>
          <input id="year" name="year" type="number" step="1" min="0" class="form-control" value="<?php echo $year_graduated; ?>">
        </div>

        <div class="form-group">
          <label for="scholarship" class="mb-0">Scholarship / Academic Honors Received:</label>
          <input id="scholarship" name="scholarship" type="text" class="form-control" value="<?php echo $honor_received; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveEducation">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->