<?php 

if (!is_dir('../../pcdmis/communication/'.$_SESSION['year'])) {
    mkdir('../../pcdmis/communication/'.$_SESSION['year'], 0777, true);
}
$_SESSION['memopath']='../../pcdmis/communication/'.$_SESSION['year'];

?>
<script>
	
      window.addEventListener("load", function () 
      {
		var location="";
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadattachmemo.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
           // width: 500,
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
				
			 location= document.getElementById("mylocation").value;
			   document.getElementById("location").value = location + '/' + file.name;
			   
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
<div class="col-lg-12">
<h3></h3>
</div>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">New MEMO</a>
						
				  <h2>List of Communication</h2>
				  <?php
				 date_default_timezone_set("Asia/Manila");
				$dateposted = date("Y-m-d H:i:s");
				  if (isset($_POST['publish']))
				  {
					
					$memono=date("ydms");
					mysqli_query($con,"INSERT INTO tbl_communication VALUES('".$memono."','".$dateposted."','".$_POST['source']."','".$_POST['message']."','".$_POST['offices']."','For Dissemination','".$_POST['location']."','".$_SESSION['uid']."')"); 
					mysqli_query($con,"INSERT INTO tbl_memo_notification VALUES(NULL,'".$dateposted."','".$memono."','".$_POST['offices']."','Unread')"); 
					
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
				 }elseif(isset($_POST['update_communication']))
				 {
					 mysqli_query($con,"UPDATE tbl_communication SET sourch_memo='".$_POST['source']."',Memo_Details='".$_POST['message']."',office_destination='".$_POST['offices']."' WHERE MemoNo='".$_SESSION['MemoNo']."' LIMIT 1");
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
					 
				 }
				  ?>
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="15%">DATE POSTED</th>											
												<th>MEMO DETAILS</th>
												<th width="10%">FROM</th>
												<th width="10%">TO</th>
												<th width="15%">CURRENT STATUS</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$mypost=mysqli_query($con,"SELECT * FROM tbl_communication ORDER BY Date_created Desc");
									while($row=mysqli_fetch_array($mypost))
									{
										$no++;
									echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Date_created'].'</td>
											<td>'.$row['Memo_Details'].'</td>
											<td>'.$row['sourch_memo'].'</td>
											<td>'.$row['office_destination'].'</td>
											<td>'.$row['remarks'].'</td>
											<td style="text-align:center;"><a href="edit-post.php?id='.$row['MemoNo'].'" title="Edit Communication" data-target="#mypost" data-toggle="modal"> <i class="fa   fa-desktop  fa"></i></td>
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
         
          <h3 class="modal-title"><center>NEW MEMO UPLOAD</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Date Post: </label>
		<input type="text" class="form-control" value="<?php echo $dateposted; ?>" disabled>
		<label>Memo Details: </label>
		<textarea class="form-control" name="message" rows="5" required></textarea>
		<label>Communication Source: </label>
		<select name="source" class="form-control">
			<option value="">--select--</option>
			<option value="Regional Memo">Regional Memo</option>
			<option value="Central Memo">Central Memo</option>
			<option value="LGU">LGU</option>
			<option value="Others">Others</option>
		</select>
		<label>Office Destination: </label>
		<select name="offices" class="form-control">
			<option value="">--select--</option>
			<option value="SGOD">SGOD</option>
			<option value="CID">CID</option>
			<option value="OSDS">OSDS</option>
			
		</select>
		<input type="hidden"  id="mylocation" value="<?Php echo $_SESSION['memopath']; ?>"class="form-control">
		<input type="hidden" name="location" id="location" class="form-control">
		</div>
		 <div class="modal-footer">
		 <div id="container" style="float:left;">									
			<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-info">Choose File to Attach</button></span>											
			</div>
		<div id="filelist">Your browser doesn\t have Flash, Silverlight or HTML5 support.</div>
		<input type="submit" name="publish" Value="Publish" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
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
