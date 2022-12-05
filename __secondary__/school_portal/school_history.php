<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
                 <div class="col-lg-12">
				 <?php
				 if (isset($_POST['school_history']))
				 {
					 $remessage=mysqli_query($con,"SELECT * FROM wp_history WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					 if(mysqli_num_rows($remessage)==0)
					 {
						 mysqli_query($con,"INSERT INTO wp_history VALUES(NULL,'".$_POST['messages']."','".$_SESSION['school_id']."')");
					 
					 }else{
					 mysqli_query($con,"UPDATE wp_history SET History_details='".$_POST['messages']."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					 }
					 if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "School History Successfully Saved";
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
					<form action="" Method="POST" enctype="multipart/form-data">
                         <div class="panel-heading">
						 <?php
						  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("website")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						 	?>
							<input type="submit" name="school_history" value="SAVE" class="btn btn-success" style="float:right;">
						    <h4>SCHOOL HISTORY</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
								
							 <?php
								$mymessage=mysqli_query($con,"SELECT * FROM wp_history WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
								$rowmessage=mysqli_fetch_assoc($mymessage);
								
								echo '<textarea name="messages" class="form-control" rows="20" style="text-align:justify;">'.$rowmessage['History_details'].'</textarea>';
								?> 
											
                        </div>
						
						</form>			
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
		