<?php
// modules/settings/identification.php
$card = $number = $place = '';
$date = date('Y-m-d');
$employeeIdentifications = employeeIdentification($userId);

if (numRows($employeeIdentifications) > 0) {
  $identification = fetchAssoc($employeeIdentifications);
  $card = sanitize($identification['card']);
  $number = sanitize($identification['number']);
  $place = sanitize($identification['place']);
  $date = $identification['date'];
}
?>
<div class="tab-pane fade" id="identification">
  <form class="py-2" action="" method="POST">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="card-type" class="mb-0">Government Issued ID <?php showAsterisk(); ?></label>
          <select class="form-control" id="card-type" name="card-type" required>
            <option value="">Select...</option>
            <?php $cardTypes = cardTypes();
            while ($type = fetchAssoc($cardTypes)) : ?>
              <option value="<?php echo $type['id']; ?>" <?php echo setOptionSelected($type['id'], $card); ?>><?php echo $type['name']; ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="card-number" class="mb-0">ID/License/Passport No. <?php showAsterisk(); ?></label>
          <input type="text" class="form-control" id="card-number" name="card-number" value="<?php echo $number; ?>" required>
        </div>

        <div class="form-group">
          <label for="card-date" class="mb-0">Date of Issuance <?php showAsterisk(); ?></label>
          <input type="date" class="form-control" id="card-date" name="card-date" value="<?php echo $date; ?>" required>
        </div>

        <div class="form-group">
          <label for="card-place" class="mb-0">Place of Issuance <?php showAsterisk(); ?></label>
          <input type="text" class="form-control" id="card-place" name="card-place" value="<?php echo $place; ?>" required>
        </div>

        <?php requiredLegend(); ?>

        <input name="update-identification" type="submit" value="Update Identification Details" class="btn btn-primary btn-block btn-lg">
      </div>
    </div>
  </form>
</div>