<?php
date_default_timezone_set("Asia/Manila");
if (isset($_POST['search']))
{
$_SESSION['From']=$_POST['from'];	
$_SESSION['To']	=$_POST['to'];	

}else{
$_SESSION['From']=date('Y-m').'-01';	
$_SESSION['To']	=date('Y-m').'-31';

}

	
if (isset($_POST['attendance']))
{
	$time=0;
	$hour=date("H");
	$minute=date("i");
	$second=0;
	
  if ($hour==13){$time ='01:'.$minute.':'.$second;}elseif ($hour==14){$time ='02:'.$minute.':'.$second;}elseif ($hour==15){$time ='03:'.$minute.':'.$second;}
  elseif ($hour==16) {$time ='04:'.$minute.':'.$second;} elseif ($hour==17) {$time ='05:'.$minute.':'.$second;} elseif ($hour==18) {$time ='06:'.$minute.':'.$second;}
   elseif ($hour==19) {$time ='07:'.$minute.':'.$second;} elseif ($hour==20) {$time ='08:'.$minute.':'.$second;}elseif ($hour==21) {$time ='09:'.$minute.':'.$second;}
   elseif ($hour==22) {$time ='10:'.$minute.':'.$second;}else{$time =$hour.':'.$minute.':'.$second;}	
   
	$record=mysqli_query($con,"SELECT * FROM tbl_dtr WHERE DTRDate='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."'");
	if (mysqli_num_rows($record)==0)
	{
		if ($_POST['Status']=='Morning Login')
		{
			mysqli_query($con,"INSERT INTO tbl_dtr VALUES(NULL,'".date("Y-m-d")."','".$time."','0','0','0','".$_SESSION['EmpID']."','".date("l")."')") or die ("Error Login");
		}elseif ($_POST['Status']=='Morning Logout')
		{
			mysqli_query($con,"INSERT INTO tbl_dtr VALUES(NULL,'".date("Y-m-d")."','0','".$time."','0','0','".$_SESSION['EmpID']."','".date("l")."')");
		}elseif ($_POST['Status']=='Afternoon Login')
		{
			mysqli_query($con,"INSERT INTO tbl_dtr VALUES(NULL,'".date("Y-m-d")."','0','0','".$time."','0','".$_SESSION['EmpID']."','".date("l")."')");
		}elseif ($_POST['Status']=='Afternoon Logout')
		{
			mysqli_query($con,"INSERT INTO tbl_dtr VALUES(NULL,'".date("Y-m-d")."','0','0','0','".date("H:i:s")."','".$_SESSION['EmpID']."','".date("l")."')");
		}
	}else{
		if ($_POST['Status']=='Morning Logout')
		{
		mysqli_query($con,"UPDATE tbl_dtr SET TimeOUTAM ='".$time."' WHERE DTRDate='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."'");	
		}elseif ($_POST['Status']=='Afternoon Login')
		{
		mysqli_query($con,"UPDATE tbl_dtr SET TimeINPM ='".$time."' WHERE DTRDate='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."'");	
		}elseif ($_POST['Status']=='Afternoon Logout')
		{
		mysqli_query($con,"UPDATE tbl_dtr SET TimeOUTPM ='".$time."' WHERE DTRDate='".date("Y-m-d")."'  AND Emp_ID='".$_SESSION['EmpID']."'");	
		}
	}
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
				
				<div class="col-lg-12">
				
					
						          <div class="panel panel-default">
                                    <div class="panel-heading">
									<a href="print_dtr/?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942" class="btn btn-success" target="_blank" style="float:right;padding:10px;maring:10px;">Print Preview</a> &nbsp;&nbsp;
									<a href="#newattendance" class="btn btn-primary"  data-toggle="modal" style="float:right;padding:10px;maring:14px;">WFM ATTENDANCE</a> 			
									
									<h4>Daily Time Records</h4>				 
                                     </div>
								<div class="panel-body">									
									<!-- /.panel-heading -->
									<div class="col-lg-9">	
									
									
								<div class="panel-body" style="overflow-x:auto;">
									
									<table width="100%" class="table table-striped table-bordered table-hover" >
										<thead>
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="20%" rowspan="2" style="text-align:center;">Date </th>
												<th width="30%" colspan="2" style="text-align:center;">Morning Session</th>
												<th width="30%" colspan="2" style="text-align:center;">Afternoon Session</th>
												
											</tr>
											<tr>
												<th style="text-align:center;">In</th>
												<th style="text-align:center;">Out</th>
												<th style="text-align:center;">In</th>
												<th style="text-align:center;">Out</th>
											
											
											</tr>								
											</thead>
											<tbody>
												<?php
												
												$no=0;
												$myinfoDTR=mysqli_query($con,"SELECT * FROM tbl_dtr WHERE tbl_dtr.DTRDate BETWEEN '".$_SESSION['From']."' AND '".$_SESSION['To']."' AND tbl_dtr.Emp_ID='".$_SESSION['EmpID']."' ORDER BY tbl_dtr.DTRDate Desc");
											while($row=mysqli_fetch_array($myinfoDTR))
												{
													$no++;
													echo '<tr>
															<td style="text-align:center;">'.$no.'</td>
															<td style="text-align:center;">'.$row['DTRDate'].'</td>
															<td style="text-align:center;">'.$row['TimeINAM'].'</td>
															<td style="text-align:center;">'.$row['TimeOUTAM'].'</td>
															<td style="text-align:center;">'.$row['TimeINPM'].'</td>
															<td style="text-align:center;">'.$row['TimeOUTPM'].'</td>
														</tr>';
												}
													
										?>
									
								  </tbody>
								</table>		
							
								</div>
                        <!-- /.panel-body -->
                   
							</div>
					
					<div class="col-lg-3">	
					     <form action="" Method="POST">
									
							 From: <input type="date" name="from" class="form-control" required>
							 To: <input type="date" name="to" class="form-control" required><hr/>
										  
							<input type="submit" name="search" value="Search" class="btn btn-primary">		      
									
					</form>
						
					 </div>
					
                    <!-- /.panel -->
                </div>
              </div>
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
  			