<?php
if (isset($_POST['update']))
{
mysqli_query($con,"UPDATE tbl_employee SET Emp_Status='".$_POST['remark']."' WHERE Emp_ID='".$_SESSION['EmpID']."' LIMIT 1");
      if (mysqli_affected_rows($con)==1)
		{
			$Err = "Employee Status successfully updated!";
					echo '<script type="text/javascript">
						$(document).ready(function(){						
						$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
						});</script>';	
			echo '<div class="alert alert-success">'.$Err.'</div>';	
								
		}	
}elseif (isset($_POST['reset']))
{
$pass=$_POST['upass'];
mysqli_query($con,"UPDATE tbl_teacher_account SET Teacher_Password='".$pass."',Pass_status='Default' WHERE Teacher_TIN='".$_POST['uname']."' LIMIT 1");
      if (mysqli_affected_rows($con)==1)
		{
			$Err = "Account successfully updated!";
					echo '<script type="text/javascript">
						$(document).ready(function(){						
						$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
						});</script>';	
			echo '<div class="alert alert-success">'.$Err.'</div>';	
								
		}	
}
?>  
 <div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>	
 <div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<a href="#myviewstatus" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">View Profile Status</a>
						
					<h3>Personnel Masterlist</h3>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        
                                        <th width="15%">Last Name</th>
                                        <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                        <th width="5%">Extension</th>
                                        <th width="10%">Sex</th>
                                        <th width="15%">Position</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."' AND tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											
											<td>'.utf8_encode($row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td>'.$row['Emp_MName']).'</td>
											<td style="text-align:center;">'.$row['Emp_Extension'].'</td>
											<td style="text-align:center;">'.$row['Emp_Sex'].'</td>
											
											<td>'.$row['Job_description'].'</td>
											<td style="text-align:center;">
													
															<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("pds")).'" title="Personal Data Sheets" class="btn btn-info" style="padding:4px;margin:4px;">VIEW</a>
															<a href="newaccount.php?id='.urlencode(base64_encode($row['Emp_ID'])).'" data-toggle="modal" data-target="#my_account"  class="btn btn-warning" style="padding:4px;margin:4px;" title="Create/Reset Account">ACCOUNT</a>
															
															
													</td>
                                        </tr>';
                                    
									}						
									?>
                                </tbody>
                            </table>
                            
                        </div>
						
						
                        <!-- /.panel-body 
						-->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
				
				
				
<style>
   
		th{
			text-align:center;
		}
		 #myProgress {
  width: 100%;
 text-align:center;

 
}

#myBar {
  height: 30px;
  background-color: #4CAF50;
 
}
	
   </style>

   
   <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="myviewstatus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">-->
                   <div class="modal-dialog">
  
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          
          <h3 class="modal-title"><center>Personnel Profile Status</center></h3>
			</div>
			<div class="modal-body" style="overflow-x:auto;">
 		    <table width="100%" class="table table-striped table-bordered table-hover">
              <thead>
				<tr>
					<td style="width:5%;">#</td>
					<td style="width:15%;text-transform:uppercase;">Last Name</td>
					<td style="width:15%;text-transform:uppercase;">First Name</td>
					<td style="width:15%;text-transform:uppercase;">Middle Name</td>
					<td style="width:35%;text-transform:uppercase;">Percentage</td>
				</tr>
			 </thead>
			 <tbody>
			 <?php
			 $no=0;
			 $mytotal=$part=$Overall=$myoverall=0;
		$viewstate=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."' AND tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
		while($viewrow=mysqli_fetch_array($viewstate))
			{
					$no++;
				$total=$fam=$educ=$civil=$work=$volun=$learn=$other=$ref=0;
		
					$family_data=mysqli_query($con,"SELECT * FROM family_background WHERE family_background.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($family_data)<>0)
						{
						$fam=10;
					}
					$educ_data=mysqli_query($con,"SELECT * FROM educational_background WHERE educational_background.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($educ_data)<>0)
					{
						$educ=15;
					}
					$civil_data=mysqli_query($con,"SELECT * FROM civil_service WHERE civil_service.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($civil_data)<>0)
					{
						$civil=15;
					}
					$work_data=mysqli_query($con,"SELECT * FROM work_experience WHERE work_experience.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($work_data)<>0)
					{
						$work=5;
					}
					$voluntary_data=mysqli_query($con,"SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($voluntary_data)<>0)
					{
						$volun=5;
					}
					$learning_data=mysqli_query($con,"SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($learning_data)<>0)
					{
						$learn=20;
					}
					$other_data=mysqli_query($con,"SELECT * FROM other_information WHERE other_information.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($other_data)<>0)
					{
						$other=10;
					}
					$reference_data=mysqli_query($con,"SELECT * FROM reference WHERE reference.Emp_ID='".$viewrow['Emp_ID']."'");
					if (mysqli_num_rows($reference_data)<>0)
					{
						$ref=20;
					}	
				$total=$fam+$educ+$civil+$work+$volun+$learn+$other+$ref;	
					
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.utf8_encode($viewrow['Emp_LName'].'</td>
					<td>'.$viewrow['Emp_FName'].'</td>
					<td>'.$viewrow['Emp_MName']).'</td>
					<td><div id="myProgress">
						<div id="myBar" style="width:'.$total.'%;color:white;">'.$total.'%</div>
						</div></td>
					';
				$part=number_format($total/100,2);
				 $mytotal= $mytotal+$part;
				}	
				$Overall=$mytotal/mysqli_num_rows($viewstate);
				$myoverall=number_format($Overall*100,1);
				echo '<div id="myProgress"><label style="text-align:left;">Overall Status</label> 
						<div id="myBar" style="width:'.$myoverall.'%;color:white;">'.$myoverall.'%</div>
						</div><br/>';
				mysqli_query($con,"UPDATE tbl_school SET Status='".$myoverall."' WHERE SchoolID='".$_SESSION['school_id']."' LIMIT 1");		
			?>
			 </tbody>
		   </table>
		
		      </div>
			 	<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			  </div>
			  </div>
			  </div>
			  </div>
			  
<!-- Ending Modal for re-assign-->
   
   

    <div class="modal fade" id="my_profile_data" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="deploy">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>

<!-- Modal -->

   <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="reassign" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                   <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="my_account" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                   <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>

<!-- Modal -->
   
    <!-- Modal for Re-assign-->
	<div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="mypsipop" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                   <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->


