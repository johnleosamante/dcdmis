   <div class="row">
                <div class="col-lg-12">
                    <h3 ></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                      
						  ?> 
						
							<h4>Learner's Masterlist</h4>							 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_SESSION['sec_id']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
						 $data=mysqli_fetch_assoc($emp_info);
						
						
						   if ($data['Picture']<>NULL)
							 {
							 echo  '<img src="../../pcdmis//'.$data['Picture'].'" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 }else{
								 echo  '<img src="../../pcdmis//logo/user.png" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 
							 }
							echo '<p>Section Code: '.$_SESSION['sec_id'].'</p>';
						echo '<p>Section Name: '.$data['SecDesc'].'</p>';
						if ($data['Grade']=='Kinder')
							{	
							  echo '<p>Grade: '.$data['Grade'].'</p>';
										
							}else{
							   echo '<p>Grade: Grade '.$data['Grade'].'</p>';
											
								}
						echo '<p>Class Adviser: '.$data['Emp_LName'].', '.$data['Emp_FName'].'</p>';
						echo '<p>Position: '.$data['Job_description'].'</p>';
						echo  '<p>Room Location: '.$data['Room_location'].'</p><hr/>';
						
						?>
						
						
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="10%">LRN</th>
                                        <th width="14%">Last Name</th>
                                        <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                        <th width="10%">Gender</th>
                                        <th width="20%">Grade & Section</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
								{
									if ($_SESSION['Sem']=='First Semester')
									{
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.SecCode ='".$_SESSION['sec_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc ");
									}elseif($_SESSION['Sem']=='Second Semester')
									{
										$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.SecCode ='".$_SESSION['sec_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc ");
									
									}
								}else{
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND tbl_learners.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.SecCode ='".$_SESSION['sec_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc ");
								}	
								
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr>
											<td>'.$row['lrn'].'</td>
											<td>'.utf8_encode($row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName']).'</td>
											<td>'.$row['Gender'].'</td>';
											if ($row['Grade']=='Kinder')
											{
											echo '<td style="text-align:center;">'.$row['Grade'].' - '.$row['SecDesc'].'</td>';
												
											}else{
											echo '<td style="text-align:center;">Grade '.$row['Grade'].' - '.$row['SecDesc'].'</td>';
											}						
											echo '<td style="text-align:center;">
													
															
															<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['lrn'])).'&&Code='.urlencode(base64_encode($row['Grade'])).'&v='.urlencode(base64_encode("individual_info")).'" title="View information">VIEW</a>
																
																											
															
														
													</td>
                                        </tr>';
                                    
									}

											
									?>
                                </tbody>
                            </table>
                            
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               

<script>
 function delete_one(id)
 {
	if (confirm("Are you sure you want to delete?"))
	{
		window.location.href='delete_class_program.php?id='+id;
	}
	
 }
</script>

    <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="mysubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title"><center>New Schedule</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<?php
								
		echo '<label>Subject</label>
		<select name="subject" class="form-control">
		<option value="">--Select subject--</option>';
		if ($data['Grade']==11 || $data['Grade']==12)
		{
			$mysub=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand WHERE SubGradeLevel='".$data['Grade']."'");
			while($getdata=mysqli_fetch_array($mysub))
			{
				echo '<option value="'.$getdata['StrandsubCode'].'">'.$getdata['LearningAreas'].'</option>';
			}
		}elseif ($data['Grade']>=7 AND $data['Grade']<=10){
			
			$mysub=mysqli_query($con,"SELECT * FROM tbl_jhs_subject ORDER BY LearningAreas Asc");
			while($getdata=mysqli_fetch_array($mysub))
			{
				echo '<option value="'.$getdata['SubNo'].'">'.$getdata['LearningAreas'].'</option>';
			}
		}else{
			
			$mysub=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY LearningAreas Asc");
			while($getdata=mysqli_fetch_array($mysub))
			{
				echo '<option value="'.$getdata['SubNo'].'">'.$getdata['LearningAreas'].'</option>';
			}
		}
		echo '</select>
		<label>Time:</label>
		 <input type="text" name="sched_time" class="form-control" required>
		<label style="padding:4px;">Day</label><br/>
		 <input type="text" name="sched_day" class="form-control" required>
		<label style="padding:4px;">Teacher</label><br/>
		<select name="subTeacher" class="form-control">
		<option value="">--Select Teacher--</option>';
			$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."' AND tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
			while($row=mysqli_fetch_array($myinfo))
				{
					echo '<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</option>';		
				}
		echo '</select>
		 <input type="hidden" name="grade" value="'.$data['Grade'].'"class="form-control" required>
		<hr/>
		<input type="submit" name="new_schedule" value="Save" class="btn btn-primary">';
		?>
        </form>
		</div>
		

		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->


   <!-- Modal for view list of learners-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="updateschedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->


                 <!-- Modal -->
				  <div class="panel-body">
	 <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="margin-left:auto;margin-right:auto;width:40%; height:100%;margin-top:50px;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../../pcdmis/logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Save!</h3></center>
		   	</div>
           <div class="modal-footer">
		    <?php
			 echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&Code='.urlencode(base64_encode($_SESSION['sec_id'])).'&v='.urlencode(base64_encode("subject_by_section")).'" class="btn btn-success" style="float:right;">OK</a>';
			?>
		  </div>	

	</div></div>
	</div>
	</div>
     