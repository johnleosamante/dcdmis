<?php
// modules/employees/view/personal-information.php
$_SESSION[alias() . '_current_employee_id'] = $employee['id'];
$_SESSION[alias() . '_current_employee_photo'] = $employee['picture'];
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'personal-information', 'show active'); ?>" id="personal-information">
  <?php if ($editMode) : ?>
    <form action="" method="POST" role="form" enctype="multipart/form-data">
    <?php endif; ?>
    <div class="row mt-3">
      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-4">
        <img src="<?php echo uri() . '/' . $employee['picture']; ?>" width="100%" class="border rounded" id="employee_photo">

        <?php if ($editMode) : ?>
          <div class="mt-3 custom-file">
            <input id="imageUpload" type="file" name="imageUpload" class="custom-file-input">
            <label id="imageUploadLabel" class="custom-file-label" for="imageUpload">Choose file</label>
          </div>

          <script>
            document.getElementById('imageUpload').addEventListener('change', (event) => {
              var preview = document.getElementById('employeePhoto');
              const file = event.target.files[0];
              const name = file.name;
              const lastDot = name.lastIndexOf('.');
              const ext = name.substring(lastDot + 1);
              var label = document.getElementById('imageUploadLabel');
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
          <label for="lname" class="mb-0">Last Name: <?php show_asterisk($editMode); ?></label>
          <input id="lname" name="lname" type="text" class="form-control" value="<?php echo $employee['lname']; ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?> required>
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="fname" class="mb-0">First Name: <?php show_asterisk($editMode); ?></label>
              <input id="fname" name="fname" type="text" class="form-control" value="<?php echo $employee['fname']; ?>" autocomplete="false" <?php echo set_active_navigation(!$editMode, 'readonly'); ?> required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ext" class="mb-0">Name Extension:</label>
              <input id="ext" name="ext" type="text" class="form-control" value="<?php echo to_handle_null($employee['ext'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="mname" class="mb-0">Middle Name:</label>
          <input id="mname" name="mname" type="text" class="form-control" value="<?php echo to_handle_null($employee['mname'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="dob" class="mb-0">Date of Birth: <?php show_asterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="dob" type="text" class="form-control" value="<?php echo $employee['month'] . '/' . $employee['day'] . '/' . $employee['year']; ?>" readonly>
              <?php else : ?>
                <input id="dob" name="dob" type="date" class="form-control" value="<?php echo $employee['year'] . '-' . $employee['month'] . '-' . $employee['day']; ?>" required>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="sex" class="mb-0">Sex: <?php show_asterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="sex" type="text" class="form-control" value="<?php echo $employee['sex']; ?>" readonly>
              <?php else : ?>
                <select id="sex" name="sex" class="form-control" required>
                  <option value="Male" <?php echo set_option_selected('Male', $employee['sex']); ?>>Male</option>
                  <option value="Female" <?php echo set_option_selected('Female', $employee['sex']); ?>>Female</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="civil_status" class="mb-0">Civil Status: <?php show_asterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="civil_status" type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status'], 'N/A'); ?>" readonly>
              <?php else : ?>
                <select id="civil_status" name="civil_status" class="form-control" required>
                  <option value="Single" <?php echo set_option_selected('Single', $employee['civil_status']); ?>>Single</option>
                  <option value="Married" <?php echo set_option_selected('Married', $employee['civil_status']); ?>>Married</option>
                  <option value="Widowed" <?php echo set_option_selected('Widowed', $employee['civil_status']); ?>>Widowed</option>
                  <option value="Separated" <?php echo set_option_selected('Separated', $employee['civil_status']); ?>>Separated</option>
                  <option value="Others" <?php echo set_option_selected('Others', $employee['civil_status']); ?>>Others</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="civil_status_others" class="mb-0">Specify, if Others:</label>
              <input id="civil_status_others" name="civil_status_others" type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status_specify'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="pob" class="mb-0">Place of Birth: <?php show_asterisk($editMode); ?></label>
          <input id="pob" name="pob" type="text" class="form-control" value="<?php echo to_handle_null($employee['pob'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="citizenship" class="mb-0">Citizenship: <?php show_asterisk($editMode); ?></label>
              <input id="citizenship" name="citizenship" type="text" class="form-control" value="<?php echo to_handle_null($employee['citizenship'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="dual_citizenship" class="mb-0">Dual Citizenship: <?php show_asterisk($editMode); ?></label>
              <input id="dual_citizenship" name="dual_citizenship" type="text" class="form-control" value="<?php echo $employee['dual_citizenship']; ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="dual_citizen_country" class="mb-0">Please Indicate Country if Dual Citizen:</label>
              <input id="dual_citizen_country" name="dual_citizenship_country" type="text" class="form-control" value="<?php echo to_handle_null($employee['country'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2">
            <div class="form-group">
              <label for="height" class="mb-0">Height (m): <?php show_asterisk($editMode); ?></label>
              <?php if (!$editMode) : ?>
                <input id="height" type="text" class="form-control" value="<?php echo to_handle_null($employee['height'], 'N/A'); ?>" readonly>
              <?php else : ?>
                <input id="height" name="height" type="number" min="0" step="0.01" class="form-control" value="<?php echo to_handle_null($employee['height'], 'N/A'); ?>">
              <?php endif; ?>
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="weight" class="mb-0">Weight (kg):</label>
              <?php if (!$editMode) : ?>
                <input id="weight" type="text" class="form-control" value="<?php echo to_handle_null($employee['weight'], 'N/A'); ?>" readonly>
              <?php else : ?>
                <input id="weight" name="weight" type="number" min="0" step="0.01" class="form-control" value="<?php echo to_handle_null($employee['weight'], 'N/A'); ?>">
              <?php endif; ?>
            </div>
          </div>

          <div class=" col-lg-2">
            <div class="form-group">
              <label for="blood_type" class="mb-0">Blood Type:</label>
              <?php if (!$editMode) : ?>
                <input id="blood_type" type="text" class="form-control" value="<?php echo to_handle_null($employee['blood_type'], 'N/A'); ?>" readonly>
              <?php else : ?>
                <select name="blood_type" id="blood_type" class="form-control" required>
                  <option value="A+" <?php echo set_option_selected('A+', $employee['blood_type']); ?>>A+</option>
                  <option value="A-" <?php echo set_option_selected('A-', $employee['blood_type']); ?>>A-</option>
                  <option value="B+" <?php echo set_option_selected('B+', $employee['blood_type']); ?>>B+</option>
                  <option value="B-" <?php echo set_option_selected('B-', $employee['blood_type']); ?>>B-</option>
                  <option value="AB+" <?php echo set_option_selected('AB+', $employee['blood_type']); ?>>AB+</option>
                  <option value="AB-" <?php echo set_option_selected('AB-', $employee['blood_type']); ?>>AB-</option>
                  <option value="O+" <?php echo set_option_selected('O+', $employee['blood_type']); ?>>O+</option>
                  <option value="O-" <?php echo set_option_selected('O-', $employee['blood_type']); ?>>O-</option>
                </select>
              <?php endif; ?>
            </div>
          </div>

          <div class=" col-lg-3">
            <div class="form-group">
              <label for="gsis" class="mb-0">GSIS No.:</label>
              <input id="gsis" name="gsis" type="text" class="form-control" value="<?php echo to_handle_null($employee['gsis'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class=" col-lg-3">
            <div class="form-group">
              <label for="pagibig" class="mb-0">PAGIBIG ID No.:</label>
              <input id="pagibig" name="pagibig" type="text" class="form-control" value="<?php echo to_handle_null($employee['pagibig'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="philhealth" class="mb-0">PHILHEALTH No.:</label>
              <input id="philhealth" name="philhealth" type="text" class="form-control" value="<?php echo to_handle_null($employee['philhealth'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="sss" class="mb-0">SSS No.:</label>
              <input id="sss" name="sss" type="text" class="form-control" value="<?php echo to_handle_null($employee['sss'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="tin" class="mb-0">TIN No.:</label>
              <input id="tin" name="tin" type="text" class="form-control" value="<?php echo to_handle_null($employee['tin'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="agency_id" class="mb-0">Agency Employee No.:</label>
              <input id="agency_id" name="agency_id" type="text" class="form-control" value="<?php echo to_handle_null($employee['agency_id'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div>Residential Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="rlot" class="mb-0 small">House/Block/Lot No.</label>
              <input id="rlot" name="rlot" type="text" class="form-control" value="<?php echo to_handle_null($employee['rlot'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rstreet" class="mb-0 small">Street</label>
              <input id="rstreet" name="rstreet" type="text" class="form-control" value="<?php echo to_handle_null($employee['rstreet'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rsubdivision" class="mb-0 small">Subdivision/Village</label>
              <input id="rsubdivision" name="rsubdivision" type="text" class="form-control" value="<?php echo to_handle_null($employee['rsubdivision'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rbarangay" class="mb-0 small">Barangay <?php show_asterisk($editMode); ?></label>
              <input id="rbarangay" name="rbarangay" type=" text" class="form-control" value="<?php echo to_handle_null($employee['rbarangay'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="rcity" class="mb-0 small">City/Municipality <?php show_asterisk($editMode); ?></label>
              <input id="rcity" name="rcity" type="text" class="form-control" value="<?php echo to_handle_null($employee['rcity'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="rprovince" class="mb-0 small">Province <?php show_asterisk($editMode); ?></label>
              <input id="rprovince" name="rprovince" type="text" class="form-control" value="<?php echo to_handle_null($employee['rprovince'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="rzip" class="mb-0 small">ZIP Code <?php show_asterisk($editMode); ?></label>
              <input id="rzip" name="rzip" type="text" class="form-control" value="<?php echo to_handle_null($employee['rzip'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div>Permanent Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="plot" class="mb-0 small">House/Block/Lot No.</label>
              <input id="plot" name="plot" type="text" class="form-control" value="<?php echo to_handle_null($employee['plot'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pstreet" class="mb-0 small">Street</label>
              <input id="pstreet" name="pstreet" type="text" class="form-control" value="<?php echo to_handle_null($employee['pstreet'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="psubdivision" class="mb-0 small">Subdivision/Village</label>
              <input id="psubdivision" name="psubdivision" type="text" class="form-control" value="<?php echo to_handle_null($employee['psubdivision'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pbarangay" class="mb-0 small">Barangay <?php show_asterisk($editMode); ?></label>
              <input id="pbarangay" name="pbarangay" type="text" class="form-control" value="<?php echo to_handle_null($employee['pbarangay'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="pcity" class="mb-0 small">City/Municipality <?php show_asterisk($editMode); ?></label>
              <input id="pcity" name="pcity" type="text" class="form-control" value="<?php echo to_handle_null($employee['pcity'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="pprovince" class="mb-0 small">Province <?php show_asterisk($editMode); ?></label>
              <input id="pprovince" name="pprovince" type="text" class="form-control" value="<?php echo to_handle_null($employee['pprovince'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="pzip" class="mb-0 small">ZIP Code <?php show_asterisk($editMode); ?></label>
              <input id="pzip" name="pzip" type="text" class="form-control" value="<?php echo to_handle_null($employee['pzip'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="telephone" class="mb-0">Telephone Number:</label>
              <input id="telephone" name="telephone" type="text" class="form-control" value="<?php echo to_handle_null($employee['telephone'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="mobile" class="mb-0">Mobile Number: <?php show_asterisk($editMode); ?></label>
              <input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo to_handle_null($employee['mobile'], 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="email" class="mb-0">Email Address: <?php show_asterisk($editMode); ?></label>
              <input id="email" name="email" type="email" class="form-control" value="<?php echo to_handle_null($employee['email'], 'N/A'); ?>" autocomplete="false" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <?php if ($editMode) : ?>
          <div class="text-danger mb-2">* Required field</div>

          <div class="form-group mb-3">
            <button class="btn btn-primary btn-block" name="UpdatePersonalInformation"><i class="fas fa-save fa-fw"></i>Update Personal Information</button>
          </div>
        <?php endif; ?>
      </div><!-- .col-12 -->
    </div><!-- .row -->
    <?php if ($editMode) : ?>
    </form>
  <?php endif; ?>
</div><!-- .tab-pane -->