<?php
# register/register-form.php
?>

<form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="LName" class="mb-0">Last Name:</label>
        <input class="form-control" id="LName" type="text" name="LName" value="<?php echo $empLName; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-6">
      <div class="form-group">
        <label for="inputFirstName" class="mb-0">First Name:</label>
        <input class="form-control" id="inputFirstName" name="FName" type="text" value="<?php echo $empFName; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="inputMiddleName" class="mb-0">Middle Name:</label>
        <input class="form-control" id="inputMiddleName" type="text" name="MName" value="<?php echo $empMName; ?>">
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-3">
      <div class="form-group">
        <label for="inputExtension" class="mb-0">Extension:</label>
        <input class="form-control" id="inputExtension" type="text" name="Extension" value="<?php echo $empExt; ?>">
      </div><!-- .form-group -->
    </div><!-- .col-md-3 -->

    <div class="col-md-3">
      <div class="form-group">
        <label for="inputSex" class="mb-0">Sex:</label>
        <select name="sex" class="form-control" id="inputSex" required>
          <option value="Male" <?php echo SetOptionSelected('Male', $empSex); ?>>Male</option>
          <option value="Female" <?php echo SetOptionSelected('Female', $empSex); ?>>Female</option>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-3 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="inputBMonth" class="mb-0">Birth Month:</label>
        <select name="month" class="form-control" id="inputBMonth" required>
          <option value="01" <?php echo SetOptionSelected('01', $empBMonth); ?>>January</option>
          <option value="02" <?php echo SetOptionSelected('02', $empBMonth); ?>>February</option>
          <option value="03" <?php echo SetOptionSelected('03', $empBMonth); ?>>March</option>
          <option value="04" <?php echo SetOptionSelected('04', $empBMonth); ?>>April</option>
          <option value="05" <?php echo SetOptionSelected('05', $empBMonth); ?>>May</option>
          <option value="06" <?php echo SetOptionSelected('06', $empBMonth); ?>>June</option>
          <option value="07" <?php echo SetOptionSelected('07', $empBMonth); ?>>July</option>
          <option value="08" <?php echo SetOptionSelected('08', $empBMonth); ?>>August</option>
          <option value="09" <?php echo SetOptionSelected('09', $empBMonth); ?>>September</option>
          <option value="10" <?php echo SetOptionSelected('10', $empBMonth); ?>>October</option>
          <option value="11" <?php echo SetOptionSelected('11', $empBMonth); ?>>November</option>
          <option value="12" <?php echo SetOptionSelected('12', $empBMonth); ?>>December</option>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-4 -->

    <div class="col-md-4">
      <div class="form-group">
        <label for="inputBDay" class="mb-0">Birth Day:</label>
        <input class="form-control" id="inputBDay" name="day" type="text" value="<?php echo $empBDay; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-4 -->

    <div class="col-md-4">
      <div class="form-group">
        <label for="inputBYear" class="mb-0">Birth Year:</label>
        <select name="year" class="form-control" id="inputBYear" required>
          <?php
          $age = 0;
          $year = date('Y');
          while ($age <= 75) {
            $age++;
          ?>
            <option value="<?php echo $year; ?>" <?php echo SetOptionSelected($year, $empBYear); ?>><?php echo $year; ?></option>
          <?php
            $year--;
          }
          ?>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-4 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="inputPosition" class="mb-0">Position:</label>
        <select name="position" class="form-control" id="inputPosition" required>
          <?php
          include_once('../_includes_/database/job.php');
          $jobs = GetJob();
          while ($job = DBFetchArray($jobs)) { ?>
            <option value="<?php echo $job['id']; ?>" <?php echo SetOptionSelected($job['id'], $empPosition); ?>><?php echo $job['name']; ?></option>
          <?php } ?>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="inputSchool" class="mb-0">Station:</label>
        <select class="form-control" id="inputSchool" name="School" required>
          <?php
          include_once('../_includes_/database/school.php');
          $schools = GetSchool();
          while ($school = DBFetchArray($schools)) { ?>
            <option value="<?php echo $school['id']; ?>" <?php echo SetOptionSelected($school['id'], $empSchool); ?>><?php echo $school['name']; ?></option>
          <?php } ?>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="inputContact" class="mb-0">Contact Number:</label>
        <input class="form-control" id="inputContact" type="number" name="contactNo" value="<?php echo $empContact; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-6">
      <div class="form-group">
        <label for="inputEmail" class="mb-0">DepEd Email Address:</label>
        <input class="form-control" id="inputEmail" name="inputEmail" type="email" value="<?php echo $empEmail; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="inputPassword" class="mb-0">Password:</label>
        <input class="form-control" id="inputPassword" type="password" name="password" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6-->

    <div class="col-md-6">
      <div class="form-group">
        <label for="inputPasswordConfirm" class="mb-0">Retype Password:</label>
        <input class="form-control" id="inputPasswordConfirm" type="password" name="repass" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-12">
      <div class="form-group form-check small">
        <input class="form-check-input" id="inputShowPassword" type="checkbox">
        <label class="form-check-label" for="inputShowPassword">Show password</label>
      </div><!-- .form-group -->
    </div><!-- .col-md-12 -->

    <?php ShowPassword('inputShowPassword', 'inputPassword', 'inputPasswordConfirm'); ?>
  </div><!-- .row -->

  <input type="submit" class="btn btn-primary btn-lg w-100" name="create_account" value="Register">
</form>