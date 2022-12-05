 <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
					<tr>
						<th>IP</th>
						<th>NAME</th>
						<th>Date and Time</th>
						<th>Navigation</th>
					</tr>
                </thead>
				<tbody>
				<?php
				session_start();
				include("../../pcdmis/vendor/jquery/function.php");
				$result=mysqli_query($con,"SELECT * FROM tbl_system_logs INNER JOIN tbl_employee ON tbl_system_logs.Emp_ID = tbl_employee.Emp_ID WHERE tbl_system_logs.Time_Log LIKE '".date("Y-m-d")."%' ORDER BY tbl_system_logs.Time_Log Desc");
				while($rowre=mysqli_fetch_array($result))
				{
					echo '<tr>
							<td>'.$rowre['IPAddress'].'</td>
							<td>'.$rowre['Emp_LName'].', '.$rowre['Emp_FName'].'</td>
							<td>'.$rowre['Time_Log'].'</td>
							<td>'.$rowre['Status'].'</td>
						</tr>';
				}
				?>
				</tbody>
				</table>