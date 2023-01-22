<?php
# personnel/pds/personal-information.php

$result = mysqli_query($con, "SELECT * FROM tbl_employee WHERE Emp_ID ='" . $_SESSION['EmpID'] . "' LIMIT 1;");
$row = mysqli_fetch_assoc($result);
$_SESSION['Picture'] = $row['Picture'];
?>

<div class="tab-pane fade<?php echo SetActiveNavigationTab(!isset($_SESSION['pdstab']) || $_SESSION['pdstab'] === 'personal-information'); ?>" id="personal-information">
  <div class="d-sm-flex">
    <h3 class="h4 mb-0">Personal Information</h3>
  </div><!-- .d-sm-flex -->

  <form action="" method="POST" role="form" enctype="multipart/form-data">
    <div class=" row mt-3">
      <div class="col-md-6 col-lg-4 col-xl-2 justify-content-center">
        <?php
        if ($row['Picture'] == "") {
          $image = "../assets/img/user.png";
        } else {
          $image = "../" . $row['Picture'];
        } ?>
        <img src="<?php echo $image; ?>" width="100%" class="mb-3 border rounded" id="employeePhoto">

        <div class="custom-file">
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
                preview.src = '<?php echo GetSiteURL(); ?>/assets/img/nopreview.png';
                break;
            }
          });
        </script>
      </div><!-- .col-md-6 -->

      <div class="col-md-6 col-lg-8 col-xl-10">
        <div class="form-group">
          <label for="LastName" class="mb-0">Last Name: <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="LastName" name="LastName" required value="<?php echo $row['Emp_LName']; ?>">
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="FirstName" class="mb-0">First Name: <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="FirstName" name="FirstName" required value="<?php echo $row['Emp_FName']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="NameExtension" class="mb-0">Name Extension:</label>
              <input type="text" class="form-control" id="NameExtension" name="NameExtension" value="<?php echo $row['Emp_Extension']; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="MiddleName" class="mb-0">Middle Name:</label>
          <input type="text" class="form-control" id="MiddleName" name="MiddleName" value="<?php echo $row['Emp_MName']; ?>">
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="DateofBirth" class="mb-0">Date of Birth: <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="DateofBirth" name="DateofBirth" value="<?php echo $row['Emp_Year'] . '-' . $row['Emp_Month'] . '-' . $row['Emp_Day']; ?>" required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="Sex" class="mb-0">Sex: <span class="text-danger">*</span></label>
              <select name="Sex" id="Sex" class="form-control" required>
                <option value="Male" <?php echo SetOptionSelected('Male', $row['Emp_Sex']); ?>>Male</option>
                <option value="Female" <?php echo SetOptionSelected('Female', $row['Emp_Sex']); ?>>Female</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="CivilStatus" class="mb-0">Civil Status: <span class="text-danger">*</span></label>
              <select name="CivilStatus" id="CivilStatus" class="form-control" required>
                <option value="Single" <?php echo SetOptionSelected('Single', $row['Emp_CS']); ?>>Single</option>
                <option value="Married" <?php echo SetOptionSelected('Married', $row['Emp_CS']); ?>>Married</option>
                <option value="Widowed" <?php echo SetOptionSelected('Widowed', $row['Emp_CS']); ?>>Widowed</option>
                <option value="Separated" <?php echo SetOptionSelected('Separated', $row['Emp_CS']); ?>>Separated</option>
                <option value="Others" <?php echo SetOptionSelected('Others', $row['Emp_CS']); ?>>Others</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="SpecifyOthers" class="mb-0">Specify, if Others:</label>
              <input type="text" class="form-control" id="SpecifyOthers" name="SpecifyOthers" value="<?php echo $row['Emp_CS_Others']; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="PlaceofBirth" class="mb-0">Place of Birth: <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="PlaceofBirth" name="PlaceofBirth" required value="<?php echo $row['Emp_place_of_birth']; ?>">
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="Citizenship" class="mb-0">Citizenship: <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="Citizenship" name="Citizenship" required value="<?php echo $row['Emp_Citizen']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="DualCitizenship" class="mb-0">Dual Citizenship: <span class="text-danger">*</span></label>
              <select name="DualCitizenship" id="DualCitizenship" class="form-control" required>
                <option value="N/A" <?php echo SetOptionSelected('N/A', $row['Emp_Dual_Citizenship']); ?>>N/A</option>
                <option value="By Birth" <?php echo SetOptionSelected('By Birth', $row['Emp_Dual_Citizenship']); ?>>By Birth</option>
                <option value="By Naturalization" <?php echo SetOptionSelected('By Naturalization', $row['Emp_Dual_Citizenship']); ?>>By Naturalization</option>
              </select>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="Country" class="mb-0">Please Indicate Country if Dual Citizen:</label>
              <input type="text" class="form-control" id="Country" name="Country" value="<?php echo $row['Emp_Country']; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2">
            <div class="form-group">
              <label for="Height" class="mb-0">Height (m): <span class="text-danger">*</span></label>
              <input type="number" min="0" step="0.01" class="form-control" id="Height" name="Height" required value="<?php echo $row['Emp_Height']; ?>">
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="Weight" class="mb-0">Weight (kg): <span class="text-danger">*</span></label>
              <input type="number" min="0" step="0.01" class="form-control" id="Weight" name="Weight" required value="<?php echo $row['Emp_Weight']; ?>">
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="BloodType" class="mb-0">Blood Type: <span class="text-danger">*</span></label>
              <select name="BloodType" id="BloodType" class="form-control" required>
                <option value="A+" <?php echo SetOptionSelected('A+', $row['Emp_Blood_type']); ?>>A+</option>
                <option value="A-" <?php echo SetOptionSelected('A-', $row['Emp_Blood_type']); ?>>A-</option>
                <option value="B+" <?php echo SetOptionSelected('B+', $row['Emp_Blood_type']); ?>>B+</option>
                <option value="B-" <?php echo SetOptionSelected('B-', $row['Emp_Blood_type']); ?>>B-</option>
                <option value="AB+" <?php echo SetOptionSelected('AB+', $row['Emp_Blood_type']); ?>>AB+</option>
                <option value="AB-" <?php echo SetOptionSelected('AB-', $row['Emp_Blood_type']); ?>>AB-</option>
                <option value="O+" <?php echo SetOptionSelected('O+', $row['Emp_Blood_type']); ?>>O+</option>
                <option value="O-" <?php echo SetOptionSelected('O-', $row['Emp_Blood_type']); ?>>O-</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="GSIS" class="mb-0">GSIS No.:</label>
              <input type="text" class="form-control" id="GSIS" name="GSIS" value="<?php echo $row['Emp_GSIS']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PAGIBIG" class="mb-0">PAGIBIG ID No.:</label>
              <input type="text" class="form-control" id="PAGIBIG" name="PAGIBIG" value="<?php echo $row['Emp_PAGIBIG']; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PHILHEALTH" class="mb-0">PHILHEALTH No.:</label>
              <input type="text" class="form-control" id="PHILHEALTH" name="PHILHEALTH" value="<?php echo $row['Emp_PHILHEALTH']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="SSS" class="mb-0">SSS No.:</label>
              <input type="text" class="form-control" id="SSS" name="SSS" value="<?php echo $row['Emp_SSS']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="TIN" class="mb-0">TIN No.:</label>
              <input type="text" class="form-control" id="TIN" name="TIN" value="<?php echo $row['Emp_TIN']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="EmployeeNumber" class="mb-0">Agency Employee No.:</label>
              <input type="text" class="form-control" id="EmployeeNumber" name="EmployeeNumber" value="<?php echo $row['EmpNo']; ?>">
            </div>
          </div>
        </div>

        <div>Residential Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResLot" class="mb-0 small">House/Block/Lot No.</label>
              <input type="text" class="form-control" id="ResLot" name="ResLot" value="<?php echo $row['Emp_Res_Lot']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResStreet" class="mb-0 small">Street</label>
              <input type="text" class="form-control" id="ResStreet" name="ResStreet" value="<?php echo $row['Emp_Res_Street']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResSubdivision" class="mb-0 small">Subdivision/Village</label>
              <input type="text" class="form-control" id="ResSubdivision" name="ResSubdivision" value="<?php echo $row['Emp_Res_Subdivision']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResBarangay" class="mb-0 small">Barangay <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ResBarangay" name="ResBarangay" required value="<?php echo $row['Emp_Res_Barangay']; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResCity" class="mb-0 small">City/Municipality <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ResCity" name="ResCity" required value="<?php echo $row['Emp_Res_City']; ?>">
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="ResProvince" class="mb-0 small">Province <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ResProvince" name="ResProvince" required value="<?php echo $row['Emp_Address']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResZIP" class="mb-0 small">ZIP Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ResZIP" name="ResZIP" required value="<?php echo $row['Emp_Res_ZIP']; ?>">
            </div>
          </div>
        </div>

        <div>Permanent Address:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerLot" class="mb-0 small">House/Block/Lot No.</label>
              <input type="text" class="form-control" id="PerLot" name="PerLot" value="<?php echo $row['Emp_Per_Lot']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerStreet" class="mb-0 small">Street</label>
              <input type="text" class="form-control" id="PerStreet" name="PerStreet" value="<?php echo $row['Emp_Per_Street']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerSubdivision" class="mb-0 small">Subdivision/Village</label>
              <input type="text" class="form-control" id="PerSubdivision" name="PerSubdivision" value="<?php echo $row['Emp_Per_Subdivision']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerBarangay" class="mb-0 small">Barangay <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="PerBarangay" name="PerBarangay" required value="<?php echo $row['Emp_Per_Barangay']; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerCity" class="mb-0 small">City/Municipality <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="PerCity" name="PerCity" required value="<?php echo $row['Emp_Per_City']; ?>">
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="PerProvince" class="mb-0 small">Province <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="PerProvince" name="PerProvince" required value="<?php echo $row['Emp_Per_Province']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerZIP" class="mb-0 small">ZIP Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="PerZIP" name="PerZIP" required value="<?php echo $row['Emp_Per_ZIP']; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="Telephone" class="mb-0">Telephone Number:</label>
              <input type="text" class="form-control" id="Telephone" name="Telephone" value="<?php echo $row['Emp_Telephone']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="Mobile" class="mb-0">Mobile Number: <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="Mobile" name="Mobile" value="<?php echo $row['Emp_Cell_No']; ?>" required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="Email" class="mb-0">Email Address: <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $row['Emp_Email']; ?>" required>
            </div>
          </div>
        </div>

        <div class="text-danger mb-3">* Required field</div>

        <div class="form-group mb-0">
          <button class="btn btn-primary btn-block" name="UpdatePersonalInformation"><i class="fas fa-save fa-fw"></i>Update Personal Information</button>
        </div>
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
  </form>
</div><!-- .tab-pane -->