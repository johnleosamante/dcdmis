

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
						   echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("readiness")).'" style="float:right;" class="btn btn-secondary">Back</a> ';
						?>						   
						  
						 	<h4>LIST OF SCHOOLS</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="overflow-x:auto;">
						<?php
						$_SESSION['Grade']=$_GET['GL'];
						

						if ($_GET['GL']=='Kinder' || $_GET['GL']=='1' || $_GET['GL']=='2' || $_GET['GL']=='3' || $_GET['GL']=='4' || $_GET['GL']=='5' || $_GET['GL']=='6')
						{
						echo '<h4>Elementary Level</h4>
								<label>Grade Level: </label>';
								if ($_GET['GL']=='Kinder')
								{
								echo ' <label> '.$_GET['GL'].'</label>';
								}else{
									echo ' <label> Grade '.$_GET['GL'].'</label>';
								}
							echo '<br/>
						<br/>
                           <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="15%" rowspan="2">SCHOOLS</th>											
												<th colspan="10">LEARNING AREAS</th>
												
											</tr>
												<tr>
													<td style="text-align:center;">English</td>
													<td style="text-align:center;">Science</td>
													<td style="text-align:center;">Math</td>
													<td style="text-align:center;">Filipino</td>
													<td style="text-align:center;">Aral. Pan</td>
													<td style="text-align:center;">E.S.P</td>
													<td style="text-align:center;">T.L.E/E.P.P</td>
													<td style="text-align:center;">MAPEH</td>
													<td style="text-align:center;">Mother Tongue</td>
													
													<td style="text-align:center;">Total</td>
											
											</tr>
									</thead>
									<tbody>';
									$no=$ElemenTotal=0;
									$totEng=$totScie=$totMath=$totFil=$totAral=$totESP=$totMapeh=$totMT=$totRO=$totPR=$totSub=$totTLE=0;
									$elemenschool=mysqli_query($con,"SELECt * FROM tbl_elementary_subject INNER JOIN tbl_school ON tbl_elementary_subject.SchoolID = tbl_school.SchoolID  WHERE tbl_elementary_subject.GradeLevel='".$_GET['GL']."' AND tbl_elementary_subject.WeekNo='".$_SESSION['week']."' AND tbl_elementary_subject.QuarterNo='".$_SESSION['quarter']."' GROUP BY tbl_elementary_subject.SchoolID");
									while($elemenrow=mysqli_fetch_array($elemenschool))
									{
										$no++;
										$ElemenTotal=$elemenrow['English']+$elemenrow['Science']+$elemenrow['Math']+$elemenrow['Filipino']+$elemenrow['AralPan']+$elemenrow['ESP']+$elemenrow['TLE']+$elemenrow['MAPEH']+$elemenrow['Mother_tongue']+$elemenrow['RO_Thematic']+$elemenrow['Project_Rush'];
										echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td style="text-align:center;">'.$elemenrow['SchoolName'].'</td>
													<td style="text-align:center;">'.$elemenrow['English'].'</td>
													<td style="text-align:center;">'.$elemenrow['Science'].'</td>
													<td style="text-align:center;">'.$elemenrow['Math'].'</td>
													<td style="text-align:center;">'.$elemenrow['Filipino'].'</td>
													<td style="text-align:center;">'.$elemenrow['AralPan'].'</td>
													<td style="text-align:center;">'.$elemenrow['ESP'].'</td>
													<td style="text-align:center;">'.$elemenrow['TLE'].'</td>
													<td style="text-align:center;">'.$elemenrow['MAPEH'].'</td>
													<td style="text-align:center;">'.$elemenrow['Mother_tongue'].'</td>
													
													<td style="text-align:center;">'.number_format($ElemenTotal,1).'</td>
											
											</tr>
											';
										$totEng=$totEng+$elemenrow['English'];
										$totScie=$totScie+$elemenrow['Science'];
										$totMath=$totMath+$elemenrow['Math'];
										$totFil=$totFil+$elemenrow['Filipino'];
										$totAral=$totAral+$elemenrow['AralPan'];	
										$totESP=$totESP+$elemenrow['ESP'];
										$totTLE=$totTLE+$elemenrow['TLE'];
										$totMapeh=$totMapeh+$elemenrow['MAPEH'];	
										$totMT	=$totMT+$elemenrow['Mother_tongue'];
										//$totRO=$totRO+$elemenrow['RO_Thematic'];
										//$totPR=$totPR+$elemenrow['Project_Rush'];
										$totSub	=$totSub+$ElemenTotal;
									}
									echo '<tr>
											<th colspan="2">Total</th>
											<td style="text-align:center;">'.number_format($totEng,2).'</td>
											<td style="text-align:center;">'.number_format($totScie,2).'</td>
											<td style="text-align:center;">'.number_format($totMath,2).'</td>
											<td style="text-align:center;">'.number_format($totFil,2).'</td>
											<td style="text-align:center;">'.number_format($totAral,2).'</td>
											<td style="text-align:center;">'.number_format($totESP,2).'</td>
											<td style="text-align:center;">'.number_format($totTLE,2).'</td>
											<td style="text-align:center;">'.number_format($totMapeh,2).'</td>
											<td style="text-align:center;">'.number_format($totMT,2).'</td>
											
											<td style="text-align:center;">'.number_format($totSub,2).'</td>
											
										  </tr>
									</tbody></table>';	
						}elseif ($_GET['GL']=='7' || $_GET['GL']=='8' || $_GET['GL']=='9' || $_GET['GL']=='10')
						{
							echo '<h4>Secondary Level</h4>
								<label>Grade Level: </label>';
							echo ' <label> Grade '.$_GET['GL'].'</label>
									<br/>
						         <br/>
                           <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="15%" rowspan="2">SCHOOLS</th>											
												<th colspan="15">LEARNING AREAS</th>
												
											</tr>
												<tr>
													<td>English</td>
														<td>Science</td>
														<td>Math</td>
															<td>Filipino</td>
															<td>Aral. Pan.</td>
																<td>E.S.P</td>
															<td>T.L.E</td>
															<td>Music</td>
															<td>Arts</td>
														<td>P.E</td>
														<td>Health</td>
												
													<td>Elective 1</td>
													<td>Elective 2</td>
													<td>Elective 3</td>
													<td>Total</td>
												</tr>
									</thead>
									<tbody>';
									$no=$SecondTotal=0;
									$totElec1=$totElec2=$totElec3=$totEng=$totScie=$totMath=$totFil=$totAral=$totESP=$totMapeh=$totArts=$totPE=$totHealth=$totSub=$totTLE=$totRO=0;
									
									$secondschool=mysqli_query($con,"SELECt * FROM tbl_secondary_subject INNER JOIN tbl_school ON tbl_secondary_subject.SchoolID = tbl_school.SchoolID  WHERE tbl_secondary_subject.GradeLevel='".$_GET['GL']."' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."' GROUP BY tbl_secondary_subject.SchoolID");
									
									while($secondrow=mysqli_fetch_array($secondschool))
									{
										$no++;
										$SecondTotal=$secondrow['English']+$secondrow['Science']+$secondrow['Math']+$secondrow['Filipino']+$secondrow['AralPan']+$secondrow['ESP']+$secondrow['TLE']+$secondrow['Music']+$secondrow['Arts']+$secondrow['PE']+$secondrow['Health']+$secondrow['RO_Thematic']+$secondrow['Elective1']+$secondrow['Elective2']+$secondrow['Elective3'];
										echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td style="text-align:center;">'.$secondrow['SchoolName'].'</td>
													<td style="text-align:center;">'.$secondrow['English'].'</td>
													<td style="text-align:center;">'.$secondrow['Science'].'</td>
													<td style="text-align:center;">'.$secondrow['Math'].'</td>
													<td style="text-align:center;">'.$secondrow['Filipino'].'</td>
													<td style="text-align:center;">'.$secondrow['AralPan'].'</td>
													<td style="text-align:center;">'.$secondrow['ESP'].'</td>
													<td style="text-align:center;">'.$secondrow['TLE'].'</td>
													<td style="text-align:center;">'.$secondrow['Music'].'</td>
													<td style="text-align:center;">'.$secondrow['Arts'].'</td>
													<td style="text-align:center;">'.$secondrow['PE'].'</td>
													<td style="text-align:center;">'.$secondrow['Health'].'</td>
													
													<td style="text-align:center;">'.$secondrow['Elective1'].'</td>
													<td style="text-align:center;">'.$secondrow['Elective2'].'</td>
													<td style="text-align:center;">'.$secondrow['Elective3'].'</td>
													<td style="text-align:center;">'.number_format($SecondTotal,1).'</td>
											
											</tr>';
										$totEng=$totEng+$secondrow['English'];
										$totScie=$totScie+$secondrow['Science'];
										$totMath=$totMath+$secondrow['Math'];
										$totFil=$totFil+$secondrow['Filipino'];
										$totAral=$totAral+$secondrow['AralPan'];	
										$totESP=$totESP+$secondrow['ESP'];
										$totTLE=$totTLE+$secondrow['TLE'];
										$totMapeh=$totMapeh+$secondrow['Music'];	
										$totArts=$totArts+$secondrow['Arts'];
										$totPE=$totPE+$secondrow['PE'];
										$totHealth=$totHealth+$secondrow['Health'];
										//$totRO=$totRO+$secondrow['RO_Thematic'];
										$totElec1=$totElec1+$secondrow['Elective1'];
										$totElec2=$totElec2+$secondrow['Elective2'];
										$totElec3=$totElec3+$secondrow['Elective3'];
										$totSub	=$totSub+$SecondTotal;
									}
									echo '<tr>
											<th colspan="2">Total</th>
											<td style="text-align:center;">'.number_format($totEng,0).'</td>
											<td style="text-align:center;">'.number_format($totScie,0).'</td>
											<td style="text-align:center;">'.number_format($totMath,0).'</td>
											<td style="text-align:center;">'.number_format($totFil,0).'</td>
											<td style="text-align:center;">'.number_format($totAral,0).'</td>
											<td style="text-align:center;">'.number_format($totESP,0).'</td>
											<td style="text-align:center;">'.number_format($totTLE,0).'</td>
											<td style="text-align:center;">'.number_format($totMapeh,0).'</td>
											<td style="text-align:center;">'.number_format($totArts,0).'</td>
											<td style="text-align:center;">'.number_format($totPE,0).'</td>
											<td style="text-align:center;">'.number_format($totHealth,0).'</td>
											
											<td style="text-align:center;">'.number_format($totElec1,0).'</td>
											<td style="text-align:center;">'.number_format($totElec2,0).'</td>
											<td style="text-align:center;">'.number_format($totElec3,0).'</td>
											<td style="text-align:center;">'.number_format($totSub,0).'</td>
											
										  </tr></tbody></table>';
								
						}elseif ($_GET['GL']=='11' || $_GET['GL']=='12')
						{
							$_SESSION['SpCode']=$_GET['Code'];
							$myschool=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE tbl_qualification.SpCode='".$_GET['Code']."' LIMIT 1");
							$rowschool=mysqli_fetch_assoc($myschool);
							echo '<h4>Senior High School Level</h4>
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
												<th width="35%" rowspan="2">SCHOOLS</th>											
												<th rowspan="2"># OF LEARNERS</th>
												<th rowspan="2"># OF MODULES</th>
												<th rowspan="2" width="5%"></th>
											
												
											</tr>
												
									</thead>
									<tbody>';
									$TotalSubLearner=$TotalSubModules=$no=0;
									$mydata=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode = tbl_qualification.SpCode INNER JOIN tbl_school ON tbl_qualification_by_school.SchoolID = tbl_school.SchoolID  WHERE tbl_qualification.Strand='".$rowschool['Strand']."' AND tbl_qualification.Grade='".$_GET['GL']."' AND tbl_qualification_by_school.QualCode ='".$_GET['Code']."' GROUP BY tbl_qualification_by_school.SchoolID");
									while($rowschooldata=mysqli_fetch_array($mydata))
									{
										$no++;
										$myLearner=$mymodule=0;
										$mydatabyschool=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode = tbl_senior_sub_strand.StrandsubCode  WHERE tbl_shs_report.SpecCode='".$rowschooldata['SpCode']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.SchoolID='".$rowschooldata['SchoolID']."'");
										while($datarow=mysqli_fetch_array($mydatabyschool))
										{
											$mymodule=$mymodule+$datarow['No_of_copies'];
										}
										if ($_SESSION['Sem']=='First Semester')
										{
											$learners=mysqli_query($con,"SELECT * FROM first_semester WHERE SpCode ='".$rowschooldata['QualCode']."' AND SchoolID='".$rowschooldata['SchoolID']."'");
										}else{
											$learners=mysqli_query($con,"SELECT * FROM second_semester WHERE SpCode ='".$rowschooldata['QualCode']."' AND SchoolID='".$rowschooldata['SchoolID']."'");
										}
										echo '<tr>
												<td style="text-align:center;">'.$no.'</th>
												<td>'.$rowschooldata['SchoolName'].'</th>											
												<td style="text-align:center;">'.mysqli_num_rows($learners).'</th>
												<td style="text-align:center;">'.number_format($mymodule,0).'</th>
												<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode($rowschooldata['Grade'])).'&Code='.urlencode(base64_encode($rowschooldata['SchoolID'])).'&v='.urlencode(base64_encode("view_subject")).'"><i class="fa   fa-desktop  fa"></i></a></th>
											</tr>';
											$TotalSubLearner=$TotalSubLearner+$myLearner;
											$TotalSubModules=$TotalSubModules+$mymodule;
									}
									echo '<tr>
											<th colspan="2">Total:</th>
											<td  style="text-align:center;">'.number_format($TotalSubLearner,0).'</td>
											<td  style="text-align:center;">'.number_format($TotalSubModules,0).'</td>
											
											
											</tr>';
									
									
									
							echo '</tbody></table>';			
						}
									
						
							
						?>
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            </div>
           
    

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>
