<?php 
if (!is_dir('../../pcdmis/IDTemplate/'.$_SESSION['year'])) {
    mkdir('../../pcdmis/IDTemplate/'.$_SESSION['year'], 0777, true);
}
$_SESSION['pathlocation']='../../pcdmis/IDTemplate/'.$_SESSION['year'];
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
          url: 'uploadidtemplate.php',
          chunk_size: '200kb',
          max_retries: 2,
          //filters: 
          //{
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          //},
          resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          {
          //  width: 500,
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
				
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			  ans++;  
			  if ( file.percent==100)
			  {
				
			var loc = document.getElementById("location").value + '/' + file.name;
				  
			   document.getElementById("filedata").value =file.name;
			   document.getElementById("myBtn").disabled = false;
			   document.getElementById('pic').src=loc;
			   
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
	
	<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>	
	
	
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="#mytemplate" class="btn btn-primary" style="float:right;" data-toggle="modal">Upload Template</a>
						
				        <h4>Division of Pagadian City ID System</h4>
									   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="20%">Name</th>											
												<th width="20%">Position</th>
												<th>School</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID  ORDER BY tbl_employee.Emp_LName Asc");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										$MiddleName="";
										$MiddleName=mb_strimwidth($row['Emp_MName'],0,1);
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.strtoupper($row['Emp_LName'].'. '.$row['Emp_FName'].' '.$MiddleName.'.').'</td>
												<td>'.$row['Job_description'].'</td>
												<td>'.$row['SchoolName'].'</td>
												<td><a href="print_id_template.php?code='.urlencode(base64_encode($row['Emp_ID'])).'" target="blank" title="Print ID" class="btn btn-info"><i class="fa fa-print fa-fw"></i></a></td>
												
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
           
	           <!-- Modal -->
	 <div class="modal fade" id="mytemplate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<form action="" method="POST">
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Upload ID Template</h4>
			</div>
			 
			<div class="modal-body">
			<img src="" style="width:100%;height:450px;" id="pic"><hr/>
			  <input type="hidden" name="filedata"  id="filedata" class="form-control" onchange="loadFile(event);">
		   <?php
			echo '<input type="hidden"  id="location" value="'.$_SESSION['pathlocation'].'"class="form-control">';
			echo '<input type="hidden" name="newloc"  id="newloc" class="form-control">';
		   ?>
			<center>
			<div id="container">
												
			<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose Template to upload</button></span>
														
			</div>
			<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
		   	</div>
			</center>
           <div class="modal-footer">
		    <input type="submit" name="upload" id="myBtn" value="Upload" class="btn btn-success" disabled>
		    <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			
		 </div>	
		</form>
	</div></div>
	</div>
 
