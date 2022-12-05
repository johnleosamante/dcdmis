<?php
# register/register-form.php
?>

<form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputLastName" type="text" name="LName" placeholder="Last name" value="<?php echo $empLName; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputFirstName" name="FName" type="text" placeholder="First name" value="<?php echo $empFName; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputMiddleName" type="text" name="MName" placeholder="Middle name" value="<?php echo $empMName; ?>">
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-3">
      <div class="form-group">
        <input class="form-control" id="inputExtension" type="text" name="Extension" placeholder="Extension" value="<?php echo $empExt; ?>">
      </div><!-- .form-group -->
    </div><!-- .col-md-3 -->

    <div class="col-md-3">
      <div class="form-group">
        <select name="sex" class="form-control" id="inputSex" required>
          <option value="" <?php echo SetOptionSelected('', $empSex); ?>>Sex</option>
          <option value="Male" <?php echo SetOptionSelected('Male', $empSex); ?>>Male</option>
          <option value="Female" <?php echo SetOptionSelected('Female', $empSex); ?>>Female</option>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-3 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <select name="month" class="form-control" id="inputBMonth" required>
          <option value="" <?php echo SetOptionSelected('', $empBMonth); ?>>Birth Month</option>
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
        <input class="form-control" id="inputBDay" name="day" type="text" placeholder="Birth day" value="<?php echo $empBDay; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-4 -->

    <div class="col-md-4">
      <div class="form-group">
        <select name="year" class="form-control" id="inputBYear" required>
          <option value="" <?php echo SetOptionSelected('', $empBYear); ?>>Birth Year</option>
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
        <select name="position" class="form-control" id="inputPosition" required>
          <option value="">Position</option>
          <?php
          $data = DBQuery("SELECT * FROM tbl_job ORDER BY Job_description;");
          while ($row = DBFetchArray($data)) { ?>
            <option value="<?php echo $row['Job_code']; ?>" <?php echo SetOptionSelected($row['Job_code'], $empPosition); ?>><?php echo $row['Job_description']; ?></option>
          <?php } ?>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <select class="form-control" id="inputSchool" name="School" required>
          <option value="">Station</option>
          <?php
          $school = DBQuery("SELECT * FROM tbl_school ORDER BY SchoolName ASC;");
          while ($rowschool = DBFetchArray($school)) { ?>
            <option value="<?php echo $rowschool['SchoolID']; ?>" <?php echo SetOptionSelected($rowschool['SchoolID'], $empSchool); ?>><?php echo $rowschool['SchoolName']; ?></option>
          <?php } ?>
        </select>
      </div><!-- .form-group -->
    </div><!-- .col-md-12 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputContact" type="number" name="contactNo" placeholder="Contact Number" value="<?php echo $empContact; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->

    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="Deped email address" value="<?php echo $empEmail; ?>" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" required>
      </div><!-- .form-group -->
    </div><!-- .col-md-6-->

    <div class="col-md-6">
      <div class="form-group">
        <input class="form-control" id="inputPasswordConfirm" type="password" name="repass" placeholder="Retype password" required>
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