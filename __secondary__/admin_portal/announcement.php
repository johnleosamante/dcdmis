
            <div class="row">
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
					  mysqli_query($con,"INSERT INTO post VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_POST['message']."','".$_SESSION['station']."','".$_SESSION['link']."','".$_SESSION['doctype']."')");
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
											<td class="dropdown" style="text-align:center;">
													
										<a class="dropdown-toggle" data-toggle="dropdown" href="#">
											<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
										</a>
											<ul class="dropdown-menu dropdown-user">
																
												<li>
												<a href="edit-post.php?id='.$row['chatID'].'" title="Edit Post" data-target="#mypost" data-toggle="modal"> <i class="fa   fa-edit  fa-fw"></i>Edit</a>
												
													</li>
												<li><a href="remove-post.php?id='.$row['chatID'].'"><i class="fa fa-trash-o fa-fw"></i> Trash</a>
												</li>
												
											</ul>
															
														
													</td>
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
                <!-- /.col-lg-12 -->
            </div>
           
	<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>		  
		
<script>
function get_data()
{
	var a =document.getElementById('message').value;
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("viewattach").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","data-query.php?v="+a,false);
  xmlhttp.send();
}
</script>		
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Create a post</center></h3>
		  	
        </div>
		<?php
		
		echo '<form action="announcement.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
		<input type="hidden" class="form-control" value="'.$dateposted.'" disabled>
		
		<img src="'.$_SESSION['pic'].'" style="width:50px;height:50px;border-radius:50%;padding:4px;" align="left"><b style="padding:4px;margin:4px;">'.$_SESSION['postby'].'</b><br/><label style="padding:4px;margin:4px;">ITO Admin</label>
		<div style="width:100%;height:auto;overflow-x:auto;">
		<textarea class="form-control" name="message" id="message" rows="3" required style="border:none;" onkeyup="get_data();"></textarea>
		<img src="" id="pic" style="border:none;">
		</div><div id="viewattach"></div></div>
		 <div class="modal-footer">
			 <button class="btn btn-default" type="submit" name="save_post" style="width:100%;">
                Post
             </button>
                                
                  
			</div>
		</form>';
		?>
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
