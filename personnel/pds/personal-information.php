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
      <img src="<?php echo $image; ?>" width="100%" class="my-3" id="employeePhoto">

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="custom-file">
          <input id="imageUpload" type="file" name="image" class="custom-file-input" required>
          <label id="imageUploadLabel" class="custom-file-label" for="imageUpload">Choose file</label>
        </div>

        <input type="submit" name="ChangeProfilePicture" value="Save" class="btn btn-primary btn-block my-3">
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

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="LName" class="mb-0">Last Name:</label>
                  <input id="LName" type="text" name="LName" value="<?php echo $_SESSION['Last_Name']; ?>" class="form-control" placeholder="Last name">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="FName" class="mb-0">First Name:</label>
                  <input id="FName" type="text" name="FName" value="<?php echo $_SESSION['First_Name']; ?>" class="form-control" placeholder="First name">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MName" class="mb-0">Middle Name:</label>
                  <input id="MName" type="text" name="MName" value="<?php echo $_SESSION['Middle_Name']; ?>" class="form-control" placeholder="Middle name">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="Extension" class="mb-0">Extension:</label>
                  <input id="Extension" type="text" name="Extension" value="<?php echo $_SESSION['Extension']; ?>" class="form-control" placeholder="Extension">
                </div><!-- .form-group -->
              </div><!-- .col-md-3 -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="gender" class="mb-0">Sex:</label>
                  <select id="gender" name="gender" class="form-control">
                    <option value="<?php echo $_SESSION['Gender']; ?>"><?php echo $_SESSION['Gender']; ?></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-3 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputBMonth" class="mb-0">Month:</label>
                  <select name="Month" class="form-control" id="inputBMonth" required>
                    <option value="" <?php echo SetOptionSelected('', $_SESSION['Month']); ?>>Birth Month</option>
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
                  <label for="inputBDay" class="mb-0">Day:</label>
                  <input class="form-control" id="inputBDay" name="Day" type="text" placeholder="Birth day" value="<?php echo $_SESSION['Day']; ?>" required>
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="inputBYear" class="mb-0">Year:</label>
                  <select name="Year" class="form-control" id="inputBYear" required>
                    <option value="" <?php echo SetOptionSelected('', $_SESSION['Year']); ?>>Birth Year</option>
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
                  <input id="PLB" type="text" name="PLB" value="<?php echo $_SESSION['Place_of_Birth']; ?>" class="form-control" placeholder="Place of Birth">
                </div><!-- .form-group -->
              </div><!-- .col-md-12 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="citizen" class="mb-0">Citizenship:</label>
                  <input id="citizen" type="text" name="citizen" value="<?php echo $_SESSION['Citizen']; ?>" class="form-control" placeholder="Citizenship">
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="CS" class="mb-0">Civil Status:</label>
                  <select id="CS" name="CS" class="form-control">
                    <option value="<?php echo $_SESSION['Civil_Status']; ?>"><?php echo $_SESSION['Civil_Status']; ?></option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widow">Widow</option>
                    <option value="Separated">Separated</option>
                    <option value="Other">Other</option>
                  </select>
                </div><!-- .form-group -->
              </div><!-- .col-md-6 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="height" class="mb-0">Height (m):</label>
                  <input id="height" type="text" name="height" value="<?php echo $_SESSION['Height']; ?>" class="form-control" placeholder="Height">
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="weight" class="mb-0">Weight (kg):</label>
                  <input id="weight" type="text" name="weight" value="<?php echo $_SESSION['Weight']; ?>" class="form-control" placeholder="Weight">
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->

              <div class="col-md-4">
                <div class="form-group">
                  <label for="blood" class="mb-0">Blood Type:</label>
                  <input id="blood" type="text" name="blood" value="<?php echo $_SESSION['Blood']; ?>" class="form-control" placeholder="Blood Type">
                </div><!-- .form-group -->
              </div><!-- .col-md-4 -->
            </div><!-- .row -->

            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-0">
                  <label for="address" class="mb-0">Residential Addres:</label>
                  <input id="address" type="text" name="address" value="<?php echo $_SESSION['Address']; ?>" class="form-control" placeholder="Residential Address">
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

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group mb-0">
              <label for="Cell" class="mb-0">Contact Number:</label>
              <input id="Cell" type="text" name="Cell" class="form-control" value="<?php echo $_SESSION['Cell_No']; ?>" placeholder="Contact Number">
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
</div>