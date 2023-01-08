<?php
if (!is_dir('../pcdmis/step_requirement/'.$_SESSION['year'].'/'.$_SESSION['EmpID'])) {
    mkdir('../pcdmis/step_requirement/'.$_SESSION['year'].'/'.$_SESSION['EmpID'], 0777, true);
}
$_SESSION['pathlocation']='../pcdmis/step_requirement/'.$_SESSION['year'].'/'.$_SESSION['EmpID'];
mysqli_query($con,"UPDATE tbl_messages SET Message_status='Read' WHERE Message_to='".$_SESSION['EmpID']."'  AND No='".$_GET['No']."' LIMIT 1");
date_default_timezone_set("Asia/Manila");
	$dateposted = date("Y-m-d H:i:s");
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
          url: 'uploadrequired.php',
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
			   var loc = document.getElementById("location").value;
			   document.getElementById("filedata").value =file.name;
			   document.getElementById("link").src =loc + '/' +file.name;
			 
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
    var output = document.getElementById('sr');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
	
		<script>
	var loadappoint = function(event) {
    var output = document.getElementById('apoint');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
	
	<?php
	if (isset($_POST['savepayslip']))
	{
		$newloc=$_SESSION['pathlocation'].'/'.$_POST['filename'];
		mysqli_query($con,"INSERT INTO tbl_step_requirements VALUES('".date("ms")."','PAYSLIP','".$dateposted."','".$newloc."','STEP','".$_SESSION['year']."','".$_SESSION['EmpID']."')");
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
	}elseif (isset($_POST['saveappointment']))
	{
		$myfile = $_FILES['appointment']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$temp = $_FILES['appointment']['tmp_name'];
		$type = $_FILES['appointment']['type'];
		$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
		$newloc=$_SESSION['pathlocation'].'/'.$myfile;
		move_uploaded_file($temp, $newloc);
		
		mysqli_query($con,"INSERT INTO tbl_step_requirements VALUES('".date("ms")."','APPOINTMENT','".$dateposted."','".$newloc."','STEP','".$_SESSION['year']."','".$_SESSION['EmpID']."')");
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
	}elseif (isset($_POST['saveservicerecord']))
	{
	   $myfile = $_FILES['service_record']['name'];
		//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
		$temp = $_FILES['service_record']['tmp_name'];
		$type = $_FILES['service_record']['type'];
		$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
		$newloc=$_SESSION['pathlocation'].'/'.$myfile;
		move_uploaded_file($temp, $newloc);
		mysqli_query($con,"INSERT INTO tbl_step_requirements VALUES('".date("ms")."','SERVICE RECORD','".$dateposted."','".$newloc."','STEP','".$_SESSION['year']."','".$_SESSION['EmpID']."')");
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
	}elseif (isset($_POST['step_required']))
	{
		$mystep=mysqli_query($con,"SELECT * FROM tbl_deployment_history WHERE Emp_ID='".$_SESSION['EmpID']."' ORDER BY Date_assignment Desc LIMIT 1");
		$rowstep=mysqli_fetch_assoc($mystep);
		echo $rowstep['No_of_years'];
		mysqli_query($con,"INSERT INTO tbl_step_increment VALUES(NULL,'".date("Y-m-d")."','".$rowstep['StepNo']."','".$rowstep['No_of_years']."','".$_SESSION['EmpID']."')");
		 if(mysqli_affected_rows($con)==1)
	   {
		   ?>
			<script type="text/javascript">
					$(document).ready(function(){						
							$('#evaluation').modal({
								show: 'true'
							}); 				
						});
				</script>				
									 
			<?php 
	   }
	}
	?>
	
	
	
 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>NOTICE OF STEP INCREMENT</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="font-size:25px;">
						<?php
						$query=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_SESSION['EmpID']."' AND RequiredYear='".$_SESSION['year']."'");
						if (mysqli_num_rows($query)==3)
						{
							echo '<form action="" Method="POST" enctype="multipart/form-data"><input type="submit" name="step_required" class="btn btn-primary" style="float:right;" value="SUBMIT FOR EVALUATION"></form>';
						}
						?>
                          <p>Attach the following requirement for STEP INCREMENT</p>
						  <li>Payslip for 2 consecutive months    <a href="#payslip" data-toggle="modal" title="Attach file"><i class="fa fa-cloud-upload fa-fw"></i></a></li>
						  <li>Latest Appointment <a href="#Appointment" data-toggle="modal" title="Attach file" ><i class="fa fa-cloud-upload fa-fw"></i></a></li>
						  <li>Updated Service Record <a href="#service" data-toggle="modal" title="Attach file" ><i class="fa fa-cloud-upload fa-fw"></i></a></li>
                           <hr/>
						   <div class="col-lg-4">
                           <?php
							$querypayslip=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_SESSION['EmpID']."' AND RequiredDocument='PAYSLIP' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
							$queryslip=mysqli_fetch_assoc($querypayslip);
							 if(mysqli_num_rows($querypayslip)==1)
							 {								 
								echo '<h4>Payslip for 2 consecutive months</h4>';
								echo '<iframe src="'.$queryslip['DocLocation'].'" frameborder="0" style="width:100%;height:450px;"></iframe>';
							 }
							?>						   
                        </div>
						 <div class="col-lg-4">
						 <?php
							$queryappointment=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_SESSION['EmpID']."' AND RequiredDocument='APPOINTMENT' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
							$queryapoint=mysqli_fetch_assoc($queryappointment);
							 if(mysqli_num_rows($queryappointment)==1)
							 {								 
								echo '<h4>Latest Appointment</h4>';
								echo '<img src="'.$queryapoint['DocLocation'].'"  style="width:100%;height:450px;">';
							 }
							?>		
                        </div>
						 <div class="col-lg-4">
						 <?php
							$queryappointment=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_SESSION['EmpID']."' AND RequiredDocument='SERVICE RECORD' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
							$queryapoint=mysqli_fetch_assoc($queryappointment);
							 if(mysqli_num_rows($queryappointment)==1)
							 {								 
								echo '<h4>Updated Service Record</h4>';
								echo '<img src="'.$queryapoint['DocLocation'].'"  style="width:100%;height:450px;">';
							 }
							?>		
                        </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
          
   
              <!-- Modal -->
	 <div class="modal fade" id="payslip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Upload Payslip for 2 consecutive months in PDF format</h4>
			</div>
			 <form action="" Method="POST" enctype="multipart/form-data">
				<input type="hidden" id="filedata" name="filename" required>
				<input type="hidden" id="location" value="<?php echo $_SESSION['pathlocation']; ?>"required>
			<div class="modal-body"><center>
			    <div id="container">
				   <span id="pickfiles" style="cursor:pointer;"><button class="btn btn-success">Choose File to upload</button></span>
				</div>
				<div id="filelist">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div></center><hr/>
			<iframe src="" width="100%" height="450" frameborder="0" id="link"></iframe>
		   	</div>
           <div class="modal-footer">
		     <input type="submit" name="savepayslip" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			</div>	
			</form>
	</div></div>
	</div>
 
        <!-- Modal -->
	 <div class="modal fade" id="Appointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Latest Appointment </h4>
			</div>
			 
			 <form action="" Method="POST" enctype="multipart/form-data">
				
			<div class="modal-body"><center>
			     
				   <input type="file" name="appointment" onchange="loadappoint(event)" accept=".jpg,.jpep,.png,.JPG,.JPEG,.PNG"><hr/>
				  <img src="" style="width:100%;height:450px;" id="apoint">
		   	</div>
           <div class="modal-footer">
		     <input type="submit" name="saveappointment" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			</div>	
			</form>

	</div></div>
	</div>
 
 
        <!-- Modal -->
	 <div class="modal fade" id="service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Updated Service Record </h4>
			</div>
			 
			 <form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body"><center>
			  
			   <input type="file" name="service_record" onchange="loadFile(event)" accept=".jpg,.jpep,.png,.JPG,.JPEG,.PNG"><hr/>
			    <img  style="width:100%;height:450px;" id="sr">
			   </center>
		   	</div>
           <div class="modal-footer">
		     <input type="submit" name="saveservicerecord" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal">Close</button>
			</div>	
			</form>

	</div></div>
	</div>
 
 
 
              <!-- Modal -->
	 <div class="modal fade" id="evaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			</div>
			 
			<div class="modal-body">
			<img src="logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Submitted!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="./" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
 