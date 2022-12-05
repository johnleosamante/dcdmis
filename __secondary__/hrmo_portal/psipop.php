<?php
session_start();
include("../vendor/jquery/function.php");
$querydata=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_GET['id']."' LIMIT 1");
$mydata=mysqli_fetch_assoc($querydata);
$result=mysqli_query($con,"SELECT * FROM psipop WHERE psipop.TIN='".$mydata['Emp_TIN']."' LIMIT 1");
$data=mysqli_fetch_assoc($result);
$_SESSION['myTIN']=$mydata['Emp_TIN'];
$_SESSION['EmpID']=$_GET['id'];
echo '  <div class="modal-header"><button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
 
		  <h4 class="modal-title"><center>NEW PSIPOP DATA</center></h4>
		   </div>
		   <form enctype="multipart/form-data" method="post" role="form" action="save_psipop.php?emp='.$_GET['id'].'">
		
        <div class="modal-body">
		
			<div class="form-group">
			<!--Begin-->	
				<div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Personal Information
                    </div>
                             <div class="panel-body" >
                            <dl class="dl-horizontal">
							<label>EMPLOYEE ID:</label>
							<input type="text" name="TIN" value="'.$_GET['id'].'" class="form-control" disabled>
							<input type="hidden" name="TIN" value="'.$mydata['Emp_TIN'].'" class="form-control">
							<label>ITEM NUMBER:</label>
							<input type="text" name="Item_Number" placeholder="ITEM NUMBER" class="form-control" value="'.$data['Item_Number'].'" required disabled>
							<label>AUTORIZED:</label>
							<input type="text" name="ASalary" placeholder="AUTHORIZED SALARY" class="form-control" value="'.$data['Autorized'].'" required disabled>
							<label>ACTUAL:</label>
							<input type="text" name="Actual" placeholder="ACTUAL SALARY" class="form-control" value="'.$data['Actual'].'" required disabled>
							<label>STEP:</label>
							<input type="text" name="Step" placeholder="STEP" class="form-control" value="'.$data['Step'].'" required disabled>
							<label>JOB STATUS:</label>
							<input type="text" name="JStatus" placeholder="JOB STATUS" class="form-control" value="'.$data['Job_status'].'" required disabled>
							</dl>
							</div>
                </div>

            </div>

  <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Continue Information
                    </div>
                             <div class="panel-body" >
                            <dl class="dl-horizontal">
							<label>CODE:</label>
							<input type="text" name="Code" placeholder="CODE" class="form-control" value="'.$data['Code'].'" required>
							<label>TYPE:</label>
							<input type="text" name="PType" placeholder="TYPE" class="form-control" value="'.$data['Type'].'" required>
							<label>LEVEL:</label>
							<input type="text" name="PLevel" placeholder="LEVEL" class="form-control" value="'.$data['Level'].'" required>
							<label>ATTRIBUTE:</label>
							<input type="text" name="PAttribute" placeholder="ATTRIBUTE" class="form-control" value="'.$data['Attribute'].'" required>
							<label>DATE PROMOTED:</label>
							<input type="date" name="DPromoted" placeholder="DATE PROMOTED" class="form-control" value="'.$data['Date_promoted'].'" required disabled>
							<label>ELEGIBILITY:</label>
							<input type="text" name="PElegibility" placeholder="ELEGIBILITY" class="form-control" value="'.$data['Elegibility'].'" required disabled>
							</dl>
							</div>
                </div>

            </div>

           	</div>
							
              
			  
                    </div>
					
					<input type="submit" class="btn btn-primary" name="save" value="SUBMIT" style="float:right;">';
					
					$data=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_GET['id']."' LIMIT 1")or die ("Error query data");
					$newinfo=mysqli_fetch_assoc($data);
					echo '<h4>PSIPOP INFORMATION OF <b>'.$newinfo['Emp_LName'].', '.$newinfo['Emp_FName'].'</b></h4>
					
					
                </div>
			</form>
			</div>
		</div>		
   </div>';
				
		?>  			
			<!--End-->	</div>
			
	
		
<!--End Supervisor-->