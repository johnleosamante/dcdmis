<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1('learners information system');
$myuser=mysqli_query($con,"SELECT * FROM tbl_user INNER JOIN tbl_employee ON tbl_user.usercode = tbl_employee.Emp_ID ORDER BY tbl_employee.Emp_LName Asc");
	while ($userrow=mysqli_fetch_array($myuser))
		{
			$no=$userrow['Emp_LName'].', '.$userrow['Emp_FName'];
			$name=mb_strimwidth($no,0,20);
			echo '<a href="javascript:register_popup('."'$name'".', '."'$no'".');" class="list-group-item">
					<span class=" badge-danger badge-counter">
						<img src="'.$userrow['Picture'].'" style="width:20px;height:20px;border-radius:5em;">
					<label style="padding:4px;font-size:10px;">'.$userrow['Emp_LName'].', '.$userrow['Emp_FName'].'</label>
					';
					if ($userrow['Status']=='Offline')
					{
						echo '<label style="width:10px;height:10px;border-radius:100%;background:black;float:right;"></label>';	
					}else{
					echo '<label style="width:10px;height:10px;border-radius:100%;background:green;float:right;"></label>';	
						
					}
					echo '</span>
					</a></div>';
	
		}
?>
