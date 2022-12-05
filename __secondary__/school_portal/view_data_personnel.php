  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LIST OF PERSONNEL</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
	include("../../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
				{
				$id=$_GET[$key]=base64_decode(urldecode($data));	
				}
			
		?>		
         <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Employee Name</th>
                                        <th width="25%">Position</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_station.Emp_Position='".$id."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
									echo ' <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
                                        <td>'.$row['Job_description'].'</td>
                                        
                                    </tr>';
								}
								?>
                                </tbody>
								</table>
		</div>
		