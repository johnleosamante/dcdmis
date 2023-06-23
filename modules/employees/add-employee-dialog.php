<?php
// modules/employee/add-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader('Add Employee'); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label for="lname" class="mb-0">Last Name <?php showAsterisk(); ?></label>
          <input id="lname" name="lname" class="form-control" type="text" required>
        </div>

        <div class="form-group">
          <label for="fname" class="mb-0">First Name <?php showAsterisk(); ?></label>
          <input id="fname" name="fname" class="form-control" type="text" required>
        </div>

        <div class="row">
          <div class="col-9">
            <div class="form-group">
              <label for="mname" class="mb-0">Middle Name</label>
              <input id="mname" name="mname" class="form-control" type="text">
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="ext" class="mb-0">Extension</label>
              <input id="ext" name="ext" class="form-control" type="text">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="sex" class="mb-0">Sex <?php showAsterisk(); ?></label>
          <select name="sex" class="form-control" id="sex" required>
            <option value="">Select sex...</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="row">
          <div class="col-4">
            <div class="form-group">
              <label for="bmonth" class="mb-0">Birth Month <?php showAsterisk(); ?></label>
              <select name="bmonth" class="form-control" id="bmonth" required>
                <?php $cmonth = date('m'); ?>
                <option value="01" <?php echo SetOptionSelected('01', $cmonth); ?>>January</option>
                <option value="02" <?php echo SetOptionSelected('02', $cmonth); ?>>February</option>
                <option value="03" <?php echo SetOptionSelected('03', $cmonth); ?>>March</option>
                <option value="04" <?php echo SetOptionSelected('04', $cmonth); ?>>April</option>
                <option value="05" <?php echo SetOptionSelected('05', $cmonth); ?>>May</option>
                <option value="06" <?php echo SetOptionSelected('06', $cmonth); ?>>June</option>
                <option value="07" <?php echo SetOptionSelected('07', $cmonth); ?>>July</option>
                <option value="08" <?php echo SetOptionSelected('08', $cmonth); ?>>August</option>
                <option value="09" <?php echo SetOptionSelected('09', $cmonth); ?>>September</option>
                <option value="10" <?php echo SetOptionSelected('10', $cmonth); ?>>October</option>
                <option value="11" <?php echo SetOptionSelected('11', $cmonth); ?>>November</option>
                <option value="12" <?php echo SetOptionSelected('12', $cmonth); ?>>December</option>
              </select>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="bday" class="mb-0">Birth Day <?php showAsterisk(); ?></label>
              <input class="form-control" id="bday" name="bday" type="number" min="1" max="31" step="1" value="<?php echo date('d'); ?>" required>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <?php $max = date('Y'); ?>
              <label for="byear" class="mb-0">Birth Year <?php showAsterisk(); ?></label>
              <input class="form-control" id="byear" name="byear" type="number" max="<?php echo $max; ?>" min="0" value="<?php echo $max; ?>" step="1" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="position" class="mb-0">Position <?php showAsterisk(); ?></label>
          <select id="position" name="position" class="form-control" required>
            <option value="">Select position...</option>
            <?php $jobPositions = positions();
            while ($jobPosition = fetchArray($jobPositions)) : ?>
              <option value="<?php echo $jobPosition['id']; ?>"><?php echo $jobPosition['position']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="station" class="mb-0">Station <?php showAsterisk(); ?></label>
          <select id="station" name="station" class="form-control" required>
            <option value="">Select station...</option>
            <?php $assignments = schoolsExcept($stationId);
            while ($assignment = fetchArray($assignments)) : ?>
              <option value="<?php echo $assignment['id']; ?>"><?php echo $assignment['name']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="email" class="mb-0">DepEd Email Address <?php showAsterisk(); ?></label>
          <input id="email" name="email" class="form-control" type="email" required>
        </div>

        <div class="form-group">
          <label for="mobile" class="mb-0">Mobile Number <?php showAsterisk(); ?></label>
          <input id="mobile" name="mobile" class="form-control" type="text" required>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" name="add-employee" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>