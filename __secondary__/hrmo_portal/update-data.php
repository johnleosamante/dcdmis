          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Update Information</center></h3>
		 
        </div>
        <div class="modal-body">
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("Y-m-d H:i:s");
		$data=$_SESSION['code'];
		$encript_1=(($data*123456789*5678)/956783);
		$_SESSION['Emp_Code']=$_GET['id'];
		$resultEmp=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_ID ='".$_GET['id']."' LIMIT 1");
		$myrow=mysqli_fetch_assoc($resultEmp);					
		echo '<form action="view-payroll.php?link='.sha1("Pagadian City division Data management system").'&PayCode='.urlencode(base64_encode($encript_1)).'" Method="POST" enctype="multipart/form-data">
				
			 <label>Employee Name</label>
			 <input type="text" class="form-control"  value="'.$myrow['Emp_LName'].', '.$myrow['Emp_FName'].'" disabled>
			  <label>DBP Account Number</label>';
			  
			 echo '<input type="text" name="AccountNumber" value="'.$myrow['Emp_DBP_Account'].'" class="form-control"  required>';
			 
		     echo '<label>GSIS Deduction</label>					       
			<input type="text"  name="GSIS" class="form-control"   required >
            <label>Pag-ibig Deduction</label>					       
            <input type="text"  name="Pagibig" class="form-control"  required >
			<label>Philhealth</label>					       
            <input type="text" name="Philhealth" class="form-control"  required >
           <label>Gross Pay</label>					       
            <input type="text" name="GrossPay" class="form-control"   required ><hr/>
                                   
			<input type="submit" name="new_payroll" value="SAVE" class="btn btn-primary" >
			
        </form>';
		?>
		</div>
		


