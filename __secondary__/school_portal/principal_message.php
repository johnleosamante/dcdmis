
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
				 if (isset($_POST['prin_message']))
				 {
					 $mymsg=mysqli_query($con,"SELECT * FROM wp_messages WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					 if (mysqli_num_rows($mymsg)==0)
					 {
					  mysqli_query($con,"INSERT INTO wp_messages VALUES(NULL,'".$_POST['messages']."','../../images/user.jpg','".$_SESSION['school_id']."')");
					 	 
					 }else{
					 mysqli_query($con,"UPDATE wp_messages SET Messages_details='".$_POST['messages']."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					 }
					 if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "Principal Messages Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
						 
					 }
				 }elseif (isset($_POST['update_pic']))
				 {
					 $myfile = $_FILES['image']['name'];
					 $mynewimage='../../images/';
					 $temp = $_FILES['image']['tmp_name'];
					 $type = $_FILES['image']['type'];
					 $ext = pathinfo($myfile, PATHINFO_EXTENSION);	
					 $mynewimage='../../images/'.$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);
						
					 mysqli_query($con,"UPDATE wp_messages SET MessagePic='".$mynewimage."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
					 if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "Principal Picture Successfully Saved";
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
						 	<input type="submit" name="prin_message" value="SAVE" class="btn btn-success" style="float:right;">
						    <h4>PRINCIPAL'S MESSAGES</h4>
						
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
								
							 <?php
								$mymessage=mysqli_query($con,"SELECT * FROM wp_messages WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");
								$rowmessage=mysqli_fetch_assoc($mymessage);
								if ($rowmessage['MessagePic']=="")
								{
									echo '<a style="cursor:pointer;" onclick="change_pic();"><img src="../images/user.png"  width="210" id="pic" height="250" style="border-radius:3em;" title="click to change picture"></a>';
								}else{
								   echo '<a style="cursor:pointer;" onclick="change_pic();"><img src="/../'.$rowmessage['MessagePic'].'"  id="pic" width="210" height="250" style="border-radius:3em;" title="click to change picture"></a>';
								}
								echo '<textarea name="messages" class="form-control" rows="20" style="width:75%;float:right;text-align:justify;">'.$rowmessage['Messages_details'].'</textarea>';
								?> 
											
                        </div>
						
						</form>			
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
			<script>
			 function change_pic()
			 {
				  $('#updates_info').modal({
				show: 'true'
			    }); 
			 }
			</script>			
            

 
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="updates_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Change Principal Picture</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		
				<input type="file" name="image"  style="cursor:pointer;" onchange="loadFile(event)" required>
				
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="update_pic" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
	</div>
	</div>
	</div>
  </div>
 	

