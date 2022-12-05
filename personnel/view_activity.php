<?php
date_default_timezone_set("Asia/Manila");
$result=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$_GET['code']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
$_SESSION['TrainingCode']=$_GET['code'];

	
if (isset($_POST['attendance']))
{

	
	$record=mysqli_query($con,"SELECT * FROM tblseminar_attendance WHERE datestart='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."'");
	if (mysqli_num_rows($record)==0)
	{
		if ($_POST['Status']=='Morning Login')
		{
			mysqli_query($con,"INSERT INTO tblseminar_attendance VALUES(NULL,'".date("Y-m-d")."','".date("H:i:s")."','-','-','-','".$_GET['code']."','".$_SESSION['EmpID']."','-')");
		}elseif ($_POST['Status']=='Morning Logout')
		{
			mysqli_query($con,"INSERT INTO tblseminar_attendance VALUES(NULL,'".date("Y-m-d")."','','".date("H:i:s")."','','','".$_GET['code']."','".$_SESSION['EmpID']."','-')");
		}elseif ($_POST['Status']=='Afternoon Login')
		{
			mysqli_query($con,"INSERT INTO tblseminar_attendance VALUES(NULL,'".date("Y-m-d")."','','','".date("H:i:s")."','','".$_GET['code']."','".$_SESSION['EmpID']."','-')");
		}elseif ($_POST['Status']=='Afternoon Logout')
		{
			mysqli_query($con,"INSERT INTO tblseminar_attendance VALUES(NULL,'".date("Y-m-d")."','','','','".date("H:i:s")."','".$_GET['code']."','".$_SESSION['EmpID']."','-')");
		}
	}else{
		if ($_POST['Status']=='Morning Logout')
		{
		mysqli_query($con,"UPDATE tblseminar_attendance SET MorningOUT ='".date("H:i:s")."' WHERE datestart='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."' AND TrainingCode='".$_SESSION['TrainingCode']."'");	
		}elseif ($_POST['Status']=='Afternoon Login')
		{
		mysqli_query($con,"UPDATE tblseminar_attendance SET AfternoonIN ='".date("H:i:s")."' WHERE datestart='".date("Y-m-d")."' AND Emp_ID='".$_SESSION['EmpID']."' AND TrainingCode='".$_SESSION['TrainingCode']."'");	
		}elseif ($_POST['Status']=='Afternoon Logout')
		{
		mysqli_query($con,"UPDATE tblseminar_attendance SET AfternoonAOUT = '".date("H:i:s")."' WHERE datestart='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."' AND TrainingCode='".$_SESSION['TrainingCode']."'");	
		}
	}
}
?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   
					   <h4>Training Title:<h4/> <h4><?php echo $row['Title_of_training'];?></h4>
										
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						if ($row['Certificate']<>'-')
						{
						echo '<a href="print_certificate.php?certificate='.urlencode(base64_encode($_SESSION['EmpID'])).'" target="_blank" class="btn btn-primary">Certificate of Participation</a>	
						<a href="recognition.php?certificate='.urlencode(base64_encode($_SESSION['EmpID'])).'" class="btn btn-info" target="_blank">Certificate of Recognition</a>';
						}	
							?>						
						<a href="https://teams.microsoft.com/dl/launcher/launcher.html?url=%2F_%23%2Fl%2Fmeetup-join%2F19%3Ameeting_ZDYxYTA5YjQtYjI3YS00MDliLTk3YWItMTg2Y2EwMmRkMTg4%40thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%253a%2522bcfbcf7e-9c7e-4a99-9a6d-4d1e9fa3e450%2522%252c%2522Oid%2522%253a%25226a1cf4ed-d32f-4d95-80ea-015e7d8cc526%2522%257d%26anon%3Dtrue&type=meetup-join&deeplinkId=823950bc-b9df-40bc-95a0-3e7f381b26be&directDl=true&msLaunch=true&enableMobilePage=true&suppressPrompt=true" class="btn btn-success" style="float:right;padding:4px;maring:14px;" target="_blank">JOIN SESSION</a>
						<a href="#newattendance" class="btn btn-primary" style="float:right;padding:4px;maring:14px;" data-toggle="modal">ATTENDANCE</a> 			
						 <hr/>
                           <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%" rowspan="2" style="text-align:center;">#</th>
												<th width="15%" rowspan="2" style="text-align:center;">DATE</th>
												<th width="35%" colspan="2" style="text-align:center;">MORNING SESSION</th>
												<th width="35%" colspan="2" style="text-align:center;">AFTERNOON SESSION</th>
												<th width="15%" rowspan="2" style="text-align:center;">REMARKS</th>
												<th width="15%" rowspan="2" style="text-align:center;">QATAME LINK</th>
											</tr>
										<tr>
											<th style="text-align:center;">IN</th>
											<th style="text-align:center;">OUT</th>
											<th style="text-align:center;">IN</th>
											<th style="text-align:center;">OUT</th>
										</tr>										
									</thead>
									<tbody>
									<?php
									$no=0;
									$mytime=mysqli_query($con,"SELECT * FROM tblseminar_attendance WHERE  Emp_ID='".$_SESSION['EmpID']."' AND TrainingCode='".$_SESSION['TrainingCode']."'");
									while ($rowtime=mysqli_fetch_array($mytime))
									{
										$no++;
										$remarks="";
										echo '<tr>
												<td>'.$no.'</td>
												<td style="text-align:center;">'.$rowtime['datestart'].'</td>
												<td style="text-align:center;">'.$rowtime['MorningIN'].'</td>
												<td style="text-align:center;">'.$rowtime['MorningOUT'].'</td>
												<td style="text-align:center;">'.$rowtime['AfternoonIN'].'</td>
												<td style="text-align:center;">'.$rowtime['AfternoonAOUT'].'</td>';
												if ($rowtime['AfternoonAOUT']<>"00:00:00")
												{
													$remark="Completed";	
													echo '<td style="text-align:center;">'.$remark.'</td>
													<td style="text-align:center;"><a href="'.$rowtime['Day'].'" target="_blank">DAY '.$no.'</a></td>';
												}else{
													echo '<td style="text-align:center;">Please Logout to view QATAME LINK</td>';	
												}
												
											 echo '</tr>';
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
	 <div class="modal fade" id="newattendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">Daily Attendance Record </h4>
		</div>
	<div class="modal-body">
	<form action="" Method="POST" enctype="multipart/form-data">
	<?php 
	
		
	
	echo '<label style="width:250px;height:250px;border:solid 1px black;float:right;padding:4px;margin:4px;font-size:25px;text-align:center;border-radius:.3em;">';
	echo date("l").'<br/>';
	echo date("F  d, Y").'<br/>';
	echo date("H:i:s").'<br/>';
	

		echo '</label>';
		
			if (date("H:i:s") >='04:30:00' AND date("H:i:s") <='10:30:00')
			{
				echo '<input type="hidden" name="Status" value="Morning Login">';
			echo '<button style="width:250px;height:250px;font-size:35px;border-radius:.3em;" name="attendance">MORNING LOGIN</button>';	
			}elseif (date("H:i:s") >='11:00:00' AND date("H:i:s") <='12:30:00'){
				echo '<input type="hidden" name="Status" value="Morning Logout">';
				echo '<button style="width:250px;height:250px;font-size:35px;border-radius:.3em;" name="attendance">LOGOUT</button>';	
			}elseif (date("H:i:s") >='12:31:00' AND date("H:i:s") <='14:31:00')
				{
				echo '<input type="hidden" name="Status" value="Afternoon Login">';
				 echo '<button style="width:250px;height:250px;font-size:35px;border-radius:.3em;" name="attendance">LOGIN</button>';		
			}else{
					echo '<input type="hidden" name="Status" value="Afternoon Logout">';
					echo '<button style="width:250px;height:250px;font-size:35px;border-radius:.3em;" name="attendance">LOGOUT</button>';	
				}
		
	
	?>
	</form>
   </div>
	</div></div>
</div>
  </div>
  