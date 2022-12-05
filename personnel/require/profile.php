<?php
$_SESSION['lrn']=$_GET['lrn'];

				if (isset($_POST['changepass'])){
						if ($_POST['newpass']==$_POST['conpass'])
						{
							$pass=md5($_POST['newpass']);
							mysqli_query($con,"UPDATE tbl_student_user SET password='".$pass."' WHERE username='".$_SESSION['LRN']."' LIMIT 1");
							if(mysqli_affected_rows($con)==1)
							{
							?>
										<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
									</script>
							 <?php
							}
						}else{
							$Err="Password not match!";	
						  echo '<div class="panel-heading">
								<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
									
									});</script>
									';	
							echo '<div class="alert alert-success">'.$Err.'</div></div>';
						}
		}
		if (isset($_POST['modality']))
		{
			if ($_POST['type_of_modality']=='Online')
			{
			mysqli_query($con,"INSERT INTO tbl_learning_modality VALUES(NULL,'".$_POST['type_of_modality']."','".$_POST['type_of_gadget']."','".$_SESSION['LRN']."','".$_SESSION['year']."')");
			}else{
			mysqli_query($con,"INSERT INTO tbl_learning_modality VALUES(NULL,'".$_POST['type_of_modality']."','-','".$_SESSION['LRN']."','".$_SESSION['year']."')");	
			}
			if (mysqli_affected_rows($con)==1)
			{
				?>
					<script type="text/javascript">
					$(document).ready(function(){						
						$('#access').modal({
						show: 'true'
					}); 				
				});
			</script>
			<?php
			}
		
		}     
	


//Search Section
$mysection=mysqli_query($con,"SELECT * FROM tbl_section WHERE SecCode='".$_SESSION['CurrentCode']."' AND School_Year='".$_SESSION['year']."' AND Grade='".$_SESSION['Grade_Level']."' LIMIT 1");
$row=mysqli_fetch_assoc($mysection);
 if (isset($_POST['submit']))
 {
	mysqli_query($con,"UPDATE tbl_student SET Lname='".$_POST['LName']."',FName='".$_POST['FName']."',MName='".$_POST['MName']."',Birthdate='".$_POST['BDate']."',Gender='".$_POST['sex']."',ContactNo='".$_POST['CellNo']."',Father_Name='".$_POST['FatherName']."',Occupation='".$_POST['Fwork']."',Father_CellNo='".$_POST['FCellNo']."',Mother_LName='".$_POST['MotherName']."',MOccupation='".$_POST['Mwork']."',Mother_CellNo='".$_POST['MCellNo']."',4ps_Member='".$_POST['4ps']."',ELigibility='".$_POST['YLevelStatus']."',GWA='".$_POST['GWA']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1"); 
  if (mysqli_affected_rows($con)==1)
  {
	  ?>
	 

	<script type="text/javascript">
		$(document).ready(function(){						
			 $('#access').modal({
				show: 'true'
			}); 				
		});
		</script>
	 <?php
  }
 }
 
 $data=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$_GET['lrn']."' LIMIT 1");
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
$_SESSION['Eligibility']=$search['ELigibility'];
$_SESSION['GWA']=$search['GWA'];

?>
	
	 
	<?php
			if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
				{
					if ($_SESSION['Sem']=="First Semester")
						{			
						$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND first_semester.Grade='".$_SESSION['Grade_Level']."'ORDER BY tbl_student.Lname Asc");					
						}
										
					elseif ($_SESSION['Sem']=="Second Semester")
						{
							$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND second_semester.Grade='".$_SESSION['Grade_Level']."'ORDER BY tbl_student.Lname Asc");			
						}	
				}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
				}
					
			$data=mysqli_fetch_assoc($myinfo);
					
	
	?>
	<form action="" Method="POST" enctype="multipart/form-data">
		  <div class="row">
            <div class="col-lg-12">
			 <div class="panel panel-default">
				<div class="panel-heading">
				<?php
                     echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_GET['lrn'])).'&v='.urlencode(base64_encode("subject")).'" class="btn btn-danger">STUDYLOAD</a>
                      <a href="require/modality.php?id='.urlencode(base64_encode($_GET['lrn'])).'&&Code='.urlencode(base64_encode($_SESSION['Grade_Level'])).'" title="Modality" data-toggle="modal" data-target="#newassign" class="btn btn-warning">MODALITY</a>
                      <a href="require/reset_account.php?id='.urlencode(base64_encode($_GET['lrn'])).'&&Code='.urlencode(base64_encode($_SESSION['Grade_Level'])).'" data-toggle="modal" data-target="#newassign" title="Reset Password" class="btn btn-info">RESET ACCOUNT</a>
                      <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_GET['lrn'])).'&v='.urlencode(base64_encode("form9")).'" class="btn btn-primary">FORM 9</a>';
					  	if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
						{
						echo '<a href="print_SHSform10" class="btn btn-success" target="_blank">FORM 10</a>';
						}elseif ($_SESSION['Grade_Level']>=7 AND $_SESSION['Grade_Level']<=10)
						{
						echo '<a href="print_JHSform10" class="btn btn-success" target="_blank">FORM 10</a>';
						}else
							{
						echo '<a href="print_ESform10" class="btn btn-success" target="_blank">FORM 10</a>';
						}
			    ?>
                  </div>
				  <div class="panel-body">
			<?php
			  if ($data['Picture']==NULL)
					{
					echo '<img src="../../pcdmis/logo/user.png" width="100" height="100" align="right" style="border-radius:50%;">';
						
					}else{
					echo '<img src="../'.$data['Picture'].'" width="100" height="100" align="right" style="border-radius:50%;" title="'.$data['Picture'].'">';
					}
					//Adviser
				$myadviser=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['CurrentCode']."' LIMIT 1");	
				$rowadvic=mysqli_fetch_assoc($myadviser);
				$Middle=mb_strimwidth($rowadvic['Emp_MName'],0,1);
			?>
                <ul class="list-unstyled" style="text-transform:uppercase;">
							
							<li>
								<label style="width:150px;">Learner Name: </label><label> <?php echo $data['Lname'].', '.$data['FName'];?></label>
							</li>
							<li>
								<label style="width:150px;">Grade & Section:</label><label> <?php
									echo 'Grade - '.$_SESSION['Grade_Level'].' '. $data['SecDesc'].'</label>';
									
								?>
							</li>
							 <li>
								<label style="width:150px;">Class Adviser:</label><label><?php
									echo $rowadvic['Emp_FName'].' '.$Middle.'. '.$rowadvic['Emp_LName'].'</label>';
									
								?>
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
							if ($_SESSION['Sex']=='Male')
							{		
								echo '<option value="Male">Male</option>';
								echo '<option value="Female">Female</option>';
							}elseif ($_SESSION['Sex']=='Female')
							{
								echo '<option value="Female">Female</option>';
								echo '<option value="Male">Male</option>';
							}else{
								echo '<option value="">--Select--</option>';
								echo '<option value="Male">Male</option>';
								echo '<option value="Female">Female</option>';
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
                            <label style="width:30%;">Date of Enrolment:</label>
								<label style="width:30%;"><b>'.date("Y-m-d").'</b></label><br/>
							<label style="width:30%;">4Ps Member: </label>
								<label style="width:60%;">
									<select name="4ps" class="form-control">';
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
											     <option value="Yes">Yes</option>
												<option value="No">No</option>';
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
                            <label style="width:30%;">Level Status</label>
								<label style="width:60%;">
									<select name="YLevelStatus" class="form-control" required>
										<option value="'.$_SESSION['Eligibility'].'">'.$_SESSION['Eligibility'].'</option>';
										if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
										{
										echo '<option value="Completed">Completed</option>
										<option value="Incomplete">Incomplete</option>';	
										}else{
										echo '<option value="Promoted">Promoted</option>
										<option value="Conditional">Conditional</option>
										<option value="Retained">Retained</option>';
										}
								echo '</select>
								</label>
								 <label style="width:30%;">General Average</label>
								 <label style="width:60%;"><input type="text" name="GWA" class="form-control" placeholder="Enter General Average" value="'.$_SESSION['GWA'].'"required></label>
								
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
            </div>


        </div>';
		?>
		<div style="margin-bottom: 100px">
            <input type="submit" name="submit" value="SAVE" class="btn btn-primary" style="float:right;">
		   </div>
		 </div>
		</form>
		
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="newassign" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
		</div>		