<?php
session_start();
require("../vendor/jquery/function.php");
	$user=mysqli_query($con,"SELECT * FROM tbl_user INNER JOIN tbl_employee ON tbl_user.usercode = tbl_employee.Emp_ID WHERE tbl_employee.Emp_Status='Active' AND tbl_user.Current_Status='Online' ORDER BY Emp_LName Asc");
	 while($rowuser=mysqli_fetch_array($user))
		 {
		 echo '<table with="100%" class="table table-striped table-bordered table-hover">
				<tr>
					<td><img src="'.$rowuser['Picture'].'" style="border-radius:50%;height:15px;width:15px;">';
					if ($rowuser['Current_Status']=='Online')
					{
						echo '<div style="border-radius:50%;height:10px;width:10px;background:green;">';
					}else{
						echo '<div style="border-radius:50%;height:10px;width:10px;background:black;">';
					}
					echo '</td>
					<td style="cursor:pointer;margin:4px;padding:4px;text-transform:lowercase;">'.$rowuser['Emp_LName'].', '.$rowuser['Emp_FName'].'</td>
					
				</tr>
						
		</table>';
	}
?>