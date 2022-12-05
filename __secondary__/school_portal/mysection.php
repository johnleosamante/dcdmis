<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
echo '<select name="section" class="form-control" required>
		<option value="">--select--</option>';
		$mynewsec=mysqli_query($con,"SELECT * FROM tbl_section  WHERE tbl_section.SchoolID='".$_SESSION['school_id']."'AND tbl_section.School_Year='".$_SESSION['year']."' AND Grade='".$_GET['id']."'");	
		while($rowsec=mysqli_fetch_array($mynewsec))
		{
		if ($rowsec['Grade']=='Nursery' || $rowsec['Grade']=='Kinder 1' || $rowsec['Grade']=='Kinder 2')
		{
		echo '<option value="'.$rowsec['SecCode'].'">'.$rowsec['Grade'].'-'.$rowsec['SecDesc'].'</option>';
		}else{
		echo '<option value="'.$rowsec['SecCode'].'">Grade '.$rowsec['Grade'].'-'.$rowsec['SecDesc'].'</option>';
		}
		}
		echo '</select>';
?>		