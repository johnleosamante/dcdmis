<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>   

 <script>
      window.addEventListener("load", function () 
      {
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadpost.php',
          chunk_size: '200kb',
          max_retries: 2,
          filters: 
          {
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          },
         // resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          //{
            //width: 500,
            //height: 500,
            //quality: 90,
          //},
          init: 
          {
            PostInit: function () 
            {
              document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files) 
            {
              plupload.each(files, function (file) 
              {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
              uploader.start();
            },
            UploadProgress: function (up, file) 
            {
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			  document.getElementById("filedata").value =file.name;
			             },
            Error: function (up, err) 
            {
              // DO YOUR ERROR HANDLING!
              console.log(err);
            }
          }
        });
        uploader.init();
      });
    </script>	
				<div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">Post</a>
						
				  <h2>List of News</h2>
				  <?php
				 date_default_timezone_set("Asia/Manila");
				$dateposted = date("Y-m-d H:i:s");
				  if (isset($_POST['save_post']))
				  {
					 ini_set('mysql.connect_timeout',300);
					ini_set('default_socket_timeout',300);
					$datepost=date("Y-m-d");
					$uploaddir = '../../files/posting/'.$_POST['filename'];
					//$ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
										
					$query=mysqli_query($con,"SELECT * FROM post WHERE post_Title='".$_POST['message']."'");	
					if (mysqli_num_rows($query)==0)
					{
					 mysqli_query($con,"INSERT INTO post VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_POST['message']."','".$_SESSION['station']."','".$uploaddir ."','-')");
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
          <h3 class="modal-title"><center>New Post</center></h3>
		  	
        </div>
		<form action="" Method="POST" ENCTYPE="multipart/form-data">
        <div class="modal-body">
		<label>Date Post: </label>
		<input type="text" class="form-control" value="<?php echo $dateposted; ?>" disabled>
		<label>Post Details: </label>
		<textarea class="form-control" name="message" rows="5" required></textarea>
		<div style="overflow-x:auto;">
		<img src="" style="padding:4px;margin:4px;border-radius:10px;" id="pic" align="left">
		</div>
		<div id="container">
			<label>Attachment</label><br/>
			<input type="hidden" id="filedata" name="filename" required>
				<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-secondary" onchange="loadFile(event)">Choose File</button></span>				
		</div>
		<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>	
		
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
