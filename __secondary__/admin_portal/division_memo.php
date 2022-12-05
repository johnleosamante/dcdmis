<?php
if (!is_dir('../../files/'.$_SESSION['year'])) {
    mkdir('../../files/'.$_SESSION['year'], 0777, true);
}
$_SESSION['pathlocation']='../../files/'.$_SESSION['year'];
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
if (isset($_POST['newmemoupload']))
{
	mysqli_query($con,"INSERT INTO post VALUES('".date("yhms")."','".$dateposted."','".$_SESSION['uid']."','".$_POST['memotitle']."','ITO','".$_POST['location']."','".$_POST['ext']."','".$_SESSION['year']."','Memo')");
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
		
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadmemo.php',
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
            //height: 500,
            //quality: 90,
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
			
			  if ( file.percent==100)
			  {
				
			  var filename = file.name;
			  var loc=document.getElementById("destination").value;
			      document.getElementById("location").value =loc + '/' +file.name;
			  var extend=filename.split('.').pop();
			  document.getElementById("ext").value=extend;
			  
			  
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
	
                 <div class="col-lg-10">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="#newmemo" style="float:right;" class="btn btn-primary" data-toggle="modal">UPLOAD MEMO</a>
							<h4>Issuances -> Division Memo</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
								  <tr>
									<th width="5%" style="text-align:center;">#</th>
									<th width="10%">Date Released</th>
									<th>Title</th>
									<th width="14%">Posted by</th>
									<th width="12%"></th>
									
									</tr>
								</thead>
                                <tbody>
								<?php
								$no=0;
								$update=mysqli_query($con,"SELECT * FROM post INNER JOIN tbl_employee ON post.posted_by=tbl_employee.Emp_ID  WHERE post.Post_Type='Memo' ORDER BY post.date_posted Desc");
							   while($rowup=mysqli_fetch_array($update))
									 {
										 $no++;
										 $noOfComment=mysqli_query($con,"SELECT * FROM reply WHERE chat_id='".$rowup['chatID']."'");
								     echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowup['date_posted'].'</td>
											<td>'.$rowup['post_Title'].'</td>
											<td>'.$rowup['Emp_FName'].' '.$rowup['Emp_LName'].'<br/>('.$rowup['post_office'].' SECTION)</td>
											<td style="text-align:center;">
												<a href="view-attachment.php?id='.urlencode(base64_encode($rowup['chatID'])).'" data-toggle="modal" data-target="#viewcomment" title="Comment"><i class="fa  fa-comments fa-fw"></i>('.mysqli_num_rows($noOfComment).')</a> |
												<a href="" title="Downloads"><i class="fa  fa-download fa-fw"></i>(0)</a>
												<a href="" title="Views"><i class="fa  fa-desktop fa-fw"></i>(0)</a>
											</td>
										</tr>';
									 }
								   ?>
								
                                </tbody>
								</table>
						</div>
						
					</div>
                  </div>
                   <div class="col-lg-2">
				   <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>School Year</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						$result=mysqli_query($con,"SELECT * FROM tbl_school_year ORDER BY SYCode Asc");
						while($row=mysqli_fetch_array($result))
						{
							echo '   <div class="radio">
                                           
                                            <label>
                                               <input type="radio" name="optionsRadios" id="optionsRadios1" value="'.$row['SYCode'].'">'.$row['SchoolYear'].'
                                            </label>
									 </div>';
                                            
												  							
						}
						?>	 
						</div>
					</div>
				  </div>
				  
		
              <!-- Modal -->
	 <div class="modal fade" id="viewcomment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="width:1250px;margin-left:auto;margin-right:auto;margin-top:10px;height:450px;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			

	</div></div>
	</div>
 									
	
              <!-- Modal -->
	 <div class="modal fade" id="newmemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	<div class="modal-header">
	
	<h4 class="modal-title" id="myModalLabel">Upload new memorandum</h4>
	</div>
	   <form enctype="multipart/form-data" method="post" role="form" action="">
	
		<div class="modal-body">	
        <label>Memorandum Title</label>
		 <textarea class="form-control" rows="2" name="memotitle"></textarea><hr/>
		 <input type="hidden" name="ext" id="ext">
		 <input type="hidden" name="location" id="location">
		 <input type="hidden" id="destination" value="<?php echo $_SESSION['pathlocation']; ?>">
		 <center>
		   <div id="container">
												
				<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Attach File to upload</button></span>
														
				</div>
			<div id="filelist">Your browser doesn\t have Flash, Silverlight or HTML5 support.</div></center>
		</div>
		<div class="modal-footer">	
		<input type="submit" name="newmemoupload" value="Upload" class="btn btn-primary">
		<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
		</div>
	 </div>
	</div>
	</div>