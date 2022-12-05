<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
	
$data2=$_GET[$key]=base64_decode(urldecode($data));
	
}
$_SESSION['upsection']=$data2;
$result=mysqli_query($con,"SELECt * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$data2."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
echo '<div class="modal-header">
          
          <h3 class="modal-title"><center>Edit Section</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<label>Section Code</label>
		<input type="text" class="form-control" value="'.$data2.'" disabled>
		<label>Section Name</label>
		<input type="text" name="Section_name"  class="form-control" placeholder="Enter Section Name" value="'.$row['SecDesc'].'"required>
		<label>Section Year Level</label>
		<select name="Grade_Level"  class="form-control" required>';
		if ($row['Grade']=='Kinder')
		{
			echo '<option value="'.$row['Grade'].'">'.$row['Grade'].'</option>';
		}else{
			echo '<option value="'.$row['Grade'].'">Grade '.$row['Grade'].'</option>';
		}
			if ( $_SESSION['Category']=='Elementary')
			{
			echo '<option value="Kinder">Kinder</option>
				  
 				  <option value="1">Grade 1</option>
				  <option value="2">Grade 2</option>
				  <option value="3">Grade 3</option>
				  <option value="4">Grade 4</option>
				  <option value="5">Grade 5</option>
				  <option value="6">Grade 6</option>';
			}elseif ( $_SESSION['Category']=='Secondary')
			{
			echo '<option value="7">Grade 7</option>
				  <option value="8">Grade 8</option>
				  <option value="9">Grade 9</option>
 				  <option value="10">Grade 10</option>
				  <option value="11">Grade 11</option>
				  <option value="12">Grade 12</option>
				  ';
			}
			 
				  
		echo '</select>
		<label>Class Adviser</label>
		<select name="class_adviser"  class="form-control" required>
			<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].','.$row['Emp_FName'].'</option>';
			
			$adviser=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_station.Emp_Station = '".$_SESSION['school_id']."' AND tbl_employee.Emp_Status ='Active' ORDER BY tbl_employee.Emp_LName Asc");
			while($adrow=mysqli_fetch_array($adviser))
			{
				echo '<option value="'.$adrow['Emp_ID'].'">'.$adrow['Emp_LName'].','.$adrow['Emp_FName'].'</option>';
			}
			
		echo '</select>
		<label>Room Location</label>
		<input type="text" name="rm_location"  class="form-control" value="'.$row['Room_location'].'" required>
		
		</div>';
		
		?>
		 <div class="modal-footer">
		 <input type="submit" name="update_section" value="UPDATE" class="btn btn-primary">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
        </form>