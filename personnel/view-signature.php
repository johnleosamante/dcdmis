<label>Immediate Supervisor/Head</label>
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_office WHERE Office_Name='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
echo '<input type="text" value="'.$row['Office_Chief'].'" class="form-control" disabled>
<input type="hidden" name="signature" value="'.$row['Office_Chief'].'" class="form-control">';
?>