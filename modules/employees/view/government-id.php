<?php
// modules/employees/view/government-id.php
$card = $number = $place = $date = 'N/A';
$employeeIdentifications = employeeIdentification($employeeId);

if (numRows($employeeIdentifications) > 0) {
  $identification = fetchAssoc($employeeIdentifications);
  $cardTypes = cardType($identification['card']);
  $card = numRows($cardTypes) > 0 ? fetchAssoc($cardTypes)['name'] : 'N/A';

  $number = toHandleNull($identification['number'], 'N/A');
  $place = toHandleNull($identification['place'], 'N/A');
  $date = $number !== 'N/A' ? toDate($identification['date']) : 'N/A';
}
?>

<div class="tab-pane fade<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'government-id', 'show active'); ?>" id="government-id">
  <div class="row">
    <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
      <div class="form-group">
        <label for="card-type" class="mb-0">Government Issued ID</label>
        <input type="text" class="form-control" id="card-type" name="card-type" value="<?php echo $card; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="card-number" class="mb-0">ID/License/Passport No.</label>
        <input type="text" class="form-control" id="card-number" name="card-number" value="<?php echo $number; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="card-date" class="mb-0">Date of Issuance</label>
        <input text="date" class="form-control" id="card-date" name="card-date" value="<?php echo $date; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="card-place" class="mb-0">Place of Issuance</label>
        <input type="text" class="form-control" id="card-place" name="card-place" value="<?php echo $place; ?>" readonly>
      </div>
    </div>
  </div>
</div>