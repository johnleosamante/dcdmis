
	<style>
		th{
			text-align:center;
		}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<a href="#myLeave" class="btn btn-primary" data-toggle="modal">View Leave Applied</a>
													 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Date</th>
                                        <th width="20%">Legal Basis / Memo / Special Order</th>
                                        <th width="15%">Type of Leave Credits</th>
                                        <th width="15%">Number of Days</th>
                                        <th width="30%">Type of Service Rendered</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$sum=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_credits INNER JOIN tbl_leave ON tbl_leave_credits.Type_of_leave_credit=tbl_leave.LeaveCode WHERE tbl_leave_credits.Emp_ID='".$_GET['id']."'")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Leave_date'].'</td>
											<td>'.$row['Legal_basis'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Type_of_service_rendered'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits: '.$sum.'</h3>';
									?>
                                </tbody>
                            </table>		
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
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
	   width:80%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .newleave{
	   width:40%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.newleave{
							width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
								}
		}
		
   </style>




<!-- Modal for Applied Leave-->
  <div class="modal fade" id="myLeave" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="loginbox">

       <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
 		  <h4 class="modal-title"><center>Leave Applied Summary</center></h4>
		  
	
        </div>
			<div class="modal-body">
		
				<div class="form-group">
					<!--Begin-->	
					<div class="row">
					 <div class="col-lg-12">
                    
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" rowspan="2">#</th>
                                        <th width="10%" rowspan="2">Date of Application</th>
                                        <th width="20%" rowspan="2">Type of Leave Credits</th>
                                        <th width="10%" rowspan="2">With / With out Pay</th>
                                        <th width="10%" rowspan="2">Number of Days</th>
                                        <th width="20%" rowspan="2">Reason for Leave of Absent</th>
                                        <th width="20%" colspan="2">Inclusive Date</th>
										<th width="5%" rowspan="2">Status</th>
                                    </tr>
									<tr>
										<th>From</th>
										<th>To</th>
                                </thead>
                                <tbody>
								<?php
								$no=$sum=$sum1=$sum2=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_applied INNER JOIN tbl_leave ON tbl_leave_applied.Type_of_Leave=tbl_leave.LeaveCode WHERE tbl_leave_applied.Emp_ID='".$_SESSION['credit']."'")or die ("Credit Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
										if ($row['Leave_Status']=='With')
										{
										$sum2=$sum2+1;	
										}else{
											$sum1=$sum1+1;
										}
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Date_approved'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td>'.$row['Leave_Status'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Reason_for_leave_of_absent'].'</td>
											<td>'.$row['Date_From'].'</td>
											<td>'.$row['Date_To'].'</td>
											<td>'.$row['Status'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits Applied: '.$sum.'</h3>';
										echo '<h3>Total Without Pay: '.$sum1.'</h3>';
										echo '<h3>Total With Pay: '.$sum2.'</h3>';
									?>
                                </tbody>
                            </table>		
				
				
					<!--End-->	
					</div>
				</div>
			
			
				</div>
		    </div>
		</div>
	</div>
</div>

<!--End Supervisor-->

