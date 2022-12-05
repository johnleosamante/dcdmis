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
					 $mynewimage='../../images/'.date('Ymds').$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);			 
					mysqli_query($con,"INSERT INTO wp_slider VALUES(NULL,'".$_POST['date_post']."','".$mynewimage."','".$_POST['post_title']."','".$ext."','".$_SESSION['school_id']."')");
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "Image Slider Successfully Saved";
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
							   <h4>IMAGE SLIDER</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="" method="POST" enctype="multipart/form-data">
						<?php
						 date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");	
							echo '
								<label>Date Post:</label>
								<input type="text" name="date_post" value="'.$dateposted.'" class="form-control" required> 
								<label>Title:</label>
								<textarea type="text" name="post_title" class="form-control" required rows="4"></textarea>
								<label>Attach file:</label>
								<input type="file" name="picture" required>	';
							?>	<hr/>
								<input type="submit" name="submit_slide" value="SUBMIT" style="cursor:pointer;" class="btn btn-primary">
						</form>
						</div>
						
							
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			