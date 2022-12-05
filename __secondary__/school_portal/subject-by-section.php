   <style>
   #header-holder{
	   margin-top: 70px;
	   margin-bottom:10px;
   }
   @media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 #header-holder{
						 margin-top: 120px;
						 margin-bottom:10px;
					}
					
		}
		td,th,p{
			text-transform:uppercase;
		}
   </style>
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
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_section")).'" class="btn btn-secondary" style="float:right;margin:4px;">BACK </a>';
						?> 
						
						 <a href="#mysubject" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;">SET SCHEDULE </a>
						 <a href="print_schedule.php?v=7e9ff1f60111f1bf6a3696b2092ac4a7285cd942" class="btn btn-success" style="float:right;margin:4px;" target="_blank">PRINT </a>
							<h4>Subject schedule per section</h4>
							 <?php
							 if (isset($_POST['new_schedule']))
							 {
								 mysqli_query($con,"INSERT INTO class_program VALUES(NULL,'".$_POST['sched_time']."','".$_POST['sched_day']."','".$_POST['subject']."','".$_POST['subTeacher']."','".$_GET['Code']."','".$_SESSION['Sem']."','".$_SESSION['year']."','".$_SESSION['school_id']."','".$_POST['grade']."','')");
								 mysqli_query($con,"INSERT INTO tbl_subject_load VALUES(NULL,'".$_POST['subject']."','".$_SESSION['year']."','".$_POST['grade']."','".$_POST['subTeacher']."','".$_GET['Code']."')");
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
							 }elseif (isset($_POST['update_schedule']))
							 {
								mysqli_query($con,"UPDATE class_program SET SecTime='".$_POST['sched_time']."',SecDay='".$_POST['sched_day']."',Emp_ID='".$_POST['subTeacher']."' WHERE No='".$_SESSION['upsched']."' LIMIT 1");
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
							 ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						$_SESSION['sec_id']=$_GET['Code'];
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_GET['Code']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
						 $data=mysqli_fetch_assoc($emp_info);
						
						
						   if ($data['Picture']<>NULL)
							 {
							 echo  '<img src="../../pcdmis//'.$data['Picture'].'" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 }else{
								 echo  '<img src="../../pcdmis//logo/user.png" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 
							 }
							echo '<p>Section Code: '.$_GET['Code'].'</p>';
						echo '<p>Section Name: '.$data['SecDesc'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
							{	
							  echo '<p>Grade: '.$data['Grade'].'</p>';
										
							}else{
							   echo '<p>Grade: Grade '.$data['Grade'].'</p>';
											
								}
						$_SESSION['Adviser']=$data['Emp_LName'].', '.$data['Emp_FName'];	
						$_SESSION['Grade']=$data['Grade'];						
						echo '<p>Class Adviser: '.$data['Emp_LName'].', '.$data['Emp_FName'].'</p>';
						echo '<p>Position: '.$data['Job_description'].'</p>';
						echo  '<p>Room Location: '.$data['Room_location'].'</p><hr/>';
						
						?>
						
						
						<table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th style="text-align:center;" rowspan="2">#</th>
												<th rowspan="2">Learning Areas</th>
												<th colspan="3" style="text-align:center;">Schedule</th>
												<th style="text-align:center;" rowspan="2">Teacher</th>
												<th style="text-align:center;" rowspan="2"></th>
												
											</tr>	
											<tr>
												<th style="text-align:center;">Time</th>
												<th style="text-align:center;">Day</th>
												<th style="text-align:center;">Room</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										if ($data['Grade']==11 || $data['Grade']==12)
										{
										  $requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo=tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_GET['Code']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
										}elseif ($data['Grade']>=7 AND $data['Grade']<=10){
										  $requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo=tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_GET['Code']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
										}else{
											$requery=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo=tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SecCode='".$_GET['Code']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."'");
										}
										$no=0;
										while($drow=mysqli_fetch_array($requery))
										{
										$no++;
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$drow['LearningAreas'].'</td>
												<td style="text-align:center;">'.$drow['SecTime'].'</td>
												<td style="text-align:center;">'.$drow['SecDay'].'</td>
												<td style="text-align:center;">'.$drow['SecDesc'].'</td>
												<td style="text-align:center;">'.$drow['Emp_LName'].', '.$drow['Emp_FName'].'</td>
												<td style="text-align:center;">
												<a href="edit_schedule.php?id='.urlencode(base64_encode($drow['No'])).'" data-toggle="modal" data-target="#updateschedule" class="btn btn-warning" style="margin:4px;padding:4px;">Update</a>
												<a  onclick="delete_one(this.id)" id="'.$drow['No'].' &SubCode='.$drow['SubNo'].'&EmpID='.$drow['Emp_ID'].'"  class="btn btn-info" style="margin:4px;padding:4px;cursor:pointer;">Delete</a><br/>
												
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
       
          <h3 class="modal-title"><center>New Schedule</center></h3>
		 
        </div><form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
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
		
	';
		?>
       
		</div>
		 <div class="modal-footer">
			<input type="submit" name="new_schedule" value="Save" class="btn btn-primary">
		   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		   </div>
 </form>
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
     