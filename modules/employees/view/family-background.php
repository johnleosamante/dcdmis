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

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'family-background', 'show active'); ?>" id="family-background">
  <?php if ($editMode) : ?>
    <form action="" method="POST" role="form">
    <?php endif; ?>
    <div class="row mt-3">
      <div class="col">
        <div>Spouse:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="slast" class="mb-0 small">Last Name</label>
              <input id="slast" name="slast" type="text" class="form-control" value="<?php echo to_handle_null($slast, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3 col-sm-9">
            <div class="form-group">
              <label for="sfirst" class="mb-0 small">First Name</label>
              <input id="sfirst" name="sfirst" type="text" class="form-control" value="<?php echo to_handle_null($sfirst, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-1 col-sm-3">
            <div class="form-group">
              <label for="sext" class="mb-0 small">Extension</label>
              <input id="sext" name="sext" type="text" class="form-control" value="<?php echo to_handle_null($sext, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="smiddle" class="mb-0 small">Middle Name</label>
              <input id="smiddle" name="smiddle" type="text" class="form-control" value="<?php echo to_handle_null($smiddle, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="swork" class="mb-0 small">Occupation</label>
              <input id="swork" name="swork" type="text" class="form-control" value="<?php echo to_handle_null($swork, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="form-group">
              <label for="sbusiness" class="mb-0 small">Employer/Business Name</label>
              <input id="sbusiness" name="sbusiness" type="text" class="form-control" value="<?php echo to_handle_null($soffice, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8">
            <div class="form-group">
              <label for="sbusiness_address" class="mb-0 small">Business Address</label>
              <input id="sbusiness_address" name="sbusiness_address" type="text" class="form-control" value="<?php echo to_handle_null($soffice_address, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="stelephone" class="mb-0 small">Telephone No.</label>
              <input id="stelephone" name="stelephone" type="text" class="form-control" value="<?php echo to_handle_null($stelephone, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div>Father:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="flast" class="mb-0 small">Last Name</label>
              <input id="flast" name="flast" type="text" class="form-control" value="<?php echo to_handle_null($flast, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-3 col-sm-9">
            <div class="form-group">
              <label for="ffirst" class="mb-0 small">First Name</label>
              <input id="ffirst" name="ffirst" type="text" class="form-control" value="<?php echo to_handle_null($ffirst, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-1 col-sm-3">
            <div class="form-group">
              <label for="fext" class="mb-0 small">Extension</label>
              <input id="fext" name="fext" type="text" class="form-control" value="<?php echo to_handle_null($fext, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="fmiddle" class="mb-0 small">Middle Name</label>
              <input id="fmiddle" name="fmiddle" type="text" class="form-control" value="<?php echo to_handle_null($fmiddle, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div>

        <div>Mother:</div>

        <hr class="mt-2">

        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label for="mlast" class="mb-0 small">Last Name</label>
              <input id="mlast" name="mlast" type="text" class="form-control" value="<?php echo to_handle_null($mlast, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="mfirst" class="mb-0 small">First Name</label>
              <input id="mfirst" name="mfirst" type="text" class="form-control" value="<?php echo to_handle_null($mfirst, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label for="mmiddle" class="mb-0 small">Middle Name</label>
              <input id="mmiddle" name="mmiddle" type="text" class="form-control" value="<?php echo to_handle_null($mmiddle, 'N/A'); ?>" <?php echo set_active_navigation(!$editMode, 'readonly'); ?>>
            </div>
          </div>
        </div><!-- .row -->
      </div><!-- .col -->
    </div><!-- .row -->
    <?php if ($editMode) : ?>
      <div class="form-group mb-3">
        <input name="employee_id" type="hidden" value="<?php echo $employee['id']; ?>">
        <button class="btn btn-primary btn-block " name="UpdateFamilyBackground"><i class="fas fa-save fa-fw"></i>Update Family Background</button>
      </div>
    </form>
  <?php endif; ?>
</div><!-- .tab-pane -->