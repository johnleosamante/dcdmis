<?php
if (isset($_POST['submit']))
{
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
}
mysqli_query($con,"UPDATE tbl_student SET Lname='".$_POST['LName']."',FName='".$_POST['FName']."',MName='".$_POST['MName']."',Birthdate='".$_POST['BDate']."',Gender='".$_POST['sex']."',ContactNo='".$_POST['CellNo']."',Father_Name='".$_POST['FatherName']."',Occupation='".$_POST['Fwork']."',Father_CellNo='".$_POST['FCellNo']."',Mother_LName='".$_POST['MotherName']."',MOccupation='".$_POST['Mwork']."',Mother_CellNo='".$_POST['MCellNo']."',4ps_Member='".$_POST['4ps']."',GWA='".$_POST['GWA']."' WHERE lrn='".$_SESSION['current_lrn']."' LIMIT 1");
?>
<script type="text/javascript">
					$(document).ready(function(){						
						$('#enroled').modal({
						show: 'true'
					}); 				
				});
			</script>
<?php
}

$data=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$_SESSION['current_lrn']."' LIMIT 1");
$search=mysqli_fetch_assoc($data);
$_SESSION['LName']=$search['Lname'];
$_SESSION['FName']=$search['FName'];
$_SESSION['MName']=$search['MName'];
$_SESSION['BDate']=$search['Birthdate'];
$_SESSION['Sex']=$search['Gender'];
$_SESSION['Contact']=$search['ContactNo'];
$_SESSION['FatherName']=$search['Father_Name'];
$_SESSION['Fwork']=$search['Occupation'];
$_SESSION['FCellNo']=$search['Father_CellNo'];
$_SESSION['MotherName']=$search['Mother_LName'];
$_SESSION['MWork']=$search['MOccupation'];
$_SESSION['MCellNo']=$search['Mother_CellNo'];
$_SESSION['4ps']=$search['4ps_Member'];
$_SESSION['GWA']=$search['GWA'];

?>

		 <div class="wizard" style="margin-bottom: 50px;">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" >
                    <a aria-controls="step1" role="tab" title="Select type" href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_data")); ?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="">
                    <a aria-controls="step2" role="tab" title="Search Learner"  href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_learner")); ?>" style="cursor:pointer;"
                         >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                    </a>
                </li>
                <li role="presentation" class="">
                    <a   aria-controls="complete" role="tab" title="Educational History" href=""
                                                 >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="active">
                    <a   aria-controls="step3" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
	
	<form action="" Method="POST" enctype="multipart/form-data">
		 <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
							<li>
								<b> Step 1: Grade & Section: <?php
									echo 'Grade - '.$_SESSION['Grade_Level'].' '. $_SESSION['SecName'].'<br/>';
									
								?></b>
							</li>
							<li>
								<b>Step 2:Learner Name:  <?php echo $search['Lname'].', '.$search['FName'].' '.$search['MName'];?></b>
							</li>
							<li>
								<b>Step 3: Date of enrolment: <?php echo date("F d,Y");	?></b>
							</li>
							 <li>
								<b>Step 4: Complete enrolment</b>
							</li>
						</ul>
					</div>
				</div>		
			<?php
	echo '<div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Learner
                    </div>
                       <div class="panel-body">
                         <label style="width:30%;">Last Name:</label>
						 <label style="width:60%;"><input type="text" name="LName" class="form-control" value="'.$_SESSION['LName'].'"></label>
                         <label style="width:30%;">First Name:</label>
						 <label style="width:60%;"><input type="text" name="FName" class="form-control" value="'.$_SESSION['FName'].'"></label>
                         <label style="width:30%;">Middle Name:</label>
						 <label style="width:60%;"><input type="text" name="MName" class="form-control" value="'.$_SESSION['MName'].'"></label>
                         <label style="width:30%;">Birthdate:</label>
						 <label style="width:60%;"><input type="date" name="BDate" class="form-control" value="'.$_SESSION['BDate'].'"></label>
                         <label style="width:30%;">Sex:</label>
						 <label style="width:60%;">
							<select name="sex" class="form-control" >';
							if ($search['Gender']=='Male')
							{		
								echo '<option value="Male">Male</option>';
								echo '<option value="Female">Female</option>';
							}elseif ($search['Gender']=='Female')
							{
								echo '<option value="Female">Female</option>';
								echo '<option value="Male">Male</option>';
							}else{
								echo '<option value="">--Select--</option>';
								echo '<option value="Female">Female</option>';
								echo '<option value="Male">Male</option>';
							}
						   echo '</select>
						 </label>
						<label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="CellNo" class="form-control" value="'.$_SESSION['Contact'].'"></label>
                        
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
								<label style="width:30%;"><b>'.date("Y-m-d").'</b></label><br/>
							<label style="width:30%;">4Ps Member</label>
								<label style="width:60%;">
									<select name="4ps" class="form-control" required>';
										if ($_SESSION['4ps']=='Yes' || $_SESSION['4ps']=='YES')
										{
										  echo '<option value="Yes">Yes</option>
												<option value="No">No</option>';
										}elseif ($_SESSION['4ps']=='NO' || $_SESSION['4ps']=='No')
										{
										  echo '<option value="No">No</option>
												<option value="Yes">Yes</option>';
										}else{
											echo '<option value="">--Select--</option>
											     <option value="No">No</option>
												<option value="Yes">Yes</option>';
										}
							echo '</select>
								</label>
							<label style="width:30%;">Year Level</label>
								<label style="width:60%;">
									<select name="YLevel" class="form-control" required>';
									  if ($_SESSION['Grade_Level']=='Kinder')
									  {
										  echo '<option value="'.$_SESSION['Grade_Level'].'">'.$_SESSION['Grade_Level'].'</option>';
									  
									  }else{
									  echo '<option value="'.$_SESSION['Grade_Level'].'">Grade '.$_SESSION['Grade_Level'].'</option>';
									  }
							   echo '</select>
								</label>	
                 
								 <label style="width:30%;">General Average</label>
								 <label style="width:60%;"><input type="text" name="GWA" class="form-control" value="'.$_SESSION['GWA'].'" required></label>';
								 if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
										{
								 echo '<label style="width:30%;">Strand/Track</label>
								<label style="width:60%;">
									<select name="SpCode" class="form-control" required>
										<option value="">--select--</option>';
										$myspcode=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode=tbl_qualification.SpCode WHERE tbl_qualification_by_school.SchoolID='".$_SESSION['SchoolID']."' AND tbl_qualification.Grade='".$_SESSION['Grade_Level']."'");
										while($rowspcode=mysqli_fetch_array($myspcode))
										{
										echo '<option value="'.$rowspcode['SpCode'].'">'.$rowspcode['Description'].'</option>';
										}
										echo '</select>
										</label>';
										}
						echo '</dl>
					
              
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
						 <label style="width:60%;"><input type="text" name="FatherName" class="form-control" value="'.$_SESSION['FatherName'].'"></label>
                         <label style="width:30%;">Occupation:</label>
						 <label style="width:60%;"><input type="text" name="Fwork" class="form-control" value="'.$_SESSION['Fwork'].'"></label>
                         <label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="FCellNo" class="form-control" value="'.$_SESSION['FCellNo'].'"></label>
                        
                        
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
						 <label style="width:60%;"><input type="text" name="MotherName" class="form-control" value="'.$_SESSION['MotherName'].'"></label>
                         <label style="width:30%;">Occupation:</label>
						 <label style="width:60%;"><input type="text" name="Mwork" class="form-control" value="'.$_SESSION['MWork'].'"></label>
                         <label style="width:30%;">Contact #:</label>
						 <label style="width:60%;"><input type="text" name="MCellNo" class="form-control" value="'.$_SESSION['MCellNo'].'"></label>
                        
                        
						</div>
                </div>

            </div>


        </div>';
		?>
		<div style="margin-bottom: 100px">
            <input type="submit" name="submit" value="SAVE" class="btn btn-primary" style="float:right;">
		   </div>
		
		</form>
		
		
		
		
	          <!-- Modal -->
	 <div class="modal fade" id="enroled" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			</div>
			 
			<div class="modal-body">
			<img src="logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Submitted!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=Y2xhc3NfYWR2aXNvcnk%3D" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>