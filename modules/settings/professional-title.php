<?php
// modules/settings/professional-title.php
$title = fetchAssoc(employee($userId));
$before = $title['btitle'];
$after = $title['atitle'];
$professionalName = toString($before, '', ' ') . toName($title['lname'], $title['fname'], $title['mname'], $title['ext'], true, true) . toString($after, ', ');
?>

<div class="tab-pane fade" id="professional-title">
  <form class="py-2" action="" method="POST">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="before-title" class="mb-0">Prefix</label>
              <input type="text" class="form-control" id="before-title" name="before-title" value="<?php echo $before; ?>" title="Leave blank if not applicable">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="after-title" class="mb-0">Suffix</label>
              <input type="text" class="form-control" id="after-title" name="after-title" value="<?php echo $after; ?>" title="Leave blank if not applicable">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="mobile" class="mb-0">Preview</label>
          <input type="text" id="mobile" class="form-control" value="<?php echo $professionalName; ?>" readonly>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <input name="update-professional-titles" type="submit" value="Update Professional Titles" class="btn btn-primary btn-block btn-lg">
      </div>
    </div>
  </form>
</div>