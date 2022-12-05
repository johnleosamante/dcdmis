 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h4>ADD NEW REPORT</h4>
        </div>
			<form action="" Method="POST" enctype="multipart/form-data">
          
        <div class="modal-body">
					<?php
					session_start();
					include("../vendor/jquery/function.php");
					foreach ($_GET as $key => $data)
						{
						$id=$_GET[$key]=base64_decode(urldecode($data));
							
						}
					$result=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode WHERE  tbl_shs_subject.SubNo='".$id."' AND tbl_shs_subject.SchoolID='".$_SESSION['school_id']."'");
				   $row=mysqli_fetch_assoc($result);
				   $_SESSION['SubNo']=$id;
				   $_SESSION['SubType']=$row['SubStrandtype'];
				echo  '
					<label>LEARNING AREAS:</label><br/><input type="text" value="'.$row['SubStrandDescription'].'" class="form-control" disabled><br/>
					<label># OF LEARNER:</label>
					<input type="number" name="no_of_learner" class="form-control" value="0" required>
					<label># OF MODULE:</label>
					<input type="number" name="no_of_module" class="form-control" value="0" required>';
				?>
      </div>
	   <div class="modal-footer">
	   <input type="submit" name="submit_report" class="btn btn-primary" value="SUBMIT">
	   </div>
	      </form>