  <?php
  session_start();
 include("../vendor/jquery/function.php");
  $_SESSION['TCode']=$_GET['id'];
   ?>
   <form action="evaluated-report.php" Method="POST">
<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
          <h3 class="modal-title"><center>Information for Evaluation</center></h3>
        </div>
        <div class="modal-body">
		<label>REQUIREMENTS CHECKLIST</label>
		<?php
		$no=0;
		$result=mysqli_query($con,"SELECT * FROM tbl_erf_requirements ORDER BY ERF_Code Asc");
		while ($row=mysqli_fetch_array($result))
		{
			$no++;
			$req=mysqli_query($con,"SELECT * FROM tbl_applicant_requirement WHERE tbl_applicant_requirement.ERF_Code='".$row['ERF_Code']."' AND tbl_applicant_requirement.Transaction_Code='".$_GET['id']."'");
			if (mysqli_num_rows($req)==1)
			{
			echo '<div class="divider"></div>
				<input type="checkbox" name="'.$no.'" value="'.$row['ERF_Code'].'" style="cursor:pointer;" title="'.$row['ERF_Description'].'" checked> '.$row['ERF_Description'];
			}else{
				echo '<div class="divider"></div>
				<input type="checkbox" name="'.$no.'" value="'.$row['ERF_Code'].'" style="cursor:pointer;" title="'.$row['ERF_Description'].'"> '.$row['ERF_Description'];
			
			}
		}		
		?>        
		</div>
<div class="modal-footer">
<input type="submit" class="btn btn-success" value="Submit" name="submit">
</div>
</form>