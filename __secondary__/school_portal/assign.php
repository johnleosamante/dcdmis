  <script>
 function my_status(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtview").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","view_status.php?id="+str,false);
  xmlhttp.send();
}
 </script>
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>PERSONNEL INFOMATION</center></h3>
		
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
				{
				$id=$_GET[$key]=base64_decode(urldecode($data));
					
				}
					
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$id."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
					$_SESSION['EmpID']=$id;
					echo '<b>';
					echo '<img src="'.$data['Picture'].'" width="150" height="160" align="right">';
					echo '<p>Employee ID: '.$id.'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p><hr/>';
					echo '<form action="save_assignment.php" Method="POST" enctype="multipart/form-data">
						<label style="width:50%;float:left;">
							<label>Date Last Attended</label>
						<label  style="width:100%;padding:4px;">
							<input type="date" name="date_retired" class="form-control" required>
						</label>
						</label>
						<label style="width:50%;float:left;">
						<label>Remarks</label>
						<label style="width:100%;padding:4px;">
						<select name="remark" class="form-control" id="status" required onchange="my_status(this.value)">
							<option value="">--Select--</option>
							<option value="Retired">Retired</option>
							<option value="Resigned">Resigned</option>
							<option value="Transfer">Transfer</option>
							
						</select>
						</label>
						
						</label>
						 <div id="txtview"></div>
						<br/>
						
						<label style="width:100%;"><input type="submit" name="update" value="SUBMIT" class="btn btn-primary"></label></form>
					';
					
					?>
					</form>
		</div>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		