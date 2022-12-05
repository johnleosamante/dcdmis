<?php

$mysched=mysqli_query($con,"SELECT * FROM tbl_distribution_schedule");
$rowdata=mysqli_fetch_assoc($mysched);	
$_SESSION['Grade']=$_GET['GL'];

?>

	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}
	label{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						   echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($_SESSION['Grade'])).'&Code='.urlencode(base64_encode($_SESSION['SpCode'])).'&v='.urlencode(base64_encode("view_school")).'" style="float:right;" class="btn btn-secondary">Back</a>';  		
						 ?>
						 	<h4>LIST OF SUBJECTS</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						$myschool=mysqli_query($con,"SELECT * FROM tbl_qualification INNER JOIN tbl_qualification_by_school ON tbl_qualification.SpCode = tbl_qualification_by_school.QualCode INNER JOIN tbl_school ON tbl_qualification_by_school.SchoolID = tbl_school.SchoolID WHERE tbl_qualification.SpCode='".$_SESSION['SpCode']."' AND tbl_qualification_by_school.SchoolID = '".$_GET['Code']."'LIMIT 1");
							$rowschool=mysqli_fetch_assoc($myschool);
							echo '
								<label>Name of school: </label>
								<label>'.$rowschool['SchoolName'].' </label>
								<br/>
								<label>Grade Level: </label>
								<label> Grade '.$_GET['GL'].'</label><br/>
								<label>Qualification: </label>
								<label>'.$rowschool['Description'].'</label>
									<br/>
								<label>Strand: </label>
								<label>'.$rowschool['Strand'].'</label>
									<br/>
						         <br/>
                           <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="35%" rowspan="2">LEARNING AREAS</th>											
												<th rowspan="2"># OF LEARNERS</th>
												<th rowspan="2"># OF MODULES</th>
																					
												
											</tr>
												
									</thead>
									<tbody>';
									$TotalSubLearner=$TotalSubModules=$no=0;
									$mydata=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$_SESSION['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.SchoolID='".$_GET['Code']."'");
									while($rowschooldata=mysqli_fetch_array($mydata))
									{
										$no++;
										echo '<tr>
												<td style="text-align:center;">'.$no.'</th>
												<td>'.$rowschooldata['SubStrandDescription'].'</th>											
												<td style="text-align:center;">'.number_format($rowschooldata['No_of_learner'],2).'</th>
												<td style="text-align:center;">'.number_format($rowschooldata['No_of_copies'],2).'</th>
																							
											</tr>';
											$TotalSubLearner=$TotalSubLearner+$rowschooldata['No_of_learner'];
											$TotalSubModules=$TotalSubModules+$rowschooldata['No_of_copies'];
									}
									echo '<tr>
											<th colspan="2">Total:</th>
											<td  style="text-align:center;">'.number_format($TotalSubLearner,2).'</td>
											<td  style="text-align:center;">'.number_format($TotalSubModules,2).'</td>
											
											
											</tr>';
									
									
									
							echo '</tbody></table>';			
						
						
							
						?>
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               