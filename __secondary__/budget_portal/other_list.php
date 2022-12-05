			<style>
			 th{
				 text-align:center;
			 }
			</style>
			<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
									<a href="#myparticipant" style="float:right;" class="btn btn-success" data-toggle="modal">Add Speaker</a>
						          		<h4>List of Speakers</h4>
											<?php
											
											if (isset($_POST['training']))
											{
												$myfile = $_FILES['certificate']['name'];
												//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
												$temp = $_FILES['certificate']['tmp_name'];
												$type = $_FILES['certificate']['type'];
												$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
												$certicateimage='../logo/'.$_POST['SpkName'].'.'.$ext;
												move_uploaded_file($temp, $certicateimage);
												mysqli_query($con,"INSERT INTO tbl_speaker_seminar VALUES(NULL,'".$_POST['SpkName']."','".$_POST['office']."','".$_POST['ContactNo']."','".$_SESSION['Training_Code']."','".$certicateimage."')");
												if (mysqli_affected_rows($con)==1)
												{
												$Err = "Speaker Successfully Added";
														echo '<script type="text/javascript">
															$(document).ready(function(){						
															$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
															});</script>
															';	
													echo '<div class="alert alert-success">'.$Err.'</div>';
												}
												
											}elseif (isset($_POST['update_training']))
											{
												$myfile = $_FILES['certificate']['name'];
												//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
												$temp = $_FILES['certificate']['tmp_name'];
												$type = $_FILES['certificate']['type'];
												$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
												$certicateimage='../logo/new-'.$_SESSION['spkname'].'.'.$ext;
												mysqli_query($con,"UPDATE tbl_speaker_seminar SET SpkCertificate='".$certicateimage."' WHERE SpkCode='".$_SESSION['code']."' LIMIT 1");
												if (mysqli_affected_rows($con)==1)
												{
												$Err = "Speaker Successfully Added";
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
											
												
											<?php
											$result=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code ='".$_GET['code']."' LIMIT 1");
											$row=mysqli_fetch_assoc($result);
									   echo '<label>Title of Training: </label>'.$row['Title_of_training'].'<br/>
											<label>Date Covered: </label> From - '.$row['covered_from'].' To - '.$row['covered_to'].'<br/>
											<label>Venue: </label> '.$row['TVenue'].'<br/>
											<label>Conducted by: </label> '.$row['conducted_by'].'<hr/>';
											$_SESSION['Title_Training']=$row['Title_of_training'];
											$_SESSION['Training_Code']=$row['Training_Code'];
											?>
											<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="35%">NAME OF SPEAKER</th>
												<th width="20%">CURRENT OFFICE</th>
												<th width="20%">CONTACT #</th>
												<th width="7%"></th>
											</tr>
																			
									</thead>
									<tbody>
									<?php
									$no=0;
									$viewpspeaker=mysqli_query($con,"SELECT * FROM tbl_speaker_seminar  WHERE SpkSeminar='".$_GET['code']."'");
									while($viewrow=mysqli_fetch_array($viewpspeaker))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$viewrow['SpkName'].'</td>
												<td>'.$viewrow['SpkOffice'].'</td>
												<td>'.$viewrow['SpkContact'].'</td>
												<td>
													<a href="speaker_certificate.php?certificate='.urlencode(base64_encode($viewrow['SpkCode'])).'" target="_blank">Print</a>
													<a href="up_certificate.php?code='.urlencode(base64_encode($viewrow['SpkCode'])).'" data-toggle="modal" data-target="#mycertificate">Edit</a>
												</td>
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
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>				
	<script>
	var loadFile1 = function(event) {
    var output = document.getElementById('pic1');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>	

	
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myparticipant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>ADD NEW SPEAKER</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Speaker Name: </label>
		<input type="text" name="SpkName" class="form-control" placeholder="Enter Speaker Name" required>
		<label>Office: </label>
		<input type="text" class="form-control" placeholder="Enter Office" name="office" required>
		<label>Contact No: </label>
		<input type="text" class="form-control" placeholder="Enter Contact Number" name="ContactNo" required><hr/>
		 <input type="file" name="certificate" onchange="loadFile(event)" required>
		 <div class="modal-footer">
		  <img src="" style="width:100%;height:300px;padding:4px;margin:4px;" id="pic"><hr/>
		<input type="submit" name="training" Value="SUBMIT" class="btn btn-success">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
		
		
		
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mycertificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        			
		      </div>
		      </div>
			  </div></div>
		
		