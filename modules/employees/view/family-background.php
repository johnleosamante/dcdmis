<?php
// modules/employees/view/family-background.php

$slast = $sfirst = $sext = $smiddle = $swork = $soffice = $soffice_address = $stelephone = $flast = $ffirst = $fext = $fmiddle = $mlast = $mfirst = $mmiddle = null;
$family_members = family($employee['id']);

if (num_rows($family_members) > 0) {
  $family = fetch_assoc($family_members);
  $slast = $family['slast'];
  $sfirst = $family['sfirst'];
  $sext = $family['sext'];
  $smiddle = $family['smiddle'];
  $swork = $family['swork'];
  $soffice = $family['soffice'];
  $soffice_address = $family['soffice_address'];
  $stelephone = $family['stelephone'];
  $flast = $family['flast'];
  $ffirst = $family['ffirst'];
  $fext = $family['fext'];
  $fmiddle = $family['fmiddle'];
  $mlast = $family['mlast'];
  $mfirst = $family['mfirst'];
  $mmiddle = $family['mmiddle'];
}
?>

<div class="tab-pane fade" id="family-background">
  <div class="row mt-3">
    <div class="col">
      <div>Spouse:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Last Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($slast, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3 col-sm-9">
          <div class="form-group">
            <label class="mb-0 small">First Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($sfirst, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-1 col-sm-3">
          <div class="form-group">
            <label class="mb-0 small">Extension</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($sext, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Middle Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($smiddle, 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Occupation</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($swork, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="form-group">
            <label class="mb-0 small">Employer/Business Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($soffice, 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="form-group">
            <label class="mb-0 small">Business Address</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($soffice_address, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Telephone No.</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($stelephone, 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Father:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Last Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($flast, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-3 col-sm-9">
          <div class="form-group">
            <label class="mb-0 small">First Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($ffirst, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-1 col-sm-3">
          <div class="form-group">
            <label class="mb-0 small">Extension</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($fext, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Middle Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($fmiddle, 'N/A'); ?>" readonly>
          </div>
        </div>
      </div>

      <div>Mother:</div>

      <hr class="mt-2">

      <div class="row">
        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Last Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($mlast, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">First Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($mfirst, 'N/A'); ?>" readonly>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group">
            <label class="mb-0 small">Middle Name</label>
            <input type="text" class="form-control" value="<?php echo to_handle_null($mmiddle, 'N/A'); ?>" readonly>
          </div>
        </div>
      </div><!-- .row -->
    </div><!-- .col -->
  </div><!-- .row -->
</div><!-- .tab-pane -->