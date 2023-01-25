<?php
$family = mysqli_query($con, "SELECT * FROM tbl_family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

if (mysqli_num_rows($family) > 0) {
  $member = mysqli_fetch_assoc($family);
  $slast = $member['SpouseLast'];
  $sfirst = $member['SpouseFirst'];
  $sext = $member['SpouseExtension'];
  $smiddle = $member['SpouseMiddle'];
  $soccupation = $member['SpouseOccupation'];
  $sbusiness = $member['SpouseBusiness'];
  $sbusinessaddress = $member['SpouseBusinessAddress'];
  $stelephone = $member['SpouseTelephone'];
  $flast = $member['FatherLast'];
  $ffirst = $member['FatherFirst'];
  $fext = $member['FatherExtension'];
  $fmiddle = $member['FatherMiddle'];
  $mlast = $member['MotherLast'];
  $mfirst = $member['MotherFirst'];
  $mmiddle = $member['MotherMiddle'];
} else {
  $slast = $sfirst = $sext = $smiddle = $soccupation = $sbusiness = $sbusinessaddress = $stelephone = $flast = $ffirst = $fext = $fmiddle = $mlast = $mfirst = $mmiddle = '';
}
?>

<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'family-background'); ?>" id="family-background">
  <div class="d-sm-flex">
    <h3 class="h4 mb-0">Family Background</h3>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col">
      <form action="" method="POST" role="form">
        <div>Spouse:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="SLastName" class="mb-0 small">Last Name</label>
              <input type="text" class="form-control" id="SLastName" name="SLastName" value="<?php echo $slast; ?>">
            </div>
          </div>

          <div class="col-lg-3 col-sm-9">
            <div class="form-group">
              <label for="SFirstName" class="mb-0 small">First Name</label>
              <input type="text" class="form-control" id="SFirstName" name="SFirstName" value="<?php echo $sfirst; ?>">
            </div>
          </div>

          <div class="col-lg-1 col-sm-3">
            <div class="form-group">
              <label for="SNameExtension" class="mb-0 small">Extension</label>
              <input type="text" class="form-control" id="SNameExtension" name="SNameExtension" value="<?php echo $sext; ?>">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="SMiddleName" class="mb-0 small">Middle Name</label>
              <input type="text" class="form-control" id="SMiddleName" name="SMiddleName" value="<?php echo $smiddle; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="SOccupation" class="mb-0 small">Occupation</label>
              <input type="text" class="form-control" id="SOccupation" name="SOccupation" value="<?php echo $soccupation; ?>">
            </div>
          </div>

          <div class="col-lg-8">
            <div class="form-group">
              <label for="SBusiness" class="mb-0 small">Employer/Business Name</label>
              <input type="text" class="form-control" id="SBusiness" name="SBusiness" value="<?php echo $sbusiness; ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8">
            <div class="form-group">
              <label for="SBusinessAddress" class="mb-0 small">Business Address</label>
              <input type="text" class="form-control" id="SBusinessAddress" name="SBusinessAddress" value="<?php echo $sbusinessaddress; ?>">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="STelephone" class="mb-0 small">Telephone No.</label>
              <input type="text" class="form-control" id="STelephone" name="STelephone" value="<?php echo $stelephone; ?>">
            </div>
          </div>
        </div>

        <div>Father:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="FLastName" class="mb-0 small">Last Name</label>
              <input type="text" class="form-control" id="FLastName" name="FLastName" value="<?php echo $flast; ?>">
            </div>
          </div>

          <div class="col-lg-3 col-sm-9">
            <div class="form-group">
              <label for="FFirstName" class="mb-0 small">First Name</label>
              <input type="text" class="form-control" id="FFirstName" name="FFirstName" value="<?php echo $ffirst; ?>">
            </div>
          </div>

          <div class="col-lg-1 col-sm-3">
            <div class="form-group">
              <label for="FNameExtension" class="mb-0 small">Extension</label>
              <input type="text" class="form-control" id="FNameExtension" name="FNameExtension" value="<?php echo $fext; ?>">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="FMiddleName" class="mb-0 small">Middle Name</label>
              <input type="text" class="form-control" id="FMiddleName" name="FMiddleName" value="<?php echo $fmiddle; ?>">
            </div>
          </div>
        </div>

        <div>Mother:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="MLastName" class="mb-0 small">Last Name</label>
              <input type="text" class="form-control" id="MLastName" name="MLastName" value="<?php echo $mlast; ?>">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="MFirstName" class="mb-0 small">First Name</label>
              <input type="text" class="form-control" id="MFirstName" name="MFirstName" value="<?php echo $mfirst; ?>">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="MMiddleName" class="mb-0 small">Middle Name</label>
              <input type="text" class="form-control" id="MMiddleName" name="MMiddleName" value="<?php echo $mmiddle; ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-primary btn-block " name="UpdateFamilyBackground"><i class="fas fa-save fa-fw"></i>Update Family Background</button>
        </div>
      </form>

      <hr class="mt-2">

      <div class="d-sm-flex justify-content-between my-3">
        <span>&nbsp;</span>
        <a onclick="viewdata('Modal', 'pds/update/update-child.php?id=')" data-target="#Modal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add Child</span></a>
      </div>

      <div class="row">
        <div class="col table-responsive">
          <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
            <thead>
              <tr class="text-center">
                <th width="70%">Name of Children</th>
                <th width="20%">Date of Birth</th>
                <th width="10%">Action</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $children = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY Birthdate DESC;");

              if (mysqli_num_rows($children) > 0) {
                while ($child = mysqli_fetch_array($children)) { ?>
                  <tr>
                    <td class="text-center align-middle"><?php echo ToName($child['Family_Name'], $child['First_Name'], $child['Middle_Name'], $child['Name_Extension'], true); ?></td>
                    <td class="text-center align-middle"><?php echo ToLongDateString($child['Birthdate']); ?></td>
                    <td class="text-center align-middle">
                      <a class="btn btn-success my-1 btn-sm" onclick="viewdata('Modal', 'pds/update/update-child.php?id=<?php echo $child['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                      <a class="btn btn-danger my-1 btn-sm" onclick="viewdata('Modal', 'pds/delete/delete-child.php?id=<?php echo $child['No']; ?>')" data-toggle="modal" data-target="#Modal" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                    </td>
                  </tr>
                <?php
                }
              } else { ?>
                <tr>
                  <td class="text-center align-middle" colspan="3">No data available in table</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>