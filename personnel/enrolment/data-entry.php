

		<?php
		
        echo '<h1 class="page-header">Enrollment Form for School Year '.$_SESSION['sy'].'</h1>';
				
		if (isset($_POST['save']))
		{
	     $query=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$_SESSION['current_lrn']."' LIMIT 1");
		 if (mysqli_num_rows($query)==0)
		 {
			mysqli_query($con,"INSERT INTO tbl_student VALUES('".$_SESSION['current_lrn']."','".$_POST['LName']."','".$_POST['FName']."','".$_POST['MName']."','".$_POST['BDate']."','".$_POST['sex']."','".$_POST['CellNo']."','".$_POST['FatherName']."','".$_POST['FCellNo']."','".$_POST['Fwork']."','".$_POST['MotherName']."','".$_POST['MCellNo']."','".$_POST['Mwork']."','".$_POST['homeaddress']."','".$_POST['homeaddress']."','".$_POST['homeaddress']."','".$_POST['homeaddress']."','".$_POST['homeaddress']."','/../pcdmis/logo/user.png')");
		 }	
		if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
{
	if($_SESSION['Sem']=='First Semester')
	{
		$query=mysqli_query($con,"SELECT * FROM first_semester WHERE lrn='".$_SESSION['current_lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade='".$_SESSION['Grade_Level']."'");	
		if (mysqli_num_rows($query)==0)
		{
			mysqli_query($con,"INSERT INTO first_semester VALUES(NULL,'".$_SESSION['current_lrn']."','".$_POST['SpCode']."','".$_SESSION['CurrentCode']."','".$_SESSION['year']."','".date("Y-m-d")."','".$_SESSION['Grade_Level']."','No Status','".$_SESSION['SchoolID']."')");
		}else{
			mysqli_query($con,"UPDATE first_semester SET SpCode='".$_POST['SpCode']."',SecCode='".$_SESSION['CurrentCode']."' WHERE lrn='".$_SESSION['current_lrn']."' AND school_year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."'  AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");
			}
	}elseif($_SESSION['Sem']=='Second Semester')
	{
		$query=mysqli_query($con,"SELECT * FROM second_semester WHERE lrn='".$_SESSION['current_lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade='".$_SESSION['Grade_Level']."'");	
		if (mysqli_num_rows($query)==0)
		{
			mysqli_query($con,"INSERT INTO second_semester VALUES(NULL,'".$_SESSION['current_lrn']."','".$_POST['SpCode']."','".$_SESSION['CurrentCode']."','".$_SESSION['year']."','".date("Y-m-d")."','".$_SESSION['Grade_Level']."','No Status','".$_SESSION['SchoolID']."')");
		}else{
			mysqli_query($con,"UPDATE second_semester SET SpCode='".$_POST['SpCode']."',SecCode='".$_SESSION['CurrentCode']."' WHERE lrn='".$_SESSION['current_lrn']."' AND school_year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."'  AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");
			}
	
	}		
	
}else{
	$query=mysqli_query($con,"SELECT * FROM tbl_learners WHERE lrn='".$_SESSION['current_lrn']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade='".$_SESSION['Grade_Level']."'");	
		if (mysqli_num_rows($query)==0)
		{
			mysqli_query($con,"INSERT INTO tbl_learners VALUES(NULL,'".$_SESSION['current_lrn']."','".$_SESSION['CurrentCode']."','".$_SESSION['year']."','".date("Y-m-d")."','".$_SESSION['Grade_Level']."','No Status','".$_SESSION['SchoolID']."')");
		}else{
			mysqli_query($con,"UPDATE tbl_learners SET SecCode='".$_SESSION['CurrentCode']."' WHERE lrn='".$_SESSION['current_lrn']."' AND School_Year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."'  AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");
			}
	
}
$enroledquery=mysqli_query($con,"SELECT * FROM tbl_registration WHERE lrn='".$_SESSION['current_lrn']."'AND school_year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."' AND SchoolID='".$_SESSION['SchoolID']."'");
if (mysqli_num_rows($enroledquery)==0)
{
	mysqli_query($con,"INSERT INTO tbl_registration VALUES (NULL,'".$_SESSION['current_lrn']."','".$_SESSION['year']."','".date("Y-m-d")."','".$_SESSION['Grade_Level']."','Enroled','".$_SESSION['SchoolID']."','Promoted','".$_POST['GWA']."','')");
}else{
	$enroledquery=mysqli_query($con,"UPDATE tbl_registration SET Sem_Status='Enroled'  WHERE lrn='".$_SESSION['current_lrn']."'AND school_year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."' AND SchoolID='".$_SESSION['SchoolID']."'");

}
		}
		
		
		?>
               
                <!-- /.col-lg-12 -->
			<form action="" Method="POST" enctype="multipart/form-data">	
			<div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Learner
                    </div>
                       <div class="panel-body">
                         <label style="width:30%;">Last Name:</label>
						 <label style="width:60%;"><input type="text" name="LName" class="form-control" ></label>
                         <label style="width:30%;">First Name:</label>
						 <label style="width:60%;"><input type="text" name="FName" class="form-control" ></label>
                         <label style="width:30%;">Middle Name:</label>
						 <label style="width:60%;"><input type="text" name="MName" class="form-control"></label>
                         <label style="width:30%;">Birthdate:</label>
						 <label style="width:60%;"><input type="date" name="BDate" class="form-control"></label>
                         <label style="width:30%;">Sex:</label>
						 <label style="width:60%;">
							<select name="sex" class="form-control" >
							<option value="">--Select--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							
							</select>
						 </label>
						<label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="CellNo" class="form-control" ></label>
                        
						</div>
                </div>

            </div>
           <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Enrolment
                    </div>

                    
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <label style="width:30%;">Date of Enrolment</label>
								<label style="width:30%;"><?php echo date("F d, Y");?></label><br/>
							<label style="width:30%;">4Ps Member</label>
								<label style="width:60%;">
									<select name="4ps" class="form-control">
										<option value="">--Select--</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
										
									</select>
								</label>
							<label style="width:30%;">Year Level</label>
								<label style="width:60%;">
									<input type="text" name="YLevel" class="form-control" value="<?php echo $_SESSION['Grade_Level'];?>"required>
									 
								</label>	
                            
								 <label style="width:30%;">General Average</label>
								 <label style="width:60%;"><input type="text" name="GWA" class="form-control" placeholder="Enter General Average" required></label>
								 
								<?php
								if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
								{
									echo '<label style="width:30%;">Strand/Track</label>
									<label style="width:60%;"><select name="spCode" class="form-control">
									<option value="">--Select--</option>';
									$qualification=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode=tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['SchoolID']."'");
									while($rowqual=mysqli_fetch_array($qualification))
									{
									echo '<option value="'.$rowqual['SpCode'].'">'.$rowqual['Description'].'</option>';
										
									}
									echo '</select></label>';	
								}
								?>
						</dl>
					
              
                    </div>
                </div>
            </div>

        </div>
		<div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Parent Information
                    </div>
                       <div class="panel-body">
                         <label style="width:30%;">Father Name:</label>
						 <label style="width:60%;"><input type="text" name="FatherName" class="form-control" ></label>
                         <label style="width:30%;">Occupation:</label>
						 <label style="width:60%;"><input type="text" name="Fwork" class="form-control" ></label>
                         <label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="FCellNo" class="form-control"></label>
                        
                        
						</div>
                </div>

            </div>
			<div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Parent Information
                    </div>
                       <div class="panel-body">
                          <label style="width:30%;">Mother Name:</label>
						 <label style="width:60%;"><input type="text" name="MotherName" class="form-control" ></label>
                         <label style="width:30%;">Occupation:</label>
						 <label style="width:60%;"><input type="text" name="Mwork" class="form-control" ></label>
                         <label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="MCellNo" class="form-control" ></label>
                        <label style="width:30%;">Home Address:</label>
						 <label style="width:60%;"><textarea rows="3" name="homeaddress" class="form-control" ></textarea></label>
                        
						</div>
                </div>

            </div>


        </div>
		<input type="submit" name="save" value="SAVE" class="btn btn-primary">
        </div>
		
			
			