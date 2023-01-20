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
          <label for="LastName" class="mb-0">Last Name:</label>
          <input type="text" class="form-control" id="LastName" name="LastName" required value="<?php echo $row['Emp_LName']; ?>">
        </div>

        <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="FirstName" class="mb-0">First Name:</label>
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
              <label for="DateofBirth" class="mb-0">Date of Birth:</label>
              <input type="date" class="form-control" id="DateofBirth" name="DateofBirth" value="<?php echo $row['Emp_Year'] . '-' . $row['Emp_Month'] . '-' . $row['Emp_Day']; ?>" required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="Sex" class="mb-0">Sex:</label>
              <select name="Sex" id="Sex" class="form-control" required>
                <option value="Male" <?php echo SetOptionSelected('Male', $row['Emp_Sex']); ?>>Male</option>
                <option value="Female" <?php echo SetOptionSelected('Female', $row['Emp_Sex']); ?>>Female</option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="CivilStatus" class="mb-0">Civil Status:</label>
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
              <input type="text" class="form-control" id="SpecifyOthers" name="SpecifyOthers">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="PlaceofBirth" class="mb-0">Place of Birth:</label>
          <input type="text" class="form-control" id="PlaceofBirth" name="PlaceofBirth" required value="<?php echo $row['Emp_place_of_birth']; ?>">
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="Citizenship" class="mb-0">Citizenship:</label>
              <input type="text" class="form-control" id="Citizenship" name="Citizenship" required value="<?php echo $row['Emp_Citizen']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="DualCitizenship" class="mb-0">Dual Citizenship:</label>
              <select name="DualCitizenship" id="DualCitizenship" class="form-control" required>
                <option value="N/A">N/A</option>
                <option value="By Birth">By Birth</option>
                <option value="By Naturalization">By Naturalization</option>
              </select>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="Country" class="mb-0">Please Indicate Country, if Dual Citizen:</label>
              <input type="text" class="form-control" id="Country" name="Country">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2">
            <div class="form-group">
              <label for="Height" class="mb-0">Height (m):</label>
              <input type="text" class="form-control" id="Height" name="Height" required value="<?php echo $row['Emp_Height']; ?>">
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="Weight" class="mb-0">Weight (kg):</label>
              <input type="text" class="form-control" id="Weight" name="Weight" required value="<?php echo $row['Emp_Weight']; ?>">
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group">
              <label for="BloodType" class="mb-0">Blood Type:</label>
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
              <label for="GSISBP" class="mb-0">GSIS Number:</label>
              <input type="text" class="form-control" id="GSISBP" name="GSISBP">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PAGIBIG" class="mb-0">PAGIBIG ID Number:</label>
              <input type="text" class="form-control" id="PAGIBIG" name="PAGIBIG">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PHILHEALTH" class="mb-0">PHILHEALTH Number:</label>
              <input type="text" class="form-control" id="PHILHEALTH" name="PHILHEALTH">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="SSS" class="mb-0">SSS Number:</label>
              <input type="text" class="form-control" id="SSS" name="SSS">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="TIN" class="mb-0">TIN Number:</label>
              <input type="text" class="form-control" id="TIN" name="TIN" value="<?php echo $row['Emp_TIN']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="EmployeeNumber" class="mb-0">Agency Employee Number:</label>
              <input type="text" class="form-control" id="EmployeeNumber" name="EmployeeNumber" value="<?php echo $row['EmpNo']; ?>">
            </div>
          </div>
        </div>

        <div class="form-group mb-0">
          <label>Residential Address:</label>
          <hr class="mt-0">
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResLot" class="mb-0 small">House/Block/Lot No.</label>
              <input type="text" class="form-control" id="ResLot" name="ResLot">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResStreet" class="mb-0 small">Street</label>
              <input type="text" class="form-control" id="ResStreet" name="ResStreet">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResSubdivision" class="mb-0 small">Subdivision/Village</label>
              <input type="text" class="form-control" id="ResSubdivision" name="ResSubdivision">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResBarangay" class="mb-0 small">Barangay</label>
              <input type="text" class="form-control" id="ResBarangay" name="ResBarangay" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResCity" class="mb-0 small">City/Municipality</label>
              <input type="text" class="form-control" id="ResCity" name="ResCity" required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="ResProvince" class="mb-0 small">Province</label>
              <input type="text" class="form-control" id="ResProvince" name="ResProvince" required value="<?php echo $row['Emp_Address']; ?>">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="ResZIP" class="mb-0 small">ZIP Code</label>
              <input type="text" class="form-control" id="ResZIP" name="ResZIP" required>
            </div>
          </div>
        </div>

        <div class="form-group mb-0">
          <label>Permanent Address:</label>
          <hr class="mt-0">
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerLot" class="mb-0 small">House/Block/Lot No.</label>
              <input type="text" class="form-control" id="PerLot" name="PerLot">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerStreet" class="mb-0 small">Street</label>
              <input type="text" class="form-control" id="PerStreet" name="PerStreet">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerSubdivision" class="mb-0 small">Subdivision/Village</label>
              <input type="text" class="form-control" id="PerSubdivision" name="PerSubdivision">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerBarangay" class="mb-0 small">Barangay</label>
              <input type="text" class="form-control" id="PerBarangay" name="PerBarangay" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerCity" class="mb-0 small">City/Municipality</label>
              <input type="text" class="form-control" id="PerCity" name="PerCity" required>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="PerProvince" class="mb-0 small">Province</label>
              <input type="text" class="form-control" id="PerProvince" name="PerProvince" required>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="PerZIP" class="mb-0 small">ZIP Code</label>
              <input type="text" class="form-control" id="PerZIP" name="PerZIP" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label for="Telephone" class="mb-0">Telephone Number:</label>
              <input type="text" class="form-control" id="Telephone" name="Telephone">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label for="Mobile" class="mb-0">Mobile Number:</label>
              <input type="text" class="form-control" id="Mobile" name="Mobile" value="<?php echo $row['Emp_Cell_No']; ?>">
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="Email" class="mb-0">Email Address:</label>
              <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $row['Emp_Email']; ?>">
            </div>
          </div>
        </div>

        <div class="rows">
          <button class="btn btn-primary btn-block btn-lg" name="UpdatePersonalInformation"><i class="fas fa-save fa-fw"></i>Update Personal Information</button>
        </div>
      </div><!-- .col-md-6 -->
    </div><!-- .row -->
  </form>
</div><!-- .tab-pane -->