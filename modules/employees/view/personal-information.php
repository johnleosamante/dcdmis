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
        <label class="mb-0">Last Name:</label>
        <input type="text" class="form-control" value="<?php echo $employee['lname']; ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <div class="form-group">
            <label class="mb-0">First Name:</label>
            <input type="text" class="form-control" value="<?php echo $employee['fname']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Name Extension:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['ext'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="mb-0">Middle Name:</label>
        <input type="text" class="form-control" value="<?php echo to_handle_null($employee['mname'], 'N/A'); ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Date of Birth:</label>
            <input type="text" class="form-control" value="<?php echo $employee['month'] . '/' . $employee['day'] . '/' . $employee['year']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Sex:</label>
            <input type="text" class="form-control" value="<?php echo $employee['sex']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Civil Status:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Specify, if Others:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['civil_status_specify'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="mb-0">Place of Birth:</label>
        <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pob'], 'N/A'); ?>" readonly>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Citizenship:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['citizenship'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Dual Citizenship:</label>
            <input type="text" class="form-control" value="<?php echo $employee['dual_citizenship']; ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="mb-0">Please Indicate Country if Dual Citizen:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['country'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-2">
          <div class="form-group">
            <label class="mb-0">Height (m):</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['height'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-2">
          <div class="form-group">
            <label class="mb-0">Weight (kg):</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['weight'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-2">
          <div class="form-group">
            <label class="mb-0">Blood Type:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['blood_type'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-3">
          <div class="form-group">
            <label class="mb-0">GSIS No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['gsis'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class=" col-lg-3">
          <div class="form-group">
            <label class="mb-0">PAGIBIG ID No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pagibig'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">PHILHEALTH No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['philhealth'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">SSS No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['sss'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">TIN No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['tin'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Agency Employee No.:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['agency_id'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Residential Address:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">House/Block/Lot No.</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rlot'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Street</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rstreet'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Subdivision/Village</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rsubdivision'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Barangay</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rbarangay'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">City/Municipality</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rcity'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="mb-0 small">Province</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rprovince'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">ZIP Code</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['rzip'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Permanent Address:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">House/Block/Lot No.</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['plot'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Street</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pstreet'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Subdivision/Village</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['psubdivision'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">Barangay</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pbarangay'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">City/Municipality</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pcity'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="mb-0 small">Province</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pprovince'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0 small">ZIP Code</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['pzip'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Telephone Number:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['telephone'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="form-group">
            <label class="mb-0">Mobile Number:</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($employee['mobile'], 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="form-group">
            <label class="mb-0">Email Address:</label>
            <input type="email" class="form-control" value="<?php echo to_handle_null($employee['email'], 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>
    </div><!-- .col-12 -->
  </div><!-- .row -->
</div><!-- .tab-pane -->