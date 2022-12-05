                 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">Post</a>
						
				  <h2>List of announcement</h2>
				  <?php
				 date_default_timezone_set("Asia/Manila");
				$dateposted = date("Y-m-d H:i:s");
				  if (isset($_POST['save_post']))
				  {
					  mysqli_query($con,"INSERT INTO post VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_POST['message']."','".$_SESSION['station']."')");
					 if(mysqli_affected_rows($con)==1)
							{
								$Err = "Successfully posted!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}
				  }elseif (isset($_POST['update_post']))
				  {
					  mysqli_query($con,"UPDATE post SET post_Title='".$_POST['message']."' WHERE id='".$_SESSION['No']."'");
					 if(mysqli_affected_rows($con)==1)
							{
					  $Err = "Successfully updated!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
								$_SESSION['No']="";
							}
				  }
				  ?>
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="10%">DATE POSTED</th>											
												<th width="40%">POSTED DETAILS</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$mypost=mysqli_query($con,"SELECT * FROM post WHERE post_office='".$_SESSION['station']."' ORDER BY date_posted Desc");
									while($row=mysqli_fetch_array($mypost))
									{
										$no++;
									echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['date_posted'].'</td>
											<td>'.$row['post_Title'].'</td>
											<td style="text-align:center;"><a href="edit-post.php?id='.$row['id'].'" title="Edit Post" data-target="#mypost" data-toggle="modal"> <i class="fa   fa-desktop  fa"></i></td>
										</tr>';	
									}
									?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
			  
			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Announcement</center></h3>
		  	
        </div>
		<form action="" Method="POST">
        <div class="modal-body">
		<label>Date Post: </label>
		<input type="text" class="form-control" value="<?php echo $dateposted; ?>" disabled>
		<label>Post Details: </label>
		<textarea class="form-control" name="message" rows="5" required></textarea>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="save_post" Value="POST" class="btn btn-success">
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
		
		<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mypost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  </div>
	  </div>
	  </div>
	  </div>
