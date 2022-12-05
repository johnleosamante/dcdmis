<?php
$_SESSION['dist']=$_GET['c'];
$myDistrict=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code ='".$_SESSION['dist']."'ORDER BY District_code Asc")or die("Error destict data");
$data=mysqli_fetch_assoc($myDistrict);
$_SESSION['D_Name']=$data['District_Name'];
?>

           <div class="row">
                
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Retirees Information in (<?php echo $_SESSION['D_Name']; ?>)
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="6%">#</th>
                                        <th width="20%">Name</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="20%">Station</th>
                                        <th width="8%">Age</th>
                                        <th width="15%">Position</th>
                                        <th width="10%">Status</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_school.District_code='".$_SESSION['dist']."' AND tbl_station.Emp_age>='60' AND tbl_employee.Emp_Status <>'Retired' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'</td>
											<td>'.$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'].'</td>
											<td>'.$row['SchoolName'].'</td>
											<td style="text-align:center;">'.$row['Emp_age'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td style="text-align:center;">'.$row['Emp_Status'].'</td>
											<td><a href="view_information.php?id='.$row['Emp_ID'].'" data-toggle="modal" data-target="#myinfo" class="btn btn-info" title="View Retirees information"> <i class="fa fa-desktop fa-fw"></i></a>
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
                <!-- /.col-lg-12 -->
            </div>
            
<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:70%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
					}
		}
		th{
			text-align:center;
		}
   </style>


   <!-- Modal for Re-assign-->
    <div class="modal fade" id="myinfo" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="loginbox">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>