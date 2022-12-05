			
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dbea")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						 ?>			
							<h4>BUREAU OF EDUCATION ASSESSMENT > PAGADIAN CITY DIVISION > <?php echo $_SESSION['CurrentExam']; ?> > GRADE LEVEL</h4>
							 <a href="#myDivision" class="btn btn-primary" data-toggle="modal" >Add Grade Level</a>
							 <a href="#mySchool" class="btn btn-primary" data-toggle="modal" >Add School</a>
							<?php
							if (isset($_POST['savegrade']))
							{
								mysqli_query($con,"INSERT INTO tbl_assessment_grade_level_recipient VALUES(NULL,'".$_POST['gradelevel']."','".$_SESSION['assessment']."','".$_SESSION['year']."')");
							    if (mysqli_affected_rows($con)==1)
								{
									$Err = "Division Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
									
								}
							}
							?>
                        </div>
                        <div class="panel-body">
                              <?php

								$result=mysqli_query($con,"SELECT * FROM tbl_assessment_grade_level_recipient WHERE Exam_type='".$_SESSION['assessment']."' ORDER BY Grade_Level Asc");
								while($row=mysqli_fetch_array($result))
								{
									   echo '<div class="col-lg-4">
										<div class="panel panel-default">
											 <div class="panel-heading">';
											 if ($row['Grade_Level']<>'Kinder')
													{
														echo '<h4>Grade '.$row['Grade_Level'].'</h4>';
													}else{
														echo '<h4>'.$row['Grade_Level'].'</h4>';
													}
											echo '</div>
											<div class="panel-body">
											 
											  <h4>List of Schools</h4> 
												<table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th>Name of Schools recipient</th>
											 
											 </tr>
										</thead>
										<tbody>';
										$no=0;
										$query=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_school_recipient INNER JOIN tbl_school ON tbl_assessment_rat_school_recipient.SchoolID=tbl_school.SchoolID WHERE tbl_assessment_rat_school_recipient.ExamType='".$row['Exam_type']."' AND SchoolYear='".$row['School_Year']."' AND GradeLevel='".$row['Grade_Level']."'");
										while($rowque=mysqli_fetch_array($query))
										{
											$no++;
											echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$rowque['SchoolName'].'</td>
											 
											 </tr>';
										}
																		
										echo '</tbody>
										</table>
											</div>
										  
										</div>
						  
									
								   </div>';
								}
					?>
                    </div>
               </div>
         

<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myDivision" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title"><center>NEW GRADE LEVEL ENTRY</center></h4>
        </div>
        <div class="modal-body">
		<label>Grade Level</label>
		<select name="gradelevel" class="form-control">
			<option value="">--select--</option>
			<option value="Kinder">Kinder</option>
			<option value="1">Grade 1</option>
			<option value="2">Grade 2</option>
			<option value="3">Grade 3</option>
			<option value="4">Grade 4</option>
			<option value="5">Grade 5</option>
			<option value="6">Grade 6</option>
			<option value="7">Grade 7</option>
			<option value="8">Grade 8</option>
			<option value="9">Grade 9</option>
			<option value="10">Grade 10</option>
			<option value="11">Grade 11</option>
			<option value="12">Grade 12</option>
		
		</select>
	
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="savegrade" value="SAVE" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 </div>
       </div>
      </div>
  </div></div>
			  	

<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="mySchool" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title"><center>SCHOOL ENTRY</center></h4>
        </div>
        <div class="modal-body">
		
		<label>Select School</label>
		<select name="schoolname" class="form-control">
			<option value="">--select--</option>
			<?php
			 $mysch=mysqli_query($con,"SELECT * FROM tbl_school ORDER BY SchoolName Asc");
			 while($rowschol=mysqli_fetch_array($mysch))
			 {
				 echo '<option value="'.$rowschol['SchoolID'].'">'.$rowschol['SchoolName'].'</option>';
			 }
			?>
		
		</select>
		<label>Grade Level</label>
		<select name="gradelevel" class="form-control">
			<option value="">--select--</option>
			<option value="Kinder">Kinder</option>
			<option value="1">Grade 1</option>
			<option value="2">Grade 2</option>
			<option value="3">Grade 3</option>
			<option value="4">Grade 4</option>
			<option value="5">Grade 5</option>
			<option value="6">Grade 6</option>
			<option value="7">Grade 7</option>
			<option value="8">Grade 8</option>
			<option value="9">Grade 9</option>
			<option value="10">Grade 10</option>
			<option value="11">Grade 11</option>
			<option value="12">Grade 12</option>
		
		</select>
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="savegrade" value="SAVE" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 </div>
       </div>
      </div>
  </div></div>
			  	
