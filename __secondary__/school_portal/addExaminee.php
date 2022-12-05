 <?php
  if (!is_dir('../image/')) {
    mkdir('../image/', 0777, true);
  }
  
  
if (isset($_POST['register']))
{
 $myfile = $_FILES['image']['name'];
	//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
	$temp = $_FILES['image']['tmp_name'];
	$type = $_FILES['image']['type'];
	$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
	$mynewimage='../image/'.$_POST['lrn'].'.'.$ext;
	move_uploaded_file($temp, $mynewimage);				
 mysqli_query($con,"INSERT INTO tbl_student VALUES('".$_POST['lrn']."','".$_POST['Last_Name']."','".$_POST['First_Name']."','".$_POST['Middle_Name']."','-','-','".$_POST['Parent_Contact']."','-','-','-','-','-','-','-','-','".$_SESSION['school_id']."','-','-','-','".$mynewimage."')");
 mysqli_query($con,"INSERT INTO tbl_assessment_rat VALUES (NULL,'".$_POST['deped_email']."','".$_SESSION['school_id']."','".$_POST['year_level']."','".$_POST['lrn']."','-')");						
	if(mysqli_affected_rows($con)==1)
	{
	?>	
		
 <script type="text/javascript">
		$(document).ready(function(){						
			 $('#access').modal({
				show: 'true'
			}); 				
		});
		</script>
		
	<?php			
	}
}	

?>
 
<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
	
 <form action="" Method="POST" enctype="multipart/form-data">
		  <div class="col-lg-4">
		   
            			    <?php
             echo  '<div class="panel-body">';
             
			  if (isset($_SESSION['LearnerPic']))
			  {
				echo '<img src="../image/'.$_SESSION['LearnerPic'].'" width="100%" height="250" title="Click to upload new picture!" id="pic"> ';  
			  }else{
				echo '<img src="../logo/user.png" width="100%" height="250" id="pic" title="Click to upload new picture!">';
			  }
			  ?> <hr/>
				<input type="file" name="image"  style="cursor:pointer;" onchange="loadFile(event)" required>
              </div>
            </section>
            <!--notification end-->

        </div>
		  <div class="col-lg-7">
		   <!--notification start-->
            <section class="panel">
             
              <div class="panel-body">
			  
			  
			 <?php
			 
                echo '<label>Learner Reference Number: </label> 
				<input type="text" name="lrn" placeholder="Enter Learner Reference Number" class="form-control" required>
				<label>Last Name: </label> 
				<input type="text" name="Last_Name" placeholder="Enter Last Name" class="form-control" required>
				<label>First Name: </label> 
				<input type="text" name="First_Name" placeholder="Enter First Name" class="form-control" required>
				<label>Middle Name: </label> 
				<input type="text" name="Middle_Name" placeholder="Enter Middle Name" class="form-control" required>
				
				<label>DepEd Email: </label> 
				<input type="email" name="deped_email" placeholder="Enter DepEd Email (juan.delacruz.deped.gov.ph)" class="form-control" required>
				
				<label>Contact Number: </label> 
				<input type="text" name="Parent_Contact" placeholder="Enter Contact Number" class="form-control" required>
				
				<label>Year Level: </label> 
				<select name="year_level" class="form-control" required>
					<option value="">--select--</option>
					
					<option value="6">Grade 6</option>
					<option value="10">Grade 10</option>
					<option value="12">Grade 12</option>
				</select>
				<br/>
				<input type="submit" name="register" value="Register" class="btn btn-primary">
								
              </div>';
			  ?>
            </section>
            <!--notification end-->

        </div>
		
		</form>
		
        </div>

      </section>
	
    
   
                 <!-- Modal -->
	 <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../logo/check.png" width="100%" height="50%">
			<h3>Successfully Registered!</h3>
		   	</div>
           <div class="modal-footer">
		  <button class="btn btn-secondary" onclick="window.location.href='?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=ZGJlYQ%3D%3D'">OK</button>
		 </div>	

	</div></div>
	</div>
 
 
 
