
<style>
	th,td{
		text-transform:uppercase;
	}
	</style>
	

	  <div class="col-lg-10">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						<a href="#newsubject" data-toggle="modal" class="btn btn-primary" style="float:right;">Add Learning Area</a>
						
							<h4>List of Learning Areas per Grade Level</h4>
							
							<?php
							 if (isset($_POST['AddSubject']))
							 {
								 mysqli_query($con,"INSERT INTO tbl_assessment_rat_subject VALUES(NULL,'".$_POST['Learning_Area']."','".$_POST['GLevel']."','".$_POST['No_of_Items']."','Closed','0','".$_SESSION['rat_status']."')");
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
						
						
						      <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="6">GRADE 6 LEARNING AREAS</th>
									</tr>
									<tr>	
                                        <th width="7%" style="text-align:center;">#</th>
                                        <th>LEARNING AREAS</th>
                                        <th width="10%"># OF ITEMS</th>
                                        <th width="10%"># OF EXAMINEES</th>
										  <th width="10%">SUBJECT STATUS</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$g6Total=0;
									$grade6=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Grade_Level='6' AND Exam_Status='".$_SESSION['rat_status']."' AND Exam_Code='".$_SESSION['assessment']."'");	
										while($rowG6=mysqli_fetch_array($grade6))
										{
											$no++;
											//Query for Learner
											$Totallearner=0;
											$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat  WHERE YLevel='6'");
											$Totallearner=mysqli_num_rows($learner);
										echo '<tr>	
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowG6['Learning_Areas'].'</td>
											<td style="text-align:center;">'.$rowG6['No_of_Items'].'</td>
											<td style="text-align:center;">'.$Totallearner.'</td>
											<td style="text-align:center;">'.$rowG6['Status'].'</td>
											<td style="text-align:center;">
											 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($rowG6['RATSubCode'])).'&GLevel='.urlencode(base64_encode($rowG6['Grade_Level'])).'&v='.urlencode(base64_encode("Questionnairs")).'" title="View Questionnairs">VIEW</a>
											</td>
										</tr>';
										$g6Total = $g6Total + $rowG6['No_of_Items'];
										}
										echo '<tr>
												<th colspan="2">Total Items:</th><th style="text-align:center;">'.$g6Total.'</th>
											</tr>';
									?>
									
                                </tbody>
								<thead>
								  <tr>
                                        <th colspan="6">GRADE 10 LEARNING AREAS</th>
									</tr>
									<tr>	
                                        <th width="7%" style="text-align:center;">#</th>
                                        <th>LEARNING AREAS</th>
                                        <th width="10%"># OF ITEMS</th>
                                        <th width="10%"># OF LEARNERS</th>
                                        <th width="10%">SUBJECT STATUS</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$g10Total=0;
									$grade10=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Grade_Level='10' AND Exam_Status='".$_SESSION['rat_status']."' AND Exam_Code='".$_SESSION['assessment']."'");	
										while($rowG10=mysqli_fetch_array($grade10))
										{
											$no++;
											$Totallearner=0;
											$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat WHERE YLevel='10'");
											$Totallearner=mysqli_num_rows($learner);
										echo '<tr>	
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowG10['Learning_Areas'].'</td>
											<td style="text-align:center;">'.$rowG10['No_of_Items'].'</td>
											<td style="text-align:center;">'.$Totallearner.'</td>
											<td style="text-align:center;">'.$rowG10['Status'].'</td>
											<td style="text-align:center;">
											 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($rowG10['RATSubCode'])).'&GLevel='.urlencode(base64_encode($rowG10['Grade_Level'])).'&v='.urlencode(base64_encode("Questionnairs")).'" title="View Questionnairs">VIEW</a>
										
											</td>
										</tr>';
										$g10Total = $g10Total + $rowG10['No_of_Items'];
										}
										echo '<tr>
												<th colspan="2">Total Items:</th><th style="text-align:center;">'.$g10Total.'</th>
											</tr>';
									?>
									
                                </tbody>
								<thead>
								  <tr>
                                        <th colspan="6">GRADE 12 LEARNING AREAS</th>
									</tr>
									<tr>	
                                        <th width="7%" style="text-align:center;">#</th>
                                        <th>LEARNING AREAS</th>
                                        <th width="10%"># OF ITEMS</th>
										 <th width="10%"># OF LEARNERS</th>
										   <th width="10%">SUBJECT STATUS</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$g12Total=0;
									$grade12=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Grade_Level='12' AND Exam_Status='".$_SESSION['rat_status']."' AND Exam_Code='".$_SESSION['assessment']."'");	
										while($rowG12=mysqli_fetch_array($grade12))
										{
											$no++;
											$Totallearner=0;
											$learner=mysqli_query($con,"SELECT * FROM tbl_assessment_rat WHERE YLevel='12'");
											$Totallearner=mysqli_num_rows($learner);
										echo '<tr>	
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$rowG12['Learning_Areas'].'</td>
											<td style="text-align:center;">'.$rowG12['No_of_Items'].'</td>
											<td style="text-align:center;">'.$Totallearner.'</td>
											<td style="text-align:center;">'.$rowG12['Status'].'</td>
											<td style="text-align:center;">
											 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($rowG12['RATSubCode'])).'&GLevel='.urlencode(base64_encode($rowG12['Grade_Level'])).'&v='.urlencode(base64_encode("Questionnairs")).'" title="View Questionnairs">VIEW</a>
										
											</td>
										</tr>';
										$g12Total = $g12Total + $rowG12['No_of_Items'];
										}
										echo '<tr>
												<th colspan="2">Total Items:</th><th style="text-align:center;">'.$g12Total.'</th>
											</tr>';
									?>
									
                                </tbody>
                            </table>
                            
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    </div>
					 <div class="col-lg-2">
					  <div class="panel panel-default">
					  	<input type="submit"  Value="BACK TO HOME" class="btn btn-default" style="padding:4px;margin:4px;height:50px;width:96%;" onclick="window.location.href='?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=ZGJlYQ%3D%3D'">
						<input type="submit"  value="CHANGE SUB. STATUS" class="btn btn-success" style="padding:4px;margin:4px;height:50px;width:96%;" data-toggle="modal">
						<label style="padding:4px;margin:4px;font-size:20px;">Current status:<br/>
						<?php
						echo $_SESSION['rat_status'];
						?>
						</label>
					 </div>
					 </div>
                    <!-- /.panel -->
               
     <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="newsubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Add New Subject</center></h3>
		  <form action="" method="POST" enctype="multipart/form-data">
		  	<label>Learning Area:</label>
			<input type="text" name="Learning_Area" class="form-control" placeholder="Enter Learning Areas">
			<label># of Items:</label>
			<input type="text" name="No_of_Items" class="form-control" placeholder="Enter Number of Items">
			<label>Grade Level:</label>
			<select name="GLevel" class="form-control">
			  <option value="">--Select--</option>
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
			  <option value="12">Grade 12</option>
			  
			</select><hr/>
			<input type="submit" name="AddSubject" class="btn btn-primary">
			</form>
        </div>
		
	   </div>
     </div>
</div>
</div>


                 <!-- Modal -->
	 <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="margin-left:auto;margin-right:auto;width:30%; height:25%;margin-top:50px;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../logo/check.png" width="100%" height="50%">
			<h3>Successfully Submitted!</h3>
		   	</div>
           <div class="modal-footer">
		   <button type="button" class="btn btn-success" aria-hidden="true" data-dismiss="modal">OK</button>
		 </div>	

	</div></div>
	</div>
 