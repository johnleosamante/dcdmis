<?php 
$_SESSION['Access']=$_GET['Access'];
if (!is_dir('../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade_Level'].'/'.$_GET['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'])) {
    mkdir('../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade_Level'].'/'.$_GET['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'], 0777, true);
}
$_SESSION['pathlocation']='../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade_Level'].'/'.$_GET['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'];

    if(isset($_POST['NewQuiz']))
		{
			$Title=strtoupper($_POST['type_of_activity']);
				$Title=str_replace("'","\'",$Title);
				mysqli_query($con,"INSERT INTO tbl_written_work_set_activity VALUES(NULL,'".$Title."','".$_POST['ItemNo']."','".$_SESSION['SubCode']."','".$_SESSION['Quarter']."','".$_SESSION['year']."','0','".$_SESSION['Grade_Level']."','".$_SESSION['Access']."','".$_POST['name_of_activity']."','Closed','".$_POST['actstatus']."')");	
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
		}elseif (isset($_POST['uploadvid']))
		{
			$text =preg_replace("#.*youtube\.com/watch\?v=#","",$_POST['link']);
			mysqli_query($con,"INSERT INTO tbl_video_materials VALUES (NULL,'".$_POST['topic']."','Youtube','".$text."','".$_SESSION['SubCode']."','".$_GET['Access']."','".$_SESSION['Quarter']."','".$_SESSION['year']."','".$_SESSION['Grade_Level']."','".$_SESSION['uid']."')");
			if (mysqli_affected_rows($con)==1)
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
	
      window.addEventListener("load", function () 
      {
		var ans=0;
        var path = "../pcdmis/js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadmod.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
            width: 500,
            height: 500,
            quality: 90,
          },
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
			  ans++;  
			  if ( file.percent==100)
			  {
				
			   document.getElementById("filedata").value =file.name;
			   document.getElementById("fileNo").value =ans;
			  
			   formSubmit();
			  }
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
	
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
					
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
										
										 
										$myimage=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE tbl_list_of_module_activity.SubCode='".$_SESSION['SubCode']."' AND tbl_list_of_module_activity.ModuleCode ='".$_GET['Access']."' AND Grade_Level='".$_SESSION['Grade_Level']."'  AND Quarter='".$_SESSION['Quarter']."' LIMIT 1");
										$rowimage=mysqli_fetch_assoc($myimage);
										if ($rowimage['Module_location']<>NULL)
										{
										 echo '<iframe src="../pcdmis/reading_materials/'.$rowimage['Module_location'].'" frameborder="0" style="width:100%;height:700px;" disabled></iframe>';
											
											}else{
											echo '<center>
												<div id="container">
												
												<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose File to upload</button></span>
														
												</div>
												 <div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div></center>
												 <a href="" class="btn btn-info" style="float:right;">Continue...</a>';
										}
										
											
										   ?>	
										  
									
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12</td>---->
				 <div class="col-lg-4">
                    <div class="panel panel-default">
					 <div class="panel-heading">	
					   <a href="#newquiz" style="float:right;" class="btn btn-info" data-toggle="modal">Create Quiz</a>
						 <?php
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['SubCode'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("uploadfile")).'"  class="btn btn-secondary">Back to course</a>';
					 ?>
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
							<table width="100%" class="table table-striped table-bordered table-hover">
									 <thead>
									 <tr>
										<th>#</th>
										<th>Type of Activity</th>
										<th>Status</th>
										<th></th>
										</tr>
									 </thead>
									 <tbody>
									  <?php
									  $no=0;
									 $Activity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND Grade_Level='".$_SESSION['Grade_Level']."' AND ModuleCode='".$_SESSION['Access']."'");
									  while ($rowactivity=mysqli_fetch_array($Activity))
									  {
										  $no++;
										  echo '<tr>
													<td>'.$no.'</td>
													<td>'.$rowactivity['Type_of_activity'].' ('.$rowactivity['Name_of_activity'].')</td>
													<td>'.$rowactivity['Activity_status'].'</td>
														<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Act_Code='.urlencode(base64_encode($rowactivity['QCode'])).'&Type='.urlencode(base64_encode($rowactivity['Name_of_activity'])).'&v='.urlencode(base64_encode("written_work_set_work")).'">VIEW</a></td>
												</tr>';
									  }
									  ?>
							  </tbody>
							  </table>
							  
							<hr/>
							  <a href="clear_module.php" class="btn btn-primary">CLEAR MODULE</a> 
							  <a href="#uploadvideo" data-toggle="modal" class="btn btn-success" style="float:right;">UPLOAD VIDEO</a> 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					
					<?php
					$video=mysqli_query($con,"SELECT * FROM tbl_video_materials WHERE SubCode='".$_SESSION['SubCode']."' AND ModuleCode='".$_SESSION['Access']."' AND Quarter='".$_SESSION['Quarter']."' AND School_Year='".$_SESSION['year']."' AND Grade_Level='".$_SESSION['Grade_Level']."'");
					$rowvid=mysqli_fetch_assoc($video);
					echo '<iframe width="100%" height="280" src="https://www.youtube.com/embed/'.$rowvid['video_link'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

					?>
					
                </div>								
            </div>
	

 <form action="" id="frmBox" method="POST" onsubmit="return formSubmit();">
 <input type="hidden" id="filedata" name="filename" required>
 <input type="hidden" id="fileNo" name="Myno" required>

 </form>
 
 
	<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'save_upload.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('filedata').setFucos;
				return false;
				}
	</script>	
	
	
	
	 <!-- Modal for Re-assign-->
<div class="panel-body">
 <!-- Modal -->
	 <div class="modal fade" id="newquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title text-center">NEW QUIZ</h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		 <label>Type of Activity</label>
		 <select name="type_of_activity" class="form-control" required>
			 <option value="">--Select--</option>
			 <option value="Multiple Choice">Multiple Choice</option>
			 <option value="Matching Type">Matching Type</option>
			 <option value="Fill in the blank">Fill in the blank</option>
			 <option value="Identification">Identification</option>
			 <option value="Essay">Essay</option>
			 <option value="True or False">True or False</option>
		 </select>
		 <label>Name of Activity</label>
		 <input type="text" name="name_of_activity" class="form-control" required>
		 <label>Item No:</label>
		  <input type="text" name="ItemNo" class="form-control" placeholder="Number of Item" required>
		   <label>Select Activity:</label>
		  <select name="actstatus" class="form-control" required>
		    <option value="">--select--</option>
		    <option value="RECORDED">RECORDED</option>
		    <option value="NOT RECORDED">NOT RECORDED</option>
		  </select>
		</div>
		<div class="modal-footer">
		<input type="submit" name="NewQuiz" value="CREATE" class="btn btn-primary">
		</div>
		</form>
	 </div>
   </div>
 </div>
</div>
 
 
 
  <!-- Modal for Re-assign-->
<div class="panel-body">
 <!-- Modal -->
	 <div class="modal fade" id="uploadvideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title text-center">NEW VIDEO TO UPLOAD</h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Topic</label>
		<input type="text" name="topic" class="form-control">
		<label>Enter Video Link</label>
		<input type="text" name="link" class="form-control">
		</div>
		<div class="modal-footer">
		<input type="submit" name="uploadvid" value="UPLOAD" class="btn btn-primary">
		</div>
		</form>
	 </div>
   </div>
 </div>
</div>