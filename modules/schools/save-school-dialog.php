<?php
// modules/schools/save-school-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$schoolId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$schools = schoolDetailsById($schoolId);
$school = $schoolName = $address = $category = $districtCode = $alias = null;
$modalTitle = 'Add School';
$notFound = true;

if (numRows($schools) > 0) {
    $school = fetchAssoc($schools);
    $schoolName = $school['name'];
    $address = $school['address'];
    $category = $school['category'];
    $districtCode = $school['district'];
    $alias = $school['alias'];
    $modalTitle = 'Edit School';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="school-id" class="mb-0">School ID <?php showAsterisk(); ?></label>
                    <input type="text" id="school-id" name="school-id" class="form-control" value="<?php echo $schoolId; ?>" required>
                </div>
                <div class="form-group">
                    <label for="school-name" class="mb-0">Name <?php showAsterisk(); ?></label>
                    <input type="text" id="school-name" name="school-name" class="form-control" value="<?php echo $schoolName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="alias" class="mb-0">Alias <?php showAsterisk(); ?></label>
                    <input type="text" id="alias" name="alias" class="form-control" value="<?php echo $alias; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address" class="mb-0">Address <?php showAsterisk(); ?></label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo $address; ?>" required>
                </div>
                <div class="form-group">
                    <label for="district" class="mb-0">District <?php showAsterisk(); ?></label>
                    <select id="district" name="district" class="form-control" required>
                        <option value="">Select district...</option>
                        <?php $districts = districts();
                        while ($district = fetchAssoc($districts)) : ?>
                            <option value="<?php echo $district['id']; ?>" <?php echo setOptionSelected($district['id'], $districtCode); ?>><?php echo $district['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category" class="mb-0">Category <?php showAsterisk(); ?></label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">Select category...</option>
                        <option value="Elementary" <?php echo setOptionSelected('Elementary', $category); ?>>Elementary</option>
                        <option value="Secondary" <?php echo setOptionSelected('Secondary', $category); ?>>Secondary</option>
                        <option value="Integrated" <?php echo setOptionSelected('Integrated', $category); ?>>Integrated</option>
                        <option value="Office" <?php echo setOptionSelected('Office', $category); ?>>Office</option>
                    </select>
                </div>
                <?php requiredLegend(0); ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
                <input type="hidden" name="data-verifier" value="<?php echo isset($_GET['e']) ? $_GET['e'] : null; ?>">
                <button class="btn btn-primary" name="save-school" type="submit">Continue</button>
                <?php cancelModalButton(); ?>
            </div>
        </form>
    </div>
</div>