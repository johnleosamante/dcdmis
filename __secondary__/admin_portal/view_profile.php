<?php
if (isset($_POST['update_district']))
{
	mysqli_query($con,"UPDATE tbl_school SET District_code='".$_POST['district']."' WHERE SchoolID='".$_GET['c']."' LIMIT 1");
	if(mysqli_affected_rows($con)==1)
	{
	$Err = "School Successfully Assign!!";
		echo '<script type="text/javascript">
			$(document).ready(function(){						
			$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
			});</script>';	
	echo '<div class="alert alert-success">'.$Err.'</div>';	
	}
}elseif (isset($_POST['update']))
 {
	 mysqli_query($con,"UPDATE tbl_school SET Incharg_ID='".$_POST['newprin']."' WHERE SchoolID='".$_SESSION['myID']."' LIMIT 1");
	 mysqli_query($con,"UPDATE tbl_station SET Emp_Station='".$_SESSION['myID']."' WHERE Emp_ID='".$_POST['newprin']."' LIMIT 1");
	 mysqli_query($con,"UPDATE tbl_user SET Station='".$_SESSION['myID']."' WHERE usercode='".$_POST['newprin']."' LIMIT 1");
	 
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
						 
						 	<?php
							
							  $record=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code WHERE SchoolID ='".$_GET['c']."'  ORDER BY SchoolName Asc") or die ("Profile School Error");
							  $row=mysqli_fetch_assoc($record);
							  echo '<h3 class="media-heading" style="padding:4px;margin:4px;"><i class="fa  fa-map-marker  fa-fw"></i>'.$row['SchoolName'].'- School ID:'.$_GET['c'].' ('.$row['District_Name'].')</h3> <p> 
									  <small class="text-muted" style="padding:4px;margin:4px;">'.$row['Address'].' </small>
									</p>';
							 $_SESSION['EmpID']=$row['Incharg_ID'];
							 $_SESSION['SchoolID']=$_GET['c'];
							$_SESSION['Category']=$row['School_Category'];
							  ?>
							  <a href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_school")); ?>" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">Back</a>
							  <?php
							  if ($_GET['c']<>'123131')
								{
									echo '<a href="#district" class="btn btn-primary" style="float:right;padding:4px;margin:4px;" data-toggle="modal"> Assign District</a>';
								}
							  ?>
							  
						<table style="padding:4px;margin:10px;">
						<?php
							$repre=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['EmpID']."'") or die("Table not found!!!");
							$data=mysqli_fetch_assoc($repre);
							if ($data['Picture']<>NULL)
							 {
								echo  '<img src="../../../pcdmis/images/'.$data['Picture'].'" style="width:150px;height:150px;padding:4px;margin:4px;" align="left">';
							 }else{
								 echo  '<img src="../../pcdmis/logo/user.png" style="width:150px;height:150px;padding:4px;margin:4px;" align="left">';
							 
							 }
							echo '<tr style="text-transform:uppercase;"><td>Employee ID #:</td><td style="color:blue;padding:4px;margin:4px;">'.$_SESSION['EmpID'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Name: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_LName'].', '.$data['Emp_FName'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Sex: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Sex'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Position: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Job_description'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Contact No.: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Cell_No'].'</font></td></tr>';
					
						?>
								</table> 
								<?php
									echo '<a href="assign.php?id='.urlencode(base64_encode($_GET['c'])).'" data-toggle="modal" data-target="#reassign" style="float:right;" class="btn btn-primary"> ASSIGN</a>';
								?>
                        </div>
                        <div class="row">
						 <div class="panel-body"><br/>
						<?php
						if ($_GET['c']<>'123131')
						{
						echo '<!-- DTS-heading -->
							   <div class="col-lg-3 col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tasks fa-5x"></i>
										</div>';
																	
										$section_Num=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE SchoolID='".$_GET['c']."'");
										
										echo '<div class="col-xs-9 text-right">
											<div class="huge">'.number_format(mysqli_num_rows($section_Num),0).'</div>
											<div>Transactions (DTS)</div>
										</div>
									</div>
								</div>';
							  
								$str=sha1("Pagadian City Division Data Management Information System");
								echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("school_Transactions")).'">						
									<div class="panel-footer">
										<span class="pull-left">View Details</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div><!-- DTS-Ending -->
						
						 <div class="col-lg-3 col-md-6"><!-- List of learner -->
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>';
								
								$register_Num=mysqli_query($con,"SELECT * FROM tbl_registration WHERE SchoolID='".$_GET['c']."' AND school_year ='".$_SESSION['year']."'");
					
                                echo '
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.number_format(mysqli_num_rows($register_Num),0).'</div>
                                    <div>List of Learner</div>
                                </div>
                            </div>
                        </div>
                      <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_learner")).'">
						   <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div><!-- List of learner -Ending -->
					
				
				
				 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>';
								
								$section_Num=mysqli_query($con,"SELECT * FROM tbl_section WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_section.School_Year='".$_SESSION['year']."'")or die("error data request");
					
                                echo '
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($section_Num).'</div>
                                    <div>School Form 4</div>
                                </div>
                            </div>
                        </div>
                      <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_section")).'">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>';
					
				if ($_SESSION['Category']=='Secondary')
						{
				echo '<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-desktop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">';
								
								
								$quali=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school WHERE SchoolID='".$_SESSION['SchoolID']."' AND QualSem='".$_SESSION['Sem']."'");
							
								  echo  '<div class="huge">'.mysqli_num_rows($quali).'</div>';
                                   
									echo '<div>Track/Strand</div>
                                </div>
                            </div>
                        </div>
                      
						
                             <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("track")).'">
                      
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>';
			}
					
			echo  '<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									<div>List of Personnel</div>
                                </div>
                            </div>
                        </div>
                     <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_personnel")).'">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>	
						
						';
						}else{
							echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                       <tr>
											<th style="text-align:center;width:5%;" >#</th>
											<th>Name</th>
											<th width="15%">Contact Number</th>
											<th width="25%">Position</th>
											<th width="15%">Birthdate</th>
											<th width="10%">Years in Service</th>
								       </tr>
								  </thead>
								  <tbody>';
								   $no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Active' AND tbl_station.Emp_Station ='123131' ORDER BY Emp_LName Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no++;
										$mySR=0;
										$myservice=mysqli_query($con,"SELECT * FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_deployment_history.position_assign = tbl_job.Job_code WHERE tbl_deployment_history.Emp_ID='".$row['Emp_ID']."'");
										while($rowinfo=mysqli_fetch_array($myservice))
										{
										$mySR=$mySR+$rowinfo['No_of_years'];	
										}
										
									    echo '<tr>
											<td style="text-align:center;" >'.$no.'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'</td>
											<td>'.$row['Emp_Cell_No'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td>'.$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'].'</td>
											<td style="text-align:center;">'.$mySR.'</th>
								       </tr>';
									}
								  echo '</tbody>
								  </table>
								  ';
						}
						
				  ?>
				
				
				
				
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                </div>
 <div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="reassign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  
	</div>
	</div>
</div>
  </div>
						
   <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="district" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">School Assign</h4>
				</div>
			<form action=""	Method="POST" enctype="multipart/form-data">							
			<div class="modal-body">
			
	<?php
		$rec=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID ='".$_GET['c']."'  ORDER BY SchoolName Asc") or die ("Profile School Error");
		$row1=mysqli_fetch_assoc($rec);
		echo '<h3 class="media-heading" style="padding:4px;margin:4px;"><i class="fa  fa-map-marker  fa-fw"></i>'.$row1['SchoolName'].'- School ID:'.$_GET['c'].'</h3> <p> 
		 <small class="text-muted" style="padding:4px;margin:4px;">'.$row1['Address'].' </small>
		</p>';
		$mydistrict=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code <>'D-115'  ORDER BY District_code Asc");
		echo '<label>SELECT DISTRICT:</label><select name="district" class="form-control">
		<option value="">--select--</option>';
		while($rowdistrict=mysqli_fetch_array($mydistrict))
		{
			echo '<option value="'.$rowdistrict['District_code'].'">'.$rowdistrict['District_Name'].'</option>';
		}
		echo '</select>';
	?>

	</div>
	<div class="modal-footer">
	<input type="submit" name="update_district" class="btn btn-success" value="SUBMIT">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
	</div>		
	</form>
	</div>
	</div>
</div>
  </div>
 

	