
<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
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
				  if (isset($_POST['ICT_chart']))
				 {
					 $myfile = $_FILES['picture']['name'];
					 $mynewimage='../../images/';
					 $temp = $_FILES['picture']['tmp_name'];
					 $type = $_FILES['picture']['type'];
					 $ext = pathinfo($myfile, PATHINFO_EXTENSION);	
					 $mynewimage='../../images/ict-'.$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);
						$result=mysqli_query($con,"SELECT * FROM wp_ict_chart WHERE SchoolID='".$_SESSION['school_id']."'");	
					  if (mysqli_num_rows($result)==0)
					  {
						mysqli_query($con,"INSERT INTO wp_ict_chart VALUES(NULL,'".$mynewimage."','".$_SESSION['school_id']."')");  
					  }else{
						mysqli_query($con,"UPDATE wp_ict_chart SET location_details='".$mynewimage."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					  }
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "ICT organization chart Successfully Saved";
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
							
						    <h4>INFORMATION AND COMMUNICATION TECHNOLOGY TEAM</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
								
							 <?php
								$mymessage=mysqli_query($con,"SELECT * FROM wp_ict_chart WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
								$rowmessage=mysqli_fetch_assoc($mymessage);
								
								echo '<a style="cursor:pointer;" title="click to change" onclick="view_file()"><img src="'.$rowmessage['location_details'].'" style="width:100%;heigh:560px;" id="pic"></a>';
								?> 
											
                        </div>
						
						</form>			
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
					<script>
			function view_file()
			{
			  $('#updates_SSG_org').modal({
				show: 'true'
			}); 	
			}			
		</script>
		
		
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="updates_SSG_org" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Update SSG organization Chart</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		
				<input type="file" name="picture"  style="cursor:pointer;" onchange="loadFile(event)" required>
				
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="ICT_chart" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                                       

	</div></div>
	</div>
  </div>
 	
 
		