<?php
// modules/employees/view/personal-information.php
?>

<div class="tab-pane fade<?php echo setActiveNavigation(!isset($activeTab) || $activeTab === 'personal-information', 'show active'); ?>" id="personal-information">
  <?php if ($editMode) : ?>
    <form action="" method="POST" role="form" enctype="multipart/form-data">
    <?php endif; ?>
    <div class="row mt-3">
      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-4">
        <img src="<?php echo uri() . '/' . $employee['picture']; ?>" width="100%" class="border rounded" id="employee-photo">

        <?php if ($editMode) : ?>
          <div class="mt-3 custom-file">
            <input id="image-upload" type="file" name="image-upload" class="custom-file-input">
            <label id="image-upload-label" class="custom-file-label" for="image-upload">Choose file</label>
          </div>

          <script>
            document.getElementById('image-upload').addEventListener('change', (event) => {
              var preview = document.getElementById('employee-photo');
              const file = event.target.files[0];
              const name = file.name;
              const lastDot = name.lastIndexOf('.');
              const ext = name.substring(lastDot + 1);
              var label = document.getElementById('image-upload-label');
              label.innerText = name;

              switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                  preview.src = URL.createObjectURL(event.target.files[0]);
                  break;
                default:
                  preview.src = '<?php echo uri(); ?>/assets/img/nopreview.png';
                  break;
              }
            });
          </script>
        <?php endif; ?>
      </div>

      <div class="col-sm-12 col-md-8 col-lg-9 col-xl-10">
        <div class=" form-group">
          <label for="lname" class="mb-0">Last Name: <?php showAsterisk($editMode); ?></label>
          <input id="lname" name="lname" type="text" class="form-control" value="<?php echo $employee['lname']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="fname" class="mb-0">First Name: <?php showAsterisk($editMode); ?></label>
              <input id="fname" name="fname" type="text" class="form-control" value="<?php echo $employee['fname']; ?>" autocomplete="false" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ext" class="mb-0">Name Extension:</label>
              <input id="ext" name="ext" type="text" class="form-control" value="<?php echo $employee['ext']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="mname" class="mb-0">Middle Name:</label>
          <input id="mname" name="mname" type="text" class="form-control" value="<?php echo $employee['mname']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="dob" class="mb-0">Date of Birth: <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="dob" type="text" class="form-control" value="<?php echo $employee['month'] . '/' . $employee['day'] . '/' . $employee['year']; ?>" readonly>
              <?php else : ?>
                <input id="dob" name="dob" type="date" class="form-control" value="<?php echo $employee['year'] . '-' . $employee['month'] . '-' . $employee['day']; ?>" required>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-9">
            <div class="form-group">
              <label for="pob" class="mb-0">Place of Birth: <?php showAsterisk($editMode); ?></label>
              <input id="pob" name="pob" type="text" class="form-control" value="<?php echo $employee['pob']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="sex" class="mb-0">Sex: <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="sex" type="text" class="form-control" value="<?php echo $employee['sex']; ?>" readonly>
              <?php else : ?>
                <select id="sex" name="sex" class="form-control" required>
                  <option value="Male" <?php echo setOptionSelected('Male', $employee['sex']); ?>>Male</option>
                  <option value="Female" <?php echo setOptionSelected('Female', $employee['sex']); ?>>Female</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="civil-status" class="mb-0">Civil Status: <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="civil-status" type="text" class="form-control" value="<?php echo $employee['civil_status']; ?>" readonly>
              <?php else : ?>
                <select id="civil-status" name="civil-status" class="form-control" required>
                  <option value="Single" <?php echo setOptionSelected('Single', $employee['civil_status']); ?>>Single</option>
                  <option value="Married" <?php echo setOptionSelected('Married', $employee['civil_status']); ?>>Married</option>
                  <option value="Widowed" <?php echo setOptionSelected('Widowed', $employee['civil_status']); ?>>Widowed</option>
                  <option value="Separated" <?php echo setOptionSelected('Separated', $employee['civil_status']); ?>>Separated</option>
                  <option value="Others" <?php echo setOptionSelected('Others', $employee['civil_status']); ?>>Others</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="civil-status-specify" class="mb-0">Specify, if Others:</label>
              <input id="civil-status-specify" name="civil-status-specify" type="text" class="form-control" value="<?php echo $employee['civil_status_specify']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2">
            <div class="form-group">
              <label for="height" class="mb-0">Height (m): <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="height" type="text" class="form-control" value="<?php echo $employee['height']; ?>" readonly>
              <?php else : ?>
                <input id="height" name="height" type="number" min="0" step="0.01" class="form-control" value="<?php echo $employee['height']; ?>" required>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="weight" class="mb-0">Weight (kg): <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="weight" type="text" class="form-control" value="<?php echo $employee['weight']; ?>" readonly>
              <?php else : ?>
                <input id="weight" name="weight" type="number" min="0" step="0.01" class="form-control" value="<?php echo $employee['weight']; ?>" required>
              <?php endif; ?>
            </div>
          </div>

          <div class=" col-lg-2">
            <div class="form-group">
              <label for="blood-type" class="mb-0">Blood Type: <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="blood-type" type="text" class="form-control" value="<?php echo $employee['blood_type']; ?>" readonly>
              <?php else : ?>
                <select name="blood-type" id="blood-type" class="form-control" required>
                  <option value="A+" <?php echo setOptionSelected('A+', $employee['blood_type']); ?>>A+</option>
                  <option value="A-" <?php echo setOptionSelected('A-', $employee['blood_type']); ?>>A-</option>
                  <option value="B+" <?php echo setOptionSelected('B+', $employee['blood_type']); ?>>B+</option>
                  <option value="B-" <?php echo setOptionSelected('B-', $employee['blood_type']); ?>>B-</option>
                  <option value="AB+" <?php echo setOptionSelected('AB+', $employee['blood_type']); ?>>AB+</option>
                  <option value="AB-" <?php echo setOptionSelected('AB-', $employee['blood_type']); ?>>AB-</option>
                  <option value="O+" <?php echo setOptionSelected('O+', $employee['blood_type']); ?>>O+</option>
                  <option value="O-" <?php echo setOptionSelected('O-', $employee['blood_type']); ?>>O-</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class=" col-lg-3">
            <div class="form-group">
              <label for="gsis" class="mb-0">GSIS No.:</label>
              <input id="gsis" name="gsis" type="text" class="form-control" value="<?php echo $employee['gsis']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class=" col-lg-3">
            <div class="form-group">
              <label for="pagibig" class="mb-0">PAGIBIG ID No.:</label>
              <input id="pagibig" name="pagibig" type="text" class="form-control" value="<?php echo $employee['pagibig']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="philhealth" class="mb-0">PHILHEALTH No.:</label>
              <input id="philhealth" name="philhealth" type="text" class="form-control" value="<?php echo $employee['philhealth']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="sss" class="mb-0">SSS No.:</label>
              <input id="sss" name="sss" type="text" class="form-control" value="<?php echo $employee['sss']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="tin" class="mb-0">TIN No.:</label>
              <input id="tin" name="tin" type="text" class="form-control" value="<?php echo $employee['tin']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="agency-id" class="mb-0">Agency Employee No.:</label>
              <input id="agency-id" name="agency-id" type="text" class="form-control" value="<?php echo $employee['agency_id']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="citizenship" class="mb-0">Citizenship: <?php showAsterisk($editMode); ?></label>
              <?php
              $citizenship = empty($employee['citizenship']) ? 'Filipino' : $employee['citizenship'];
              if (!$editMode) : ?>
              <input id="citizenship" name="citizenship" type="text" class="form-control" value="<?php echo $citizenship; ?>" readonly>
              <?php else: ?>
                <select class="form-control" id="citizenship" name="citizenship" required>
                  <?php $nationalities = nationalities();
                  while ($nationality = fetchAssoc($nationalities)) : ?>
                    <option value="<?php echo $nationality['name']; ?>" <?php echo setOptionSelected($nationality['name'], $citizenship); ?>><?php echo $nationality['name']; ?></option>
                  <?php endwhile; ?>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="dual-citizenship" class="mb-0">Dual Citizenship: <?php showAsterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="dual-citizenship" name="dual-citizenship" type="text" class="form-control" value="<?php echo $employee['dual_citizenship']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
              <?php else : ?>
                <select id="dual-citizenship" name="dual-citizenship" class="form-control" required>
                  <option value="N/A" <?php echo setOptionSelected('N/A', $employee['dual_citizenship']); ?>>N/A</option>
                  <option value="By Birth" <?php echo setOptionSelected('By Birth', $employee['dual_citizenship']); ?>>By Birth</option>
                  <option value="By Naturalization" <?php echo setOptionSelected('By Naturalization', $employee['dual_citizenship']); ?>>By Naturalization</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="dual-citizenship-country" class="mb-0">Please Indicate Country if Dual Citizen:</label>
              <?php if (!$editMode) : ?>
                <input id="dual-citizenship-country" name="dual-citizenship-country" type="text" class="form-control" value="<?php echo $employee['country']; ?>" readonly>
              <?php else: ?>
                <select class="form-control" id="dual-citizenship-country" name="dual-citizenship-country">
                  <option value="N/A">N/A</option>
                  <?php $countries = countries();
                  while ($country = fetchAssoc($countries)) : ?>
                    <option value="<?php echo $country['name']; ?>" <?php echo setOptionSelected($country['name'], $employee['country']); ?>><?php echo $country['name']; ?></option>
                  <?php endwhile; ?>
                </select>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div>Residential Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="rlot" class="mb-0 small">House/Block/Lot No.</label>
              <input id="rlot" name="rlot" type="text" class="form-control" value="<?php echo $employee['rlot']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rstreet" class="mb-0 small">Street</label>
              <input id="rstreet" name="rstreet" type="text" class="form-control" value="<?php echo $employee['rstreet']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rsubdivision" class="mb-0 small">Subdivision/Village</label>
              <input id="rsubdivision" name="rsubdivision" type="text" class="form-control" value="<?php echo $employee['rsubdivision']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rbarangay" class="mb-0 small">Barangay <?php showAsterisk($editMode); ?></label>
              <input id="rbarangay" name="rbarangay" type=" text" class="form-control" value="<?php echo $employee['rbarangay']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="rcity" class="mb-0 small">City/Municipality <?php showAsterisk($editMode); ?></label>
              <input id="rcity" name="rcity" type="text" class="form-control" value="<?php echo $employee['rcity']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="rprovince" class="mb-0 small">Province <?php showAsterisk($editMode); ?></label>
              <input id="rprovince" name="rprovince" type="text" class="form-control" value="<?php echo $employee['rprovince']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rzip" class="mb-0 small">ZIP Code <?php showAsterisk($editMode); ?></label>
              <input id="rzip" name="rzip" type="text" class="form-control" value="<?php echo $employee['rzip']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>
        </div>

        <div>Permanent Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="plot" class="mb-0 small">House/Block/Lot No.</label>
              <input id="plot" name="plot" type="text" class="form-control" value="<?php echo $employee['plot']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pstreet" class="mb-0 small">Street</label>
              <input id="pstreet" name="pstreet" type="text" class="form-control" value="<?php echo $employee['pstreet']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="psubdivision" class="mb-0 small">Subdivision/Village</label>
              <input id="psubdivision" name="psubdivision" type="text" class="form-control" value="<?php echo $employee['psubdivision']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pbarangay" class="mb-0 small">Barangay <?php showAsterisk($editMode); ?></label>
              <input id="pbarangay" name="pbarangay" type="text" class="form-control" value="<?php echo $employee['pbarangay']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="pcity" class="mb-0 small">City/Municipality <?php showAsterisk($editMode); ?></label>
              <input id="pcity" name="pcity" type="text" class="form-control" value="<?php echo $employee['pcity']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="pprovince" class="mb-0 small">Province <?php showAsterisk($editMode); ?></label>
              <input id="pprovince" name="pprovince" type="text" class="form-control" value="<?php echo $employee['pprovince']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pzip" class="mb-0 small">ZIP Code <?php showAsterisk($editMode); ?></label>
              <input id="pzip" name="pzip" type="text" class="form-control" value="<?php echo $employee['pzip']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="telephone" class="mb-0">Telephone Number:</label>
              <input id="telephone" name="telephone" type="text" class="form-control" value="<?php echo $employee['telephone']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="mobile" class="mb-0">Mobile Number: <?php showAsterisk($editMode); ?></label>
              <input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo $employee['mobile']; ?>" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="email" class="mb-0">Email Address: <?php showAsterisk($editMode); ?></label>
              <input id="email" name="email" type="email" class="form-control" value="<?php echo $employee['email']; ?>" autocomplete="false" <?php echo setActiveNavigation(!$editMode, 'readonly'); ?> required>
              <input type="hidden" name="data-verifier" value="<?php echo cipher($employee['email']); ?>">
            </div>
          </div>
        </div>

        <?php if ($editMode) : ?>
          <?php requiredLegend(); ?>

          <div class="form-group mb-3">
            <input type="hidden" name="image-verifier" value="<?php echo cipher($employee['picture']); ?>">
            <input type="hidden" name="verifier" value="<?php echo cipher($employeeId); ?>">
            <button class="btn btn-primary btn-block" name="update-personal-information"><i class="fas fa-save fa-fw"></i>Update Personal Information</button>
          </div>
        <?php endif; ?>
      </div><!-- .col-12 -->
    </div><!-- .row -->
    <?php if ($editMode) : ?>
    </form>
  <?php endif; ?>
</div><!-- .tab-pane -->