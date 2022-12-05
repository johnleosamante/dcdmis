<?php 
$_SESSION['TrainingCode']=$_GET['code'];
if (!is_dir('../training/'.$_GET['code'])) {
    mkdir('../training/'.$_GET['code'], 0777, true);
}
$_SESSION['pathlocation']='../../pcdmis/training/'.$_GET['code'];
?>
			<style>
			td{
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
          url: 'uploadcertificate.php',
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
			  ans++;  
			  if ( file.percent==100)
			  {
				
			  var loc = document.getElementById("location").value + '/' + file.name;
				  
			   document.getElementById("filedata").value =file.name;
			   document.getElementById("myBtn").disabled = false;
			   document.getElementById('pic').src=loc;
			   	//Save new location
			    document.getElementById('newloc').value=loc ;		   
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
											<h4>List of Participants</h4>
											<?php
											if (isset($_POST['upload']))
											{
												mysqli_query($con,"UPDATE tbl_seminar SET Certificate='".$_POST['newloc']."' WHERE Training_Code ='".$_GET['code']."' LIMIT 1");
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
											
											
											<?php
											echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("new_participants")).'" style="float:right;" class="btn btn-success">Add Participant</a>
												   ';
											$result=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code ='".$_GET['code']."' LIMIT 1");
											$row=mysqli_fetch_assoc($result);
									   echo '<label>Title of Training: </label>'.$row['Title_of_training'].'<br/>
											<label>Date Covered: </label> From - '.$row['covered_from'].' To - '.$row['covered_to'].'<br/>
											<label>Venue: </label> '.$row['TVenue'].'<br/>
											<label>Conducted by: </label> '.$row['conducted_by'].'<hr/>';
											
											$_SESSION['Title_Training']=$row['Title_of_training'];
											?>
											<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="30%">NAME OF PARTICIPANTS</th>
												<th>SCHOOL NAME</th>
												<th width="20%">CONTACT #</th>
												<th width="7%"></th>
											</tr>
																			
									</thead>
									<tbody>
									<?php
									$no=0;
									$viewparticipants=mysqli_query($con,"SELECT * FROM tbl_seminar_participant INNER JOIN tbl_employee ON tbl_seminar_participant.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station =tbl_school.SchoolID WHERE tbl_seminar_participant.Training_Code='".$_GET['code']."'");
									while($viewrow=mysqli_fetch_array($viewparticipants))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$viewrow['Emp_LName'].', '.$viewrow['Emp_FName'].'</td>
												<td>'.$viewrow['SchoolName'].'</td>
												<td>'.$viewrow['Emp_Cell_No'].'</td>
												<td>
												<a href="print_certificate.php?certificate='.urlencode(base64_encode($viewrow['Emp_ID'])).'" target="_blank">Participation</a> <br/> 
												<a href="recognition.php?certificate='.urlencode(base64_encode($viewrow['Emp_ID'])).'" target="_blank">Recognition</a> <br/> 
												<a onclick="dalete_data(this.id)" id="'.$viewrow['Emp_ID'].'" style="cursor:pointer;">Remove</a></td>
											</tr>';
									}		
									?>
									</tbody>
									</table>
											</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
<script>	
function dalete_data(id)
{
	if(confirm("Are you sure you want to delete this file?"))
	{
		window.location.href="delete_registered.php?id="+id;
	}
}
</script>	
			

<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>				
	
		
		
	<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="newtemplate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>UPLOAD TEMPLATE</center></h3> 	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
		 <div class="modal-body">
		 <img src="" style="width:100%;height:300px;padding:4px;margin:4px;" id="pic"><br/><br/>
		   <input type="hidden" name="filedata"  id="filedata" class="form-control" onchange="loadFile(event);">
		   <?php
			echo '<input type="hidden"  id="location" value="'.$_SESSION['pathlocation'].'"class="form-control">';
			echo '<input type="hidden" name="newloc"  id="newloc" class="form-control">';
		   ?><center>
		<div id="container">									
		  <span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose File to upload</button></span>
		</div>
		<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
		 </center>
		 </div>
		 
		 <div class="modal-footer">
		 <input type="submit" name="upload" id="myBtn" value="Upload" class="btn btn-success" disabled>
		 </div>
		 </form>
        </div>
        </div>
        </div>
        </div>
		
