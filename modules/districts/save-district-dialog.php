<?php
// modules/districts/save-district-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/layout/components.php');

$districtCode = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$districts = district($districtCode);
$districtName = $districtHead = null;
$modalTitle = 'New District';
$notFound = true;

if (numRows($districts) > 0) {
  $district = fetchAssoc($districts);
  $districtName = $district['name'];
  $districtHead = $district['psds'];
  $modalTitle = 'Edit District';
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <?php modalHeader($modalTitle); ?>

    <form action="" method="POST">
      <div class="modal-body">
        <div class="form-group">
          <label for="code" class="mb-0">Alias <?php showAsterisk(); ?></label>
          <input type="text" id="code" name="code" class="form-control" minlength="3" maxlength="5" value="<?php echo $districtCode; ?>" required>
        </div>

        <div class="form-group">
          <label for="district" class="mb-0">Name <?php showAsterisk(); ?></label>
          <input type="text" id="district" name="district" class="form-control" value="<?php echo $districtName; ?>" required>
        </div>

        <div class="form-group">
          <label for="head" class="mb-0">District Supervisor <?php showAsterisk(); ?></label>
          <select id="head" name="head" class="form-control" required>
            <option value="">Select district supervisor...</option>

            <?php $employees = psds(); 
            while ($employee = fetchAssoc($employees)) : ?>
            <option value="<?php echo $employee['id']; ?>" title="<?php echo fetchAssoc(position($employee['id']))['position'];?>" <?php echo setOptionSelected($employee['id'], $districtHead); ?>>
              <?php echo userName($employee['id']); ?>
            </option> 
            <?php endwhile; ?>
          </select>
        </div>

        <?php requiredLegend(0); ?>
      </div>

      <div class="modal-footer">
        <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
        <button class="btn btn-primary" name="save-district" type="submit">Continue</button>
        <?php cancelModalButton(); ?>
      </div>
    </form>
  </div>
</div>