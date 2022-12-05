<?php
$_SESSION['assessment']=$_GET['Code'];
$result=mysqli_query($con,"SELECT * FROM tbl_assessment_type_of_exam WHERE ExamCode='".$_GET['Code']."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($result);
$_SESSION['CurrentExam']=$rowdata['Exam_Name'];
//Assessment Status
$rat=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_status LIMIT 1");
$rowstatus=mysqli_fetch_assoc($rat);
$_SESSION['rat_status']=$rowstatus['Exam_Status'];
?>
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>
   <div class="col-lg-12">
                    <h2></h2>
                </div>
          <div class="col-lg-12">
          
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
						<h4>BUREAU OF EDUCATION ASSESSMENT > PAGADIAN CITY DIVISION > <?php echo $_SESSION['CurrentExam']; ?> > LIST OF PARTICIPANTS</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>LAST NAME</th>
                                        <th>FIRST NAME</th>
                                        <th>MIDDLE NAME</th>
                                        <th>SEX</th>
                                        <th style="text-align:center;">YEAR LEVEL</th>
                                        <th  style="text-align:center;">SECTION</th>
                                        <th style="text-align:center;">ADVISER</th>
                                        <th  style="text-align:center;">CONTACT #</th>
                                        <th  width="5%" style="text-align:center;"></th>
                                                                              
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID = tbl_school.SchoolID INNER JOIN tbl_learners ON tbl_assessment_rat.LRN=tbl_learners.lrn INNER JOIN tbl_section ON tbl_learners.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE  tbl_assessment_rat.School_Year='".$_SESSION['year']."' AND tbl_assessment_rat.Exam_Code='".$_SESSION['assessment']."' AND tbl_assessment_rat.SchoolID='".$_SESSION['school_id']."'ORDER BY tbl_student.Lname Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName'].'</td>
											<td>'.$row['Gender'].'</td>
											
											<td style="text-align:center;">Grade '.$row['YLevel'].'</td>
											<td>'.$row['SecDesc'].'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
											<td>'.$row['ContactNo'].'</td>
											
											<td>
											<a href="test_paper.php?/13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&SchoolName='.urlencode(base64_encode($row['SchoolName'])).'&YLevel='.urlencode(base64_encode($row['YLevel'])).'&code='.urlencode(base64_encode($row['lrn'])).'" target="_blank">VIEW</a>			
										
											</td>
                                        </tr>';
                                    
									}		
								?>
                                </tbody>
								</table>
                   
						 
                        </div>
                        <!-- /.panel-body -->
                    </div>
        </div>
                    <!-- /.panel -->
            
         