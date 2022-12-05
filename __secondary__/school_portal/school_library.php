<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 

                 <div class="col-lg-12">
				 <?php
				 if (isset($_POST['update_library']))
				 {
					 $myfile = $_FILES['picture']['name'];
					
					 $temp = $_FILES['picture']['tmp_name'];
					 $type = $_FILES['picture']['type'];
					 $ext = pathinfo($myfile, PATHINFO_EXTENSION);	
					 $mynewimage='../../images/lib-'.date('Ymds').$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);
					  
					 mysqli_query($con,"UPDATE wp_library SET location_details='".$mynewimage."' WHERE SchoolID='".$_SESSION['school_id']."' AND No='".$_SESSION['PicNo']."' LIMIT 1");
					  
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "School Organizational chart Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
						 
					 }
				 }else if (isset($_POST['Add_library']))
				 {
					  $myfile = $_FILES['picture']['name'];
					
					 $temp = $_FILES['picture']['tmp_name'];
					 $type = $_FILES['picture']['type'];
					 $ext = pathinfo($myfile, PATHINFO_EXTENSION);	
					 $mynewimage='../../images/lib-'.date('Ymds').$_SESSION['school_id'].'.'.$ext;
						
					 move_uploaded_file($temp, $mynewimage);
					 mysqli_query($con,"INSERT INTO wp_library VALUES(NULL,'".$mynewimage."','".$_SESSION['school_id']."')");  
					 
					 if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "School Organizational chart Successfully Saved";
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
							 <a style="float:right;cursor:pointer;" class="btn btn-success" onclick="add_file()">Add</a>
							   <h4>SCHOOL LIBRARY</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
								
							 <?php
								$mymessage=mysqli_query($con,"SELECT * FROM wp_library WHERE SchoolID='".$_SESSION['school_id']."'");
								while ($rowmessage=mysqli_fetch_assoc($mymessage))
								{
								echo '<a href="update_library.php?id='.urlencode(base64_encode($rowmessage['No'])).'" title="click to change" data-toggle="modal" data-target="#updates_School_lib" ><img src="'.$rowmessage['location_details'].'" style="width:100%;heigh:560px;padding:4px;margin:4px;" id="pic"></a>';
								}
							?> 
											
                        </div>
						
						</form>			
		
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
		
		<script>
			function add_file()
			{
			  $('#add_lib').modal({
				show: 'true'
			}); 	
			}			
		</script>
		
	<script>
	var loadFile = function(event) {
    var output = document.getElementById('mypic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>	
		
		
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="updates_School_lib" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	          

	</div></div>
	</div>
  </div>
 	
                  
                 <!-- Modal -->
	 <div class="modal fade" id="add_lib" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Add New Library Features</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		
				<input type="file" name="picture"  style="cursor:pointer;" onchange="loadFile(event)" required>
				<img src="" id="mypic" style="width:100%;">
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="Add_library" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                                       

	</div></div>
	</div>
  </div>
 	
 