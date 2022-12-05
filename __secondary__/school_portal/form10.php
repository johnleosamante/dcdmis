

<style>
th,p{
	text-transform:uppercase;
}
</style>

			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
					<div class="panel-heading">
					<?php
					if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
						echo '<a href="print_SHSform10" style="float:right;" class="btn btn-primary" target="_blank">PRINT PREVIEW</a>';	
					}elseif ($_SESSION['Grade']>='7' AND $_SESSION['Grade']<='10'){
					echo '<a href="print_JHSform10" style="float:right;" class="btn btn-primary" target="_blank">PRINT PREVIEW</a>';
					}else{
						echo '<a href="print_ESform10" style="float:right;" class="btn btn-primary" target="_blank">PRINT PREVIEW</a>';
					}
					?>
					  
					
					
					<h3>Learners Information</h3>
					</div>
					<!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
						
					
					if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND first_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND second_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
				
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="250" height="260" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="250" height="260" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
					$_SESSION['SecCode']=$data['SecCode'];
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					$advice=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."'");	
					$adv=mysqli_fetch_assoc($advice);
					echo  '<p>Adviser: '.$adv['Emp_LName'].', '.$adv['Emp_FName'].'</p>';
					echo  '<p>Date: '.$data['Date_enrolled'].'</p>
					
							<hr/>';
					echo '<h4>Learner\'s Permanent Records</h4>';
					if ($data['Grade']==11 || $data['Grade']==12)
					{
					  require_once("senior_form10.php");	
					}elseif ($data['Grade']>=7 AND $data['Grade']<=10)
					{
					  require_once("junior_form10.php");
					}else{
					  require_once("elementary_form10.php");	
					}	
					?>
                            
                        </div>
						  
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            