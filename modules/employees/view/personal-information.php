<?php
// modules/employees/view/personal-information.php
?>

<div class="tab-pane fade show active" id="personal-information">
  <div class="row mt-3">
    <div class="col-md-6 col-lg-3 col-xl-2 justify-content-center">
      <img src="<?php echo uri() . '/' . $employee['picture']; ?>" width="100%" class="border rounded mb-4">
    </div>

    <div class="col-md-6 col-lg-9 col-xl-10">
      <div class=" form-group">
        <label for="last_name" class="mb-0">Last Name:</label>
        <input id="last_name" type="text" class="form-control" value="<?php echo $employee['lname']; ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <div class="form-group">
            <label for="first_name" class="mb-0">First Name:</label>
            <input id="first_name" type="text" class="form-control" value="<?php echo $employee['fname']; ?>" autocomplete="false" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="name_extension" class="mb-0">Name Extension:</label>
            <input id="name_extension" type="text" class="form-control" value="<?php echo to_handle_null($employee['ext'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="middle_name" class="mb-0">Middle Name:</label>
        <input id="middle_name" type="text" class="form-control" value="<?php echo to_handle_null($employee['mname'], 'N/A'); ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="dob" class="mb-0">Date of Birth:</label>
            <input id="dob" type="text" class="form-control" value="<?php echo $employee['month'] . '/' . $employee['day'] . '/' . $employee['year']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="sex" class="mb-0">Sex:</label>
            <input id="sex" type="text" class="form-control" value="<?php echo $employee['sex']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="civil_status" class="mb-0">Civil Status:</label>
            <input id="civil_status" type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="civil_status_others" class="mb-0">Specify, if Others:</label>
            <input id="civil_status_others" type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status_specify'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="pob" class="mb-0">Place of Birth:</label>
        <input id="pob" type="text" class="form-control" value="<?php echo to_handle_null($employee['pob'], 'N/A'); ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="citizenship" class="mb-0">Citizenship:</label>
            <input id="citizenship" type="text" class="form-control" value="<?php echo to_handle_null($employee['citizenship'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="dual_citizenship" class="mb-0">Dual Citizenship:</label>
            <input id="dual_citizenship" type="text" class="form-control" value="<?php echo $employee['dual_citizenship']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label for="dual_citizen_country" class="mb-0">Please Indicate Country if Dual Citizen:</label>
            <input id="dual_citizen_country" type="text" class="form-control" value="<?php echo to_handle_null($employee['country'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-2">
          <div class="form-group">
            <label for="height" class="mb-0">Height (m):</label>
            <input id="height" type="text" class="form-control" value="<?php echo to_handle_null($employee['height'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-2">
          <div class="form-group">
            <label for="weight" class="mb-0">Weight (kg):</label>
            <input id="weight" type="text" class="form-control" value="<?php echo to_handle_null($employee['weight'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-2">
          <div class="form-group">
            <label for="blood_type" class="mb-0">Blood Type:</label>
            <input id="blood_type" type="text" class="form-control" value="<?php echo to_handle_null($employee['blood_type'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-3">
          <div class="form-group">
            <label for="gsis" class="mb-0">GSIS No.:</label>
            <input id="gsis" type="text" class="form-control" value="<?php echo to_handle_null($employee['gsis'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-3">
          <div class="form-group">
            <label for="pagibig" class="mb-0">PAGIBIG ID No.:</label>
            <input id="pagibig" type="text" class="form-control" value="<?php echo to_handle_null($employee['pagibig'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="philhealth" class="mb-0">PHILHEALTH No.:</label>
            <input id="philhealth" type="text" class="form-control" value="<?php echo to_handle_null($employee['philhealth'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="sss" class="mb-0">SSS No.:</label>
            <input id="sss" type="text" class="form-control" value="<?php echo to_handle_null($employee['sss'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="tin" class="mb-0">TIN No.:</label>
            <input id="tin" type="text" class="form-control" value="<?php echo to_handle_null($employee['tin'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="employee_no" class="mb-0">Agency Employee No.:</label>
            <input id="employee_no" type="text" class="form-control" value="<?php echo to_handle_null($employee['agency_id'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Residential Address:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="rlot" class="mb-0 small">House/Block/Lot No.</label>
            <input id="rlot" type="text" class="form-control" value="<?php echo to_handle_null($employee['rlot'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="rstreet" class="mb-0 small">Street</label>
            <input id="rstreet" type="text" class="form-control" value="<?php echo to_handle_null($employee['rstreet'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="rsubdivision" class="mb-0 small">Subdivision/Village</label>
            <input id="rsubdivision" type="text" class="form-control" value="<?php echo to_handle_null($employee['rsubdivision'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="rbarangay" class="mb-0 small">Barangay</label>
            <input id="rbarangay" type="text" class="form-control" value="<?php echo to_handle_null($employee['rbarangay'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="rcity" class="mb-0 small">City/Municipality</label>
            <input id="rcity" type="text" class="form-control" value="<?php echo to_handle_null($employee['rcity'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label for="rprovince" class="mb-0 small">Province</label>
            <input id="rprovince" type="text" class="form-control" value="<?php echo to_handle_null($employee['rprovince'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="rzip" class="mb-0 small">ZIP Code</label>
            <input id="rzip" type="text" class="form-control" value="<?php echo to_handle_null($employee['rzip'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Permanent Address:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="plot" class="mb-0 small">House/Block/Lot No.</label>
            <input id="plot" type="text" class="form-control" value="<?php echo to_handle_null($employee['plot'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="pstreet" class="mb-0 small">Street</label>
            <input id="pstreet" type="text" class="form-control" value="<?php echo to_handle_null($employee['pstreet'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="psubdivision" class="mb-0 small">Subdivision/Village</label>
            <input id="psubdivision" type="text" class="form-control" value="<?php echo to_handle_null($employee['psubdivision'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="pbarangay" class="mb-0 small">Barangay</label>
            <input id="pbarangay" type="text" class="form-control" value="<?php echo to_handle_null($employee['pbarangay'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="pcity" class="mb-0 small">City/Municipality</label>
            <input id="pcity" type="text" class="form-control" value="<?php echo to_handle_null($employee['pcity'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label for="pprovince" class="mb-0 small">Province</label>
            <input id="pprovince" type="text" class="form-control" value="<?php echo to_handle_null($employee['pprovince'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="pzip" class="mb-0 small">ZIP Code</label>
            <input id="pzip" type="text" class="form-control" value="<?php echo to_handle_null($employee['pzip'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label for="telephone" class="mb-0">Telephone Number:</label>
            <input id="telephone" type="text" class="form-control" value="<?php echo to_handle_null($employee['telephone'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label for="mobile" class="mb-0">Mobile Number:</label>
            <input id="mobile" type="text" class="form-control" value="<?php echo to_handle_null($employee['mobile'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label for="email" class="mb-0">Email Address:</label>
            <input id="email" type="email" class="form-control" value="<?php echo to_handle_null($employee['email'], 'N/A'); ?>" autocomplete="false" readonly>
          </div>
        </div>
      </div>
    </div><!-- .col-12 -->
  </div><!-- .row -->
</div><!-- .tab-pane -->