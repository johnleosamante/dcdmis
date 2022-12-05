<?php
if (!is_dir('../../pcdmis/bac_materials/'.$_SESSION['year'])) {
    mkdir('../../pcdmis/bac_materials/'.$_SESSION['year'], 0777, true);
}
$_SESSION['pathlocation']='../../pcdmis/bac_materials/'.$_SESSION['year'];


?>
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
          url: 'uploadquotation.php',
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
           // height: 500,
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
			  ans++;  
			  if ( file.percent==100)
			  {
				
			   document.getElementById("filedata").value =file.name;
			  
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
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">Posting</a>
						
				  <h2>PROCUREMENT</h2>
				  <?php
					 date_default_timezone_set("Asia/Manila");
					if (isset($_POST['save_post']))
					{
						$location=$_SESSION['pathlocation'].'/'.$_POST['filename'];
						mysqli_query($con,"INSERT INTO bac_posting VALUES('".$_POST['prodNo']."','".$_POST['project']."','".$_POST['amount']."','".$_POST['enduser']."','".$_POST['datepub']."','".$_POST['datedue']."','".$location."','".$_POST['status']."','".$_SESSION['uid']."','Open')");
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
						    
                          <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#openbac" data-toggle="tab"> Active</a>
                                </li>
                                <li>
									<a href="#closebac" data-toggle="tab"> Closed</a>
                                </li>
								
						</ul>
						<div class="tab-content">
                                <div class="tab-pane fade in active" id="openbac">
								<h3 class="page-header">List of Procurement currently avaliable</h3>
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								 <thead>
									<tr>
										<th width="15%">Project No</th>
										<th>Project Title</th>
										<th width="15%">Amount</th>
										<th width="15%">End User</th>
										<th width="10%">Date Publish</th>
										<th width="10%">Date Close</th>
										<th width="5%"></th>
									</tr>
								 </thead>
								 <tbody>
								 <?php
								$result=mysqli_query($con,"SELECT * FROM bac_posting WHERE Status ='Open' ORDER BY DatePub Desc");
									while($row=mysqli_fetch_array($result))
									{
										 $newpub = date("F d, Y", strtotime($row['DatePub']));  
										$duedate = date("F d, Y", strtotime($row['datedue']));  
										echo '<tr>
												<td>'.$row['ProjectNo'].'</td>
												<td>'.$row['ProjectDetails'].'</td>
												<td> ₱ '.number_format($row['ABC'],2).'</td>
												<td> '.$row['Enuserunit'].'</td>
												<td> '.$newpub.'</td>
												<td> '.$duedate.'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&project='.urlencode(base64_encode($row['ProjectNo'])).'&v='.urlencode(base64_encode("procurement_breakdown")).'">View</a></td>
											</tr>';
									}
								   ?>
								 </tbody>
								 
								</table>
								
						       </div>
								<div class="tab-pane fade" id="closebac">							   
								<h3 class="page-header">List of Procurement currently Not Avaliable</h3>
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								 <thead>
									<tr>
										<th width="15%">Project No</th>
										<th>Project Title</th>
										<th width="15%">Amount</th>
										<th width="15%">End User</th>
										<th width="10%">Date Publish</th>
										<th width="10%">Date Close</th>
										<th width="5%"></th>
									</tr>
								 </thead>
								 <tbody>
								 <?php
								$closepost=mysqli_query($con,"SELECT * FROM bac_posting WHERE Status ='Closed' ORDER BY DatePub Desc");
									while($rowclose=mysqli_fetch_array($closepost))
									{
										 $newpub = date("F d, Y", strtotime($rowclose['DatePub']));  
										$duedate = date("F d, Y", strtotime($rowclose['datedue']));  
										echo '<tr>
												<td>'.$rowclose['ProjectNo'].'</td>
												<td>'.$rowclose['ProjectDetails'].'</td>
												<td> ₱ '.number_format($rowclose['ABC'],2).'</td>
												<td> '.$rowclose['Enuserunit'].'</td>
												<td> '.$newpub.'</td>
												<td> '.$duedate.'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&project='.urlencode(base64_encode($rowclose['ProjectNo'])).'&v='.urlencode(base64_encode("procurement_breakdown")).'">View</a></td>
											</tr>';
									}
								   ?>
								 </tbody>
								 
								</table>
								</div>		
						</div>		
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
         
          <h3 class="modal-title"><center>New Post</center></h3>
		  	
        </div>
		<form action="" Method="POST" ENCTYPE="multipart/form-data">
        <div class="modal-body">
		<label>Project No: </label>
		<input type="text" class="form-control" name="prodNo" required>
		<label>Project: </label>
		<textarea class="form-control" name="project" rows="5" required></textarea>
		<label>ABC: </label>
		<input type="text" class="form-control" name="amount" required>
		<label>End-user-Unit: </label>
		<input type="text" class="form-control" name="enduser" required>
		<label>Date Publish: </label>
		<input type="date" class="form-control" name="datepub" required>
		<label>Due Close: </label>
		<input type="date" class="form-control" name="datedue" required>
		<input type="hidden" class="form-control" id="filedata" name="filename">
		<label>Post Status: </label>
		<select name="status" class="form-control" required>
		 <option value="">--select--</option>
		 <option value="New">New</option>
		 <option value="Re-Post">Re-post</option>
		 <option value="Re-BID">Re-BID</option>
		</select>
		</div>
		 <div class="modal-footer">
		<div id="container" style="float:left;">
												
		<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-primary">Upload Request for Quotation</button></span>
														
		</div>
		<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
		<input type="submit" name="save_post" Value="POST" class="btn btn-success">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
		<script>
		 function remove_me(id)
		 {
			if (confirm("Are you sure yuo want to remove this project No. "+id ))
			{
				window.location.href='remove_bac_post.php?id='+id;
			}
		 }
		</script>