<?php
include_once('../../_includes_/function.php');
include_once('../../_includes_/database/database.php');

$supervisor = '';
$result = mysqli_query($con, "SELECT * FROM tbl_office WHERE Office_Name='" . $_GET['id'] . "' LIMIT 1");

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $supervisor = $row['Office_Chief'];
} else {
  $supervisor = '';
}

?>

<label class="mt-3 mb-0">Immediate Supervisor:</label>
<input type="text" value="<?php echo $supervisor; ?>" class="form-control" disabled>
<input type="hidden" name="signature" value="<?php echo $supervisor; ?>" class="form-control" required>