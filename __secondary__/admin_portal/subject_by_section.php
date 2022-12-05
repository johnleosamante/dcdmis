
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
						
							<h4>Subject schedule per section</h4>
							
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_GET['Code']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
						 $data=mysqli_fetch_assoc($emp_info);
						
						
						   if ($data['Picture']<>NULL)
							 {
							 echo  '<img src="../../pcdmis/'.$data['Picture'].'" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 }else{
								 echo  '<img src="../../pcdmis/logo/user.png" style="width:150px;height:150px;border-radius:5em;float:right;" align="left">';
							 
							 }
							echo '<p>Section Code: '.$_GET['Code'].'</p>';
						echo '<p>Section Name: '.$data['SecDesc'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
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
                                        <th width="7%">LRN</th>
                                        <th width="10%">LAST NAME</th>
                                        <th width="10%">FIRST NAME</th>
                                        <th width="10%">MIDDLE NAME</th>
                                        <th width="10%">BIRTHDATE</th>
                                        <th width="10%">CONTACT #</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
							if ($data['Grade']=='11' || $data['Grade']=='12')
						{
								if ($_SESSION['Sem']=='First Semester')
								{
									$secdata=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SecCode='".$_GET['Code']."' ORDER BY tbl_student.Lname Asc ");
						
								}elseif ($_SESSION['Sem']=='Second Semester')
								{
									$secdata=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SecCode='".$_GET['Code']."' ORDER BY tbl_student.Lname Asc  ");
						
								}
						}else{							
						$secdata=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_GET['Code']."'  ORDER BY tbl_student.Lname Asc ");
						}			
							while($row_secdata=mysqli_fetch_array($secdata))
							{
								
						echo '<tr>
									<td>'.$row_secdata['lrn'].'</td>
									<td>'.utf8_encode($row_secdata['Lname'].'</td>
									<td>'.$row_secdata['FName'].'</td>
									<td>'.$row_secdata['MName']).'</td>
									<td>'.$row_secdata['Birthdate'].'</td>
									<td>'.$row_secdata['ContactNo'].'</td>
											
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
               
