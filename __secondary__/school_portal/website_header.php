<script>
	var loadFile = function(event) {
    var output = document.getElementById('mylogo');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>	
	   <div class="col-lg-12">
				 <?php
				 
				 if (isset($_POST['submit_slide']))
				 {
					 $myfile = $_FILES['picture']['name'];
					
					 $temp = $_FILES['picture']['tmp_name'];
					 $type = $_FILES['picture']['type'];
					 $ext = pathinfo($myfile, PATHINFO_EXTENSION);	
					 $mynewimage='../../school_logo/'.$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);			 
					mysqli_query($con,"INSERT INTO wp_header VALUES(NULL,'". $mynewimage."','".$_SESSION['school_id']."')");
					mysqli_query($con,"UPDATE tbl_school SET SchoolName='".$_POST['header_name']."',Address='".$_POST['header_address']."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "Website header Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
						 
					 }
				 }
				 ?>
				 
                    <div class="panel panel-default">
					
                         <div class="panel-heading">
						 <?php
						  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("website")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						 	?>
							   <h4>WEBSITE HEADER</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="" method="POST" enctype="multipart/form-data">
						<?php
						  $result=mysqli_query($con,"SELECT * FROM wp_header INNER JOIN tbl_school ON wp_header.SchoolID = tbl_school.SchoolID WHERE wp_header.SchoolID='".$_SESSION['school_id']."' LIMIT 1");
						  $row=mysqli_fetch_assoc($result);
							echo '
								<label>HEADER NAME</label>
								<img id="mylogo" style="padding:4px;margin:4px;width:170px;height:180px;" align="left" src="'.$row['logo_location'].'">
								<textarea name="header_name" class="form-control" required style="width:80%;" rows="3 value="'.$row['SchoolName'].'"> '.$row['SchoolName'].'</textarea>
								<label>SCHOOL ADDRESS:</label>
								<textarea name="header_address" class="form-control" required rows="3" style="width:80%;" value="'.$row['Address'].'">'.$row['Address'].'</textarea>
								<label>SCHOOL LOGO:</label>
								<input type="file" name="picture"  onchange="loadFile(event)">
								';
							?>	
								<input type="submit" name="submit_slide" value="SUBMIT" style="cursor:pointer;float:right;" class="btn btn-primary">
						</form>
						</div>
						
							
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			