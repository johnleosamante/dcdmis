<?php
// modules/employees/update/update-education.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/education.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$educationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$education = $level = $school = $course =  $highestLevel = $yearGraduated = $honorReceived = '';
$from = $to = date('Y');
$isPresent = false;
$modalTitle = 'Add Educational Background';

if (isset($educationId)) {
  $modalTitle = 'Edit Educational Background';
  $educationalBackground = educationalBackground($employeeId, $educationId);

  if (numRows($educationalBackground) > 0) {
    $education = fetchArray($educationalBackground);
    $educationId = $education['no'];
    $level = $education['level'];
    $school = $education['school'];
    $course = $education['course'];
    $from = $education['from'];
    $isPresent = $education['ispresent'];
    $to = $isPresent ? date('Y') : $education['to'];
    $highestLevel = $education['highest'];
    $yearGraduated = $education['year_graduated'];
    $honorReceived = $education['scholarship'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="level" class="mb-0">Level: <?php showAsterisk(); ?></label>
          <select id="level" name="level" class="form-control" required>
            <option value="Elementary" <?php echo setOptionSelected("Elementary", $level); ?>>Elementary</option>
            <option value="Secondary" <?php echo setOptionSelected("Secondary", $level); ?>>Secondary</option>
            <option value="Vocational" <?php echo setOptionSelected("Vocational", $level); ?>>Vocational</option>
            <option value="College" <?php echo setOptionSelected("College", $level); ?>>College</option>
            <option value="Graduate Studies" <?php echo setOptionSelected("Graduate Studies", $level); ?>>Graduate Studies</option>
          </select>
        </div>

        <div class="form-group">
          <label for="school" class="mb-0">Name of School (Write in full): <?php showAsterisk(); ?></label>
          <input id="school" name="school" type="text" class="form-control" required value="<?php echo $school; ?>">
        </div>

        <div class="form-group">
          <label for="course" class="mb-0">Basic Education / Degree / Course (Write in full):</label>
          <input id="course" name="course" type="text" class="form-control" value="<?php echo $course; ?>">
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="from" class="mb-0">Attendance from: <?php showAsterisk(); ?></label>
              <input id="from" name="from" type="number" step="1" min="0" class="form-control" required value="<?php echo $from; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-7">
                  <label for="to" class="mb-0">Attendance to: <?php showAsterisk(); ?></label>
                </div>
                <div class="col-5">
                  <div class="form-check">
                    <input class="form-check-input" id="is-present" type="checkbox" name="is-present" <?php echo setItemChecked($isPresent); ?>>
                    <label class="form-check-label" for="is-present">Present</label>
                  </div><!-- .form-check-->
                </div>
              </div>
              <input id="to" name="to" type="number" step="1" min="0" class="form-control" value="<?php echo $to; ?>" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="highest" class="mb-0">Highest Level / Units Earned (if not graduated):</label>
          <input id="highest" name="highest" type="text" class="form-control" value="<?php echo $highestLevel; ?>">
        </div>

        <div class="form-group">
          <label for="year" class="mb-0">Year Graduated:</label>
          <input id="year" name="year" type="number" step="1" min="0" class="form-control" value="<?php echo $yearGraduated; ?>">
        </div>

        <div class="form-group">
          <label for="scholarship" class="mb-0">Scholarship / Academic Honors Received:</label>
          <input id="scholarship" name="scholarship" type="text" class="form-control" value="<?php echo $honorReceived; ?>">
        </div>

        <?php requiredLegend(0); ?>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
        <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button type="submit" class="btn btn-primary" name="save-education">Save</button>
        <?php cancelModalButton(); ?>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->