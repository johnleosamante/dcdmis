<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$_SESSION['Requestedby']	= $_GET['code'];	
	
				
?>
	<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Locator's Information</h4>
			</div>
			<div class="modal-body">
			<div class="row">
			<div class="col-lg-8">
			<h4>Locator's History</h4>
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Employee Name</th>
                        <th width="14%">Time OUT</th>
                        <th width="14%">Time IN</th>
                        <th width="14%">Remarks</th>
                    </tr>
                </thead>
                    <tbody>
						<?php
						$no=0;
						$mylog=mysqli_query($con,"SELECT * FROM tbl_locator_passslip_logs INNER JOIN tbl_employee ON tbl_locator_passslip_logs.Emp_ID = tbl_employee.Emp_ID WHERE tbl_locator_passslip_logs.LocatorID='".$_GET['code']."'");
						while($rowlog=mysqli_fetch_array($mylog))
						{
						   $no++;
						   echo '<tr>
									<td>'.$no.'</td>
									<td>'.$rowlog['Emp_LName'].', '.$rowlog['Emp_FName'].'</td>
									<td>'.$rowlog['TimeOUT'].'</td>
									<td>'.$rowlog['TimeIN'].'</td>
									<td>'.$rowlog['RequestStatus'].'</td>
								</tr>';
						}
						?>						
                    </tbody>
			</table>
								
			</div>
			<div class="col-lg-4">
			<?php
			
			$vehicle=mysqli_query($con,"SELECT * FROM tbl_locator_passslip INNER JOIN tbl_employee ON tbl_locator_passslip.Emp_ID =tbl_employee.Emp_ID WHERE tbl_locator_passslip.LocatorNo='".$_GET['code']."' LIMIT 1") or die("Table Error");
			 $rowvh=mysqli_fetch_assoc($vehicle);
		   echo' <label>Category:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Category'].'" style="text-transform:uppercase;"disabled>
			   <label>Date Out:</label>
			   <input type="text" class="form-control" value="'.$rowvh['dateout'].'" style="text-transform:uppercase;" disabled>
			   <label>Purpose:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Purpose'].'" disabled>
			    <label>Time to Travel:</label>
			   <input type="text" class="form-control" value="'.$rowvh['TimeLeaving'].'" disabled>
			   <label>Time to Return:</label>
			   <input type="text" class="form-control" value="'.$rowvh['TimeReturn'].'" disabled>
			   <label>Requestedby:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Emp_LName'].', '.$rowvh['Emp_FName'].'" disabled>
			   ';
			   ?>
		   	</div> 
			</div>	
			</div>	
           <div class="modal-footer">
		   <?php
		   if ($rowvh['RequestStatus']<>'Approved')
		   {
		   echo '<a href="confirmation.php?id=Declined" class="btn btn-danger">Declined</a>
		   <a href="confirmation.php?id=Approved" class="btn btn-success"> Approved</a>';
		   }
		   ?>
		   
		   <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload()">Close</button>
			
		 </div>	
		