<?php
# personnel/pds/personal-information.php

$result = mysqli_query($con, "SELECT * FROM tbl_employee WHERE Emp_ID ='" . $_SESSION['EmpID'] . "' LIMIT 1");
$row = mysqli_fetch_assoc($result);

$_SESSION['Last_Name'] = $row['Emp_LName'];
$_SESSION['First_Name'] = $row['Emp_FName'];
$_SESSION['Middle_Name'] = $row['Emp_MName'];
$_SESSION['Extension'] = $row['Emp_Extension'];
$_SESSION['Birthdate'] = ToLongDateString($row['Emp_Year'] . '-' . $row['Emp_Month'] . '-' . $row['Emp_Day']);
$_SESSION['Place_of_Birth'] = $row['Emp_place_of_birth'];
$_SESSION['Citizen'] = $row['Emp_Citizen'];
$_SESSION['Civil_Status'] = $row['Emp_CS'];
$_SESSION['Gender'] = $row['Emp_Sex'];
$_SESSION['Address'] = $row['Emp_Address'];
$_SESSION['Height'] = $row['Emp_Height'];
$_SESSION['Weight'] = $row['Emp_Weight'];
$_SESSION['Blood'] = $row['Emp_Blood_type'];
$_SESSION['Picture'] = $row['Picture'];
$_SESSION['Cell_No'] = $row['Emp_Cell_No'];
$_SESSION['Month'] = $row['Emp_Month'];
$_SESSION['Day'] = $row['Emp_Day'];
$_SESSION['Year'] = $row['Emp_Year'];
?>

<div class="tab-pane fade<?php echo SetActiveNavigationTab(!isset($_SESSION['pdstab']) || $_SESSION['pdstab'] === 'personal-information'); ?>" id="personal-information">

  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0">Personal Information</h3>
    <a href="#PersonalInformationModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-edit fa-fw"></i></span><span class="text">Edit</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col-md-6 col-lg-4 col-xl-2 justify-content-center">
      <?php
      if ($row['Picture'] == "") {
        $image = "../assets/img/user.png";
      } else {
        $image = "../" . $_SESSION['Picture'];
      } ?>
      <img src="<?php echo $image; ?>" width="100%" class="mb-3 border rounded" id="employeePhoto">

      <form action="" method="POST" role="form">
        <div class="custom-file">
          <input id="imageUpload" type="file" name="image" class="custom-file-input" required>
          <label id="imageUploadLabel" class="custom-file-label" for="imageUpload">Choose file</label>
        </div>

        <button type="submit" name="ChangeProfilePicture" class="btn btn-primary btn-block my-3"><i class="fas fa-save fa-fw"></i> Save</button>
      </form>

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
      <table>
        <tr class="border-bottom">
          <th class="py-2">Last Name:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Last_Name']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">First Name:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['First_Name']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Middle Name:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Middle_Name']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Name Extension:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Extension']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Sex:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Gender']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Date of Birth:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Birthdate']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Place of Birth:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Place_of_Birth']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Citizenship:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Citizen']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Civil Status:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Civil_Status']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Height:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Height']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Weight:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Weight']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Blood Type:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Blood']; ?></td>
        </tr>
        <tr class="border-bottom">
          <th class="py-2">Residential Address:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Address']; ?></td>
        </tr>
        <tr>
          <th class="py-2">Contact No.:</th>
          <td class="py-2 px-3"><?php echo $_SESSION['Cell_No']; ?></td>
          <td class="py-2 px-3"><span class="small"><a class="text-decoration-none" href="#ContactNoModal" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></span></td>
        </tr>
      </table>
    </div><!-- .col-md-6 -->
  </div><!-- .row -->

  <div class="modal fade" id="PersonalInformationModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Personal Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="LName" class="mb-0">Last Name:</label>
                  <input id="LName" type="text" name="LName" value="<?php echo $_SESSION['Last_Name']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="FName" class="mb-0">First Name:</label>
                  <input id="FName" type="text" name="FName" value="<?php echo $_SESSION['First_Name']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MName" class="mb-0">Middle Name:</label>
                  <input id="MName" type="text" name="MName" value="<?php echo $_SESSION['Middle_Name']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="Extension" class="mb-0">Extension:</label>
                  <input id="Extension" type="text" name="Extension" value="<?php echo $_SESSION['Extension']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-3 -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="gender" class="mb-0">Sex:</label>
                  <select id="gender" name="gender" class="form-control">
                    <option value="Male" <?php echo SetOptionSelected('Male', $_SESSION['Gender']); ?>>Male</option>
                    <option value="Female" <?php echo SetOptionSelected('Female', $_SESSION['Gender']); ?>>Female</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-3 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputBMonth" class="mb-0">Birth Month:</label>
                  <select name="Month" class="form-control" id="inputBMonth" required>
                    <option value="01" <?php echo SetOptionSelected('01', $_SESSION['Month']); ?>>January</option>
                    <option value="02" <?php echo SetOptionSelected('02', $_SESSION['Month']); ?>>February</option>
                    <option value="03" <?php echo SetOptionSelected('03', $_SESSION['Month']); ?>>March</option>
                    <option value="04" <?php echo SetOptionSelected('04', $_SESSION['Month']); ?>>April</option>
                    <option value="05" <?php echo SetOptionSelected('05', $_SESSION['Month']); ?>>May</option>
                    <option value="06" <?php echo SetOptionSelected('06', $_SESSION['Month']); ?>>June</option>
                    <option value="07" <?php echo SetOptionSelected('07', $_SESSION['Month']); ?>>July</option>
                    <option value="08" <?php echo SetOptionSelected('08', $_SESSION['Month']); ?>>August</option>
                    <option value="09" <?php echo SetOptionSelected('09', $_SESSION['Month']); ?>>September</option>
                    <option value="10" <?php echo SetOptionSelected('10', $_SESSION['Month']); ?>>October</option>
                    <option value="11" <?php echo SetOptionSelected('11', $_SESSION['Month']); ?>>November</option>
                    <option value="12" <?php echo SetOptionSelected('12', $_SESSION['Month']); ?>>December</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputBDay" class="mb-0">Birth Day:</label>
                  <input class="form-control" id="inputBDay" name="Day" type="number" value="<?php echo $_SESSION['Day']; ?>" required>
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputBYear" class="mb-0">Birth Year:</label>
                  <select name="Year" class="form-control" id="inputBYear" required>
                    <?php
                    $age = 0;
                    $year = date('Y');
                    while ($age <= 75) {
                      $age++;
                    ?>
                      <option value="<?php echo $year; ?>" <?php echo SetOptionSelected($year, $_SESSION['Year']); ?>><?php echo $year; ?></option>
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
                  <label for="PLB" class="mb-0">Place of Birth:</label>
                  <input id="PLB" type="text" name="PLB" value="<?php echo $_SESSION['Place_of_Birth']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-12 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="citizen" class="mb-0">Citizenship:</label>
                  <input id="citizen" type="text" name="citizen" value="<?php echo $_SESSION['Citizen']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="CS" class="mb-0">Civil Status:</label>
                  <select id="CS" name="CS" class="form-control">
                    <option value="Single" <?php echo SetOptionSelected('Single', $_SESSION['Civil_Status']); ?>>Single</option>
                    <option value="Married" <?php echo SetOptionSelected('Married', $_SESSION['Civil_Status']); ?>>Married</option>
                    <option value="Widow" <?php echo SetOptionSelected('Widow', $_SESSION['Civil_Status']); ?>>Widow</option>
                    <option value="Separated" <?php echo SetOptionSelected('Separated', $_SESSION['Civil_Status']); ?>>Separated</option>
                    <option value="Other" <?php echo SetOptionSelected('Other', $_SESSION['Civil_Status']); ?>>Other</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="height" class="mb-0">Height (m):</label>
                  <input id="height" type="number" name="height" min="0" step="0.01" value="<?php echo $_SESSION['Height']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="weight" class="mb-0">Weight (kg):</label>
                  <input id="weight" type="number" name="weight" min="0" step="0.01" value="<?php echo $_SESSION['Weight']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="blood" class="mb-0">Blood Type:</label>
                  <select id="blood" name="blood" class="form-control">
                    <option value="A+" <?php echo SetOptionSelected('A+', $_SESSION['Blood']); ?>>A+</option>
                    <option value="A-" <?php echo SetOptionSelected('A-', $_SESSION['Blood']); ?>>A-</option>
                    <option value="B+" <?php echo SetOptionSelected('B+', $_SESSION['Blood']); ?>>B+</option>
                    <option value="B-" <?php echo SetOptionSelected('B-', $_SESSION['Blood']); ?>>B-</option>
                    <option value="AB+" <?php echo SetOptionSelected('AB+', $_SESSION['Blood']); ?>>AB+</option>
                    <option value="AB-" <?php echo SetOptionSelected('AB-', $_SESSION['Blood']); ?>>AB-</option>
                    <option value="O+" <?php echo SetOptionSelected('O+', $_SESSION['Blood']); ?>>O+</option>
                    <option value="O-" <?php echo SetOptionSelected('O-', $_SESSION['Blood']); ?>>O-</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-0">
                  <label for="address" class="mb-0">Residential Address:</label>
                  <input id="address" type="text" name="address" value="<?php echo $_SESSION['Address']; ?>" class="form-control">
                </div><!-- .form-group -->
              </div><!-- .col-md-12 -->
            </div><!-- .row -->
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="UpdatePersonalInformation">Update</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->

  <div class="modal fade" id="ContactNoModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group mb-0">
              <label for="Cell" class="mb-0">Contact Number:</label>
              <input id="Cell" type="text" name="Cell" class="form-control" value="<?php echo $_SESSION['Cell_No']; ?>">
            </div><!-- .form-group -->
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="UpdateContactNo" value="SAVE">Update</button>
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div><!-- .tab-pane -->