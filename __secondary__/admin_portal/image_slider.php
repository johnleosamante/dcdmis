<?php 
if (!is_dir('../../images/slider/')) {
    mkdir('../../images/slider/', 0777, true);
}
$_SESSION['pathlocation']='../../images/slider/';

?>
<style>
th,td{
	text-transform:uppercase;
}
</style>
<script>
	
      window.addEventListener("load", function () 
      {
		var ans=0;
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadslider.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
            //width: 500,
           // height: 500,
           // quality: 90,
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
			  var location = document.getElementById("loc").value
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			 
			  if ( file.percent==100)
			  {
				
			   document.getElementById("filedata").value =location + file.name;
			  
			  
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


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#newdownload" class="btn btn-primary" style="float:right;" data-toggle="modal">New Slider</a>
						
				  <h2>List of Slider</h2>
				  <?php
				    date_default_timezone_set("Asia/Manila");
					$dateposted = date("Y-m-d H:i:s");
					if (isset($_POST['new_slider']))
					{
					//Title
					$dataA=$_POST['slide_title'];
					$dataA=str_replace("'","\'",$dataA);
					
					//Sub Title
					$dataB=$_POST['slide_sub_title'];
					$dataB=str_replace("'","\'",$dataB);
					
				     mysqli_query($con,"INSERT INTO slider_img VALUES(NULL,'".$dataA."','".$dataB."','".$_POST['filelocation']."','".$dateposted."','".$_SESSION['uid']."','Show','','#')");
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
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="10%">DATE UPLOADED</th>											
												<th>TITLE</th>
												<th>SUBTITLE</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$myfiles=mysqli_query($con,"SELECT * FROM slider_img  ORDER BY date_uploaded Desc");
										while($row=mysqli_fetch_array($myfiles))	
										{
											$no++;
												echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$row['date_uploaded'].'</td>
													<td>'.$row['title'].'</td>
													<td>'.$row['subtitle'].'</td>
													<td style="text-align:center;">
															<a onclick="remove_me(this.id)" id="'.$row['id'].'" title="Remove File" style="cursor:pointer;"><i class="fa fa-trash-o fa-fw"></i></a>
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
  function remove_me(id)
  {
	  if(confirm("Are you sure you want to remove this files?"))
	  {
		window.location.href="remove_slider.php?id="+id;  
	  }
  }
  </script>
  
  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="newdownload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>New Slider</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Slider Title</label>
		<textarea name="slide_title" class="form-control" rows="3" required></textarea>
		<label>Slider Sub-Title</label>
		<textarea name="slide_sub_title" class="form-control" rows="3" required></textarea>
		<hr/>
		 <input type="hidden"  id="loc" class="form-control" value="<?php echo $_SESSION['pathlocation']; ?>" required>
		 <input type="hidden" name="filelocation" id="filedata" class="form-control" required>
		 <div id="container">
				<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Attach file to download</button></span>											
			</div>
		   <div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
		 </div>
		 <div class="modal-footer">
		
		<input type="submit" name="new_slider" value="UPLOAD" class="btn btn-primary">
		<button type="button" data-dismiss="modal" onclick="window.location.reload();" class="btn btn-default">Closed</button>
		 </div>
		 </form>
     </div>
	</div>
 </div>
		
	