<?php
if (!is_dir('../../pcdmis/psds_report/'.date("Y-m-d"))) {
    mkdir('../../pcdmis/psds_report/'.date("Y-m-d"), 0777, true);
}
 $_SESSION['pathlocation']='../../pcdmis/psds_report/'.date("Y-m-d");
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
          url: 'uploadpsds.php',
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
	<div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
 <div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<a href="#myReport" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">New Report</a>
					<h3>List of School Reports</h3>
						<?php
						
						if (isset($_POST['submit_report']))
								{
									ini_set('mysql.connect_timeout',300);
									ini_set('default_socket_timeout',300);
									
									$uploadfile= $_SESSION['pathlocation'].'/'.$_POST['filename'];
									mysqli_query($con,"INSERT INTO tbl_psds_reports VALUES(NULL,'".$_POST['reportDesc']."','".$_POST['date_upload']."','".$_SESSION['uid']."','".$uploadfile."','Pending..','".$_SESSION['school_id']."','".$_POST['category']."')");
									 if (mysqli_affected_rows($con)==1)
									{
									$Err = "Report Successfully Submitted";
											echo '<script type="text/javascript">
												$(document).ready(function(){						
												$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
												
												});</script>
												';	
										echo '<div class="alert alert-success">'.$Err.'</div>';
									} 
							}

						?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="45%" >TYPE OF REPORTS</th>
												<th width="20%">DATE UPLOADED</th>
												<th width="20%">SUBMITTED BY</th>
												<th width="10%">STATUS</th>
												
											</tr>
																			
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$report=mysqli_query($con,"SELECT * FROM tbl_psds_reports INNER JOIN tbl_employee ON tbl_psds_reports.Updaloaded_by = tbl_employee.Emp_ID WHERE tbl_psds_reports.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_psds_reports.Date_uploaded Desc");
										while($row=mysqli_fetch_array($report))
										{
											$no++;
										echo '<tr><td style="text-align:center;">'.$no.'</td>
												<td>'.$row['ReportCode'].'</td>
												<td>'.$row['Date_uploaded'].'</td>
												<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
												<td>'.$row['File_status'].'</td>
												</tr>
												';
										}
													?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
						
						
                        <!-- /.panel-body 
						-->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
				



<!-- Modal -->
 <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
 
		  <h4 class="modal-title"><center>NEW REPORTS</center></h4>
		   <form enctype="multipart/form-data" method="post" role="form" action="">
	
        </div>
        <div class="modal-body">
		<?php
			date_default_timezone_set("Asia/Manila");
			$dateposted = date("Y-m-d H:i:s");
		echo '<label>Date Upload:</label>
		      <input type="text" name="date_upload" value="'.$dateposted.'" class="form-control" required>';  
			  
		?>
		  <label>Report Description:</label>
		      <textarea name="reportDesc" placeholder="Report Description" class="form-control" rows="2" required></textarea>
			   <label>Report Type:</label>
			   <select name="category" class="form-control">
			    <option value="">--Select--</option>
			    <?php
				$mycat=mysqli_query($con,"SELECT * FROM tbl_category_psds_report ORDER BY Type_of_report Asc");
				while($myrow=mysqli_fetch_array($mycat))
				{
					echo '  <option value="'.$myrow['Type_of_report'].'">'.$myrow['Type_of_report'].'</option>';
				}
				?>
			   </select>
			    <label>Attach File:</label><br/>
			  <input type="hidden" id="filedata" name="filename" required>
				<div id="container">
					<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-secondary">Browse File</button></span>				
				</div>
		<div id="filelist">Your browser doesnt have Flash, Silverlight or HTML5 support.</div>
		
	  </div>
	  <div class="modal-footer">
		<input type="submit" name="submit_report" value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	  </form>
	</div>
	</div>
</div>
<!--End Supervisor-->

