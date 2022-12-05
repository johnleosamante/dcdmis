<table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th colspan="14">ELEMENTARY SCHOOL</th>
											</tr>
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="15%" rowspan="2">GRADE LEVEL</th>											
												<th colspan="11">LEARNING AREAS</th>
												<th width="5%" rowspan="2"></th>
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
													<td style="text-align:center;">RO Thematic</td>
													<td style="text-align:center;">Total</td>
											
											</tr>
									</thead>
									<tbody>
									  <?php 
									  session_start();
										include("../vendor/jquery/function.php");
									  $TotEng=$TotScie=$TotMath=$TotFil=$TotAral=$TotESP=$TotTLE=$TotMAPEH=$TotMT=$Total=0;
									  $KinEng=$KinScie =$KinMath=$KinFil=$KinAral=$KinESP=$KinTLE=$KinMAPEH=$KinMT=$KinRO=$KinTotal=0;
									  $mydata=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='Kinder' AND WeekNo='".$_GET['id']."'");
									  while($kinderrow=mysqli_fetch_array($mydata))
									  {
										$KinEng = $KinEng + $kinderrow['English'];  
										$KinScie = $KinScie + $kinderrow['Science'];  
										$KinMath = $KinMath + $kinderrow['Math'];  
										$KinFil = $KinFil + $kinderrow['Filipino'];  
										$KinAral = $KinAral + $kinderrow['AralPan'];  
										$KinESP = $KinESP + $kinderrow['ESP'];  
										$KinTLE = $KinTLE + $kinderrow['TLE'];  
										$KinMAPEH = $KinMAPEH + $kinderrow['MAPEH'];  
										$KinMT = $KinMT + $kinderrow['Mother_tongue'];  
										$KinRO = $KinRO + $kinderrow['RO_Thematic'];  
									  }
									  $KinTotal=$KinEng+$KinScie+$KinMath+$KinFil+$KinAral+$KinESP+$KinTLE+$KinMAPEH+$KinMT+$KinRO;
											echo '<tr>
													<td style="text-align:center;">1</td>
													<td style="text-align:center;">Kinder</td>
													<td style="text-align:center;">'.number_format($KinEng,0).'</td>
													<td style="text-align:center;">'.number_format($KinScie,0).'</td>
													<td style="text-align:center;">'.number_format($KinMath,0).'</td>
													<td style="text-align:center;">'.number_format($KinFil,0).'</td>
													<td style="text-align:center;">'.number_format($KinAral,0).'</td>
													<td style="text-align:center;">'.number_format($KinESP,0).'</td>
													<td style="text-align:center;">'.number_format($KinTLE,0).'</td>
													<td style="text-align:center;">'.number_format($KinMAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($KinMT,0).'</td>
													<td style="text-align:center;">'.number_format($KinRO,0).'</td>
													<td style="text-align:center;">'.number_format($KinTotal,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=Kinder" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
									  $G1Eng=$G1Scie=$G1Math=$G1Fil=$G1Aral=$G1ESP=$G1TLE=$G1MAPEH=$G1MT=$G1RO=$G1Total=0;
									  $myG1=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='1' AND WeekNo='".$_GET['id']."'");
									  while($G1row=mysqli_fetch_array($myG1))
									  {
										$G1Eng = $G1Eng + $G1row['English'];  
										$G1Scie = $G1Scie + $G1row['Science'];  
										$G1Math = $G1Math + $G1row['Math'];  
										$G1Fil = $G1Fil + $G1row['Filipino'];  
										$G1Aral = $G1Aral + $G1row['AralPan'];  
										$G1ESP = $G1ESP + $G1row['ESP'];  
										$G1TLE = $G1TLE + $G1row['TLE'];  
										$G1MAPEH = $G1MAPEH + $G1row['MAPEH'];  
										$G1MT = $G1MT + $G1row['Mother_tongue'];  
										$G1RO = $G1RO + $G1row['RO_Thematic'];  
									  }
									  $G1Total=$G1Eng+$G1Scie+$G1Math+$G1Fil+$G1Aral+$G1ESP+$G1TLE+$G1MAPEH+$G1MT+$G1RO;
											
										echo '<tr>	
													<td style="text-align:center;">2</td>											
													<td style="text-align:center;">Grade 1</td>
													<td style="text-align:center;">'.number_format($G1Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G1Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G1Math,0).'</td>
													<td style="text-align:center;">'.number_format($G1Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G1Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G1ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G1TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G1MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G1MT,0).'</td>
														<td style="text-align:center;">'.number_format($G1RO,0).'</td>
													<td style="text-align:center;">'.number_format($G1Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=1" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
									  $G2Eng=$G2Scie=$G2Math=$G2Fil=$G2Aral=$G2ESP=$G2TLE=$G2MAPEH=$G2MT=$G2Total=$G2RO=0;
									  $myG2=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='2' AND WeekNo='".$_GET['id']."'");
									  while($G2row=mysqli_fetch_array($myG2))
									  {
										$G2Eng = $G2Eng + $G2row['English'];  
										$G2Scie = $G2Scie + $G2row['Science'];  
										$G2Math = $G2Math + $G2row['Math'];  
										$G2Fil = $G2Fil + $G2row['Filipino'];  
										$G2Aral = $G2Aral + $G2row['AralPan'];  
										$G2ESP = $G2ESP + $G2row['ESP'];  
										$G2TLE = $G2TLE + $G2row['TLE'];  
										$G2MAPEH = $G2MAPEH + $G2row['MAPEH'];  
										$G2MT = $G2MT + $G2row['Mother_tongue'];  
										$G2RO = $G2RO + $G2row['RO_Thematic'];  
									  }
									  $G2Total=$G2Eng+$G2Scie+$G2Math+$G2Fil+$G2Aral+$G2ESP+$G2TLE+$G2MAPEH+$G2MT+$G2RO;
											
										echo '<tr>
													<td style="text-align:center;">3</td>
													<td style="text-align:center;">Grade 2</td>
													<td style="text-align:center;">'.number_format($G2Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G2Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G2Math,0).'</td>
													<td style="text-align:center;">'.number_format($G2Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G2Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G2ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G2TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G2MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G2MT,0).'</td>
													<td style="text-align:center;">'.number_format($G2RO,0).'</td>
													<td style="text-align:center;">'.number_format($G2Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=2" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G3Eng=$G3Scie=$G3Math=$G3Fil=$G3Aral=$G3ESP=$G3TLE=$G3MAPEH=$G3MT=$G3RO=$G3Total=0;
											  $myG3=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='3' AND WeekNo='".$_GET['id']."'");
											  while($G3row=mysqli_fetch_array($myG3))
											  {
												$G3Eng = $G3Eng + $G3row['English'];  
												$G3Scie = $G3Scie + $G3row['Science'];  
												$G3Math = $G3Math + $G3row['Math'];  
												$G3Fil = $G3Fil + $G3row['Filipino'];  
												$G3Aral = $G3Aral + $G3row['AralPan'];  
												$G3ESP = $G3ESP + $G3row['ESP'];  
												$G3TLE = $G3TLE + $G3row['TLE'];  
												$G3MAPEH = $G3MAPEH + $G3row['MAPEH'];  
												$G3MT = $G3MT + $G3row['Mother_tongue'];  
												$G3RO = $G3RO + $G3row['RO_Thematic'];  
											  }
											  $G3Total=$G3Eng+$G3Scie+$G3Math+$G3Fil+$G3Aral+$G3ESP+$G3TLE+$G3MAPEH+$G3MT+$G3RO;
											echo '<tr>
													<td style="text-align:center;">4</td>
													<td style="text-align:center;">Grade 3</td>
													<td style="text-align:center;">'.number_format($G3Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G3Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G3Math,0).'</td>
													<td style="text-align:center;">'.number_format($G3Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G3Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G3ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G3TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G3MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G3MT,0).'</td>
													<td style="text-align:center;">'.number_format($G3RO,0).'</td>
													<td style="text-align:center;">'.number_format($G3Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=3" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>
											';
											 $G4Eng=$G4Scie=$G4Math=$G4Fil=$G4Aral=$G4ESP=$G4TLE=$G4MAPEH=$G4MT=$G4RO=$G4Total=0;
											  $myG4=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='4' AND WeekNo='".$_GET['id']."'");
											  while($G4row=mysqli_fetch_array($myG4))
											  {
												$G4Eng = $G4Eng + $G4row['English'];  
												$G4Scie = $G4Scie + $G4row['Science'];  
												$G4Math = $G4Math + $G4row['Math'];  
												$G4Fil = $G4Fil + $G4row['Filipino'];  
												$G4Aral = $G4Aral + $G4row['AralPan'];  
												$G4ESP = $G4ESP + $G4row['ESP'];  
												$G4TLE = $G4TLE + $G4row['TLE'];  
												$G4MAPEH = $G4MAPEH + $G4row['MAPEH'];  
												$G4MT = $G4MT + $G4row['Mother_tongue'];  
												$G4RO = $G4RO + $G4row['RO_Thematic'];  
											  }
											  $G4Total=$G4Eng+$G4Scie+$G4Math+$G4Fil+$G4Aral+$G4ESP+$G4TLE+$G4MAPEH+$G4MT+$G4RO;
											echo '
											<tr>	
													<td style="text-align:center;">5</td>
													<td style="text-align:center;">Grade 4</td>
													<td style="text-align:center;">'.number_format($G4Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G4Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G4Math,0).'</td>
													<td style="text-align:center;">'.number_format($G4Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G4Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G4ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G4TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G4MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G4MT,0).'</td>
													<td style="text-align:center;">'.number_format($G4RO,0).'</td>
													<td style="text-align:center;">'.number_format($G4Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=4" title="View School"> <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G5Eng=$G5Scie=$G5Math=$G5Fil=$G5Aral=$G5ESP=$G5TLE=$G5MAPEH=$G5MT=$G5Total=$G5RO=0;
											  $myG5=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='5' AND WeekNo='".$_GET['id']."'");
											  while($G5row=mysqli_fetch_array($myG5))
											  {
												$G5Eng = $G5Eng + $G5row['English'];  
												$G5Scie = $G5Scie + $G5row['Science'];  
												$G5Math = $G5Math + $G5row['Math'];  
												$G5Fil = $G5Fil + $G5row['Filipino'];  
												$G5Aral = $G5Aral + $G5row['AralPan'];  
												$G5ESP = $G5ESP + $G5row['ESP'];  
												$G5TLE = $G5TLE + $G5row['TLE'];  
												$G5MAPEH = $G4MAPEH + $G5row['MAPEH'];  
												$G5MT = $G5MT + $G5row['Mother_tongue'];  
												$G5RO = $G5RO + $G5row['RO_Thematic'];  
											  }
											  $G5Total=$G5Eng+$G5Scie+$G5Math+$G5Fil+$G5Aral+$G5ESP+$G5TLE+$G5MAPEH+$G5MT+$G5RO;
											   
											echo '<tr>
													<td style="text-align:center;">6</td>
													<td style="text-align:center;">Grade 5</td>
													<td style="text-align:center;">'.number_format($G5Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G5Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G5Math,0).'</td>
													<td style="text-align:center;">'.number_format($G5Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G5Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G5ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G5TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G5MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G5MT,0).'</td>
													<td style="text-align:center;">'.number_format($G5RO,0).'</td>
													<td style="text-align:center;">'.number_format($G5Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=5" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G6Eng=$G6Scie=$G6Math=$G6Fil=$G6Aral=$G6ESP=$G6TLE=$G6MAPEH=$G6MT=$G6RO=$G6Total=0;
											  $myG6=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='6' AND WeekNo='".$_GET['id']."'");
											  while($G6row=mysqli_fetch_array($myG6))
											  {
												$G6Eng = $G6Eng + $G6row['English'];  
												$G6Scie = $G6Scie + $G6row['Science'];  
												$G6Math = $G6Math + $G6row['Math'];  
												$G6Fil = $G6Fil + $G6row['Filipino'];  
												$G6Aral = $G6Aral + $G6row['AralPan'];  
												$G6ESP = $G6ESP + $G6row['ESP'];  
												$G6TLE = $G6TLE + $G6row['TLE'];  
												$G6MAPEH = $G6MAPEH + $G6row['MAPEH'];  
												$G6MT = $G6MT + $G6row['Mother_tongue'];  
												$G6RO = $G6RO + $G6row['RO_Thematic'];  
											  }
											  $G6Total=$G6Eng+$G6Scie+$G6Math+$G6Fil+$G6Aral+$G6ESP+$G6TLE+$G6MAPEH+$G6MT+$G6RO;
											echo '<tr>
													<td style="text-align:center;">7</td>
													<td style="text-align:center;">Grade 6</td>
													<td style="text-align:center;">'.number_format($G6Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G6Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G6Math,0).'</td>
													<td style="text-align:center;">'.number_format($G6Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G6Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G6ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G6TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G6MAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($G6MT,0).'</td>
													<td style="text-align:center;">'.number_format($G6RO,0).'</td>
													<td style="text-align:center;">'.number_format($G6Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=6" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											
											  $TotEng=$KinEng+$G1Eng+$G2Eng+$G3Eng+$G4Eng+$G5Eng+$G6Eng;
											  $TotScie=$KinScie+$G1Scie+$G2Scie+$G3Scie+$G4Scie+$G5Scie+$G6Scie;
											  $TotMath=$KinMath+$G1Math+$G2Math+$G3Math+$G4Math+$G5Math+$G6Math;
											  $TotFil=$KinFil+$G1Fil+$G2Fil+$G3Fil+$G4Fil+$G5Fil+$G6Fil;
											  $TotAral=$KinAral+$G1Aral+$G2Aral+$G3Aral+$G4Aral+$G5Aral+$G6Aral;
											  $TotESP=$KinESP+$G1ESP+$G2ESP+$G3ESP+$G4ESP+$G5ESP+$G6ESP;
											  $TotTLE=$KinTLE+$G1TLE+$G2TLE+$G3TLE+$G4TLE+$G5TLE+$G6TLE;
											  $TotMAPEH=$KinMAPEH+$G1MAPEH+$G2MAPEH+$G3MAPEH+$G4MAPEH+$G5MAPEH+$G6MAPEH;
											  $TotMT=$KinMT+$G1MT+$G2MT+$G3MT+$G4MT+$G5MT+$G6MT;
											  $Total=$TotEng+$TotScie+$TotMath+$TotFil+$TotAral+$TotESP+$TotTLE+$TotMAPEH+$TotMT;
											echo '<tr>
													<th style="text-align:center;" colspan="2">Total</th>
													<td style="text-align:center;">'.number_format($TotEng,0).'</td>
													<td style="text-align:center;">'.number_format($TotScie,0).'</td>
													<td style="text-align:center;">'.number_format($TotMath,0).'</td>
													<td style="text-align:center;">'.number_format($TotFil,0).'</td>
													<td style="text-align:center;">'.number_format($TotAral,0).'</td>
													<td style="text-align:center;">'.number_format($TotESP,0).'</td>
													<td style="text-align:center;">'.number_format($TotTLE,0).'</td>
													<td style="text-align:center;">'.number_format($TotMAPEH,0).'</td>
													<td style="text-align:center;">'.number_format($TotMT,0).'</td>
													<td style="text-align:center;">'.number_format($TotMT,0).'</td>
													<td style="text-align:center;">'.number_format($Total,0).'</td>
											</tr>';
											?>
									</tbody>
									</table><!--End of Elementary-->
									
									 <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th colspan="17">SECONDARY SCHOOL</th>
											</tr>
											<tr>
															        <th width="7%" style="text-align:center;" rowspan="2">#</th>
																	<th width="15%" style="text-align:center;" rowspan="2">GRADE LEVEL</th>
																	<th colspan="12">JUNIOR HIGH LEARNING AREAS</th>
																	<th width="10%" rowspan="2">TOTAL</th>
																	<th width="7%" rowspan="2"></th>
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
																<td>RO Thematic</td>
															</tr>
									</thead>
									<tbody>
									<?php
									//GRADE 7
											$G7Eng=$G7Scie=$G7Math=$G7Fil=$G7Aral=$G7ESP=$G7TLE=$G7MUSIC=$G7ARTS=$G7PE=$G7HEALTH=$G7THEMATIC=$G7Total=0;
											  $myG7=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='7' AND WeekNo='".$_GET['id']."'");
											  while($G7row=mysqli_fetch_array($myG7))
											  {
												$G7Eng = $G7Eng + $G7row['English'];  
												$G7Scie = $G7Scie + $G7row['Science'];  
												$G7Math = $G7Math + $G7row['Math'];  
												$G7Fil = $G7Fil + $G7row['Filipino'];  
												$G7Aral = $G7Aral + $G7row['AralPan'];  
												$G7ESP = $G7ESP + $G7row['ESP'];  
												$G7TLE = $G7TLE + $G7row['TLE'];  
												$G7MUSIC = $G7MUSIC + $G7row['Music'];  
												$G7ARTS = $G7ARTS + $G7row['Arts'];  
												$G7PE = $G7PE + $G7row['PE'];  
												$G7HEALTH = $G7HEALTH + $G7row['Health'];  
												$G7THEMATIC = $G7THEMATIC + $G7row['RO_Thematic'];  
											  }
											  $G7Total=$G7Eng+$G7Scie+$G7Math+$G7Fil+$G7Aral+$G7ESP+$G7TLE+$G7MUSIC+$G7ARTS+$G7PE+$G7HEALTH+$G7THEMATIC;
											echo '<tr>
													<td style="text-align:center;">1</td>
													<td style="text-align:center;">Grade 7</td>
													<td style="text-align:center;">'.number_format($G7Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G7Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G7Math,0).'</td>
													<td style="text-align:center;">'.number_format($G7Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G7Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G7ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G7TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G7MUSIC,0).'</td>
													<td style="text-align:center;">'.number_format($G7ARTS,0).'</td>
													<td style="text-align:center;">'.number_format($G7PE,0).'</td>
													<td style="text-align:center;">'.number_format($G7HEALTH,0).'</td>
													<td style="text-align:center;">'.number_format($G7THEMATIC,0).'</td>
													<td style="text-align:center;">'.number_format($G7Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=7" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
												//GRADE 8
											$G8Eng=$G8Scie=$G8Math=$G8Fil=$G8Aral=$G8ESP=$G8TLE=$G8MUSIC=$G8ARTS=$G8PE=$G8HEALTH=$G8THEMATIC=$G8Total=0;
											  $myG8=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='8' AND WeekNo='".$_GET['id']."'");
											  while($G8row=mysqli_fetch_array($myG8))
											  {
												$G8Eng = $G8Eng + $G8row['English'];  
												$G8Scie = $G8Scie + $G8row['Science'];  
												$G8Math = $G8Math + $G8row['Math'];  
												$G8Fil = $G8Fil + $G8row['Filipino'];  
												$G8Aral = $G8Aral + $G8row['AralPan'];  
												$G8ESP = $G8ESP + $G8row['ESP'];  
												$G8TLE = $G8TLE + $G8row['TLE'];  
												$G8MUSIC = $G8MUSIC + $G8row['Music'];  
												$G8ARTS = $G8ARTS + $G8row['Arts'];  
												$G8PE = $G8PE + $G8row['PE'];  
												$G8HEALTH = $G8HEALTH + $G8row['Health'];  
												$G8THEMATIC = $G8THEMATIC + $G8row['RO_Thematic'];  
											  }
											  $G8Total=$G8Eng+$G8Scie+$G8Math+$G8Fil+$G8Aral+$G8ESP+$G8TLE+$G8MUSIC+$G8ARTS+$G8PE+$G8HEALTH+$G8THEMATIC;
											echo '<tr>
													<td style="text-align:center;">2</td>
													<td style="text-align:center;">Grade 8</td>
													<td style="text-align:center;">'.number_format($G8Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G8Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G8Math,0).'</td>
													<td style="text-align:center;">'.number_format($G8Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G8Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G8ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G8TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G8MUSIC,0).'</td>
													<td style="text-align:center;">'.number_format($G8ARTS,0).'</td>
													<td style="text-align:center;">'.number_format($G8PE,0).'</td>
													<td style="text-align:center;">'.number_format($G8HEALTH,0).'</td>
													<td style="text-align:center;">'.number_format($G8THEMATIC,0).'</td>
													<td style="text-align:center;">'.number_format($G8Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=8" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';	
												//GRADE 9
											$G9Eng=$G9Scie=$G9Math=$G9Fil=$G9Aral=$G9ESP=$G9TLE=$G9MUSIC=$G9ARTS=$G9PE=$G9HEALTH=$G9THEMATIC=$G9Total=0;
											  $myG9=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='9' AND WeekNo='".$_GET['id']."'");
											  while($G9row=mysqli_fetch_array($myG9))
											  {
												$G9Eng = $G9Eng + $G9row['English'];  
												$G9Scie = $G9Scie + $G9row['Science'];  
												$G9Math = $G9Math + $G9row['Math'];  
												$G9Fil = $G9Fil + $G9row['Filipino'];  
												$G9Aral = $G9Aral + $G9row['AralPan'];  
												$G9ESP = $G9ESP + $G9row['ESP'];  
												$G9TLE = $G9TLE + $G9row['TLE'];  
												$G9MUSIC = $G9MUSIC + $G9row['Music'];  
												$G9ARTS = $G9ARTS + $G9row['Arts'];  
												$G9PE = $G9PE + $G9row['PE'];  
												$G9HEALTH = $G9HEALTH + $G9row['Health'];  
												$G9THEMATIC = $G9THEMATIC + $G9row['RO_Thematic'];  
											  }
											  $G9Total=$G9Eng+$G9Scie+$G9Math+$G9Fil+$G9Aral+$G9ESP+$G9TLE+$G9MUSIC+$G9ARTS+$G9PE+$G9HEALTH+$G9THEMATIC;
											echo '<tr>
													<td style="text-align:center;">3</td>
													<td style="text-align:center;">Grade 9</td>
													<td style="text-align:center;">'.number_format($G9Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G9Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G9Math,0).'</td>
													<td style="text-align:center;">'.number_format($G9Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G9Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G9ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G9TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G9MUSIC,0).'</td>
													<td style="text-align:center;">'.number_format($G9ARTS,0).'</td>
													<td style="text-align:center;">'.number_format($G9PE,0).'</td>
													<td style="text-align:center;">'.number_format($G9HEALTH,0).'</td>
													<td style="text-align:center;">'.number_format($G9THEMATIC,0).'</td>
													<td style="text-align:center;">'.number_format($G9Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=9" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											//GRADE 10
											$G10Eng=$G10Scie=$G10Math=$G10Fil=$G10Aral=$G10ESP=$G10TLE=$G10MUSIC=$G10ARTS=$G10PE=$G10HEALTH=$G10THEMATIC=$G10Total=0;
											  $myG10=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='10' AND WeekNo='".$_GET['id']."'");
											  while($G10row=mysqli_fetch_array($myG10))
											  {
												$G10Eng = $G10Eng + $G10row['English'];  
												$G10Scie = $G10Scie + $G10row['Science'];  
												$G10Math = $G10Math + $G10row['Math'];  
												$G10Fil = $G10Fil + $G10row['Filipino'];  
												$G10Aral = $G10Aral + $G10row['AralPan'];  
												$G10ESP = $G10ESP + $G10row['ESP'];  
												$G10TLE = $G10TLE + $G10row['TLE'];  
												$G10MUSIC = $G10MUSIC + $G10row['Music'];  
												$G10ARTS = $G10ARTS + $G10row['Arts'];  
												$G10PE = $G10PE + $G10row['PE'];  
												$G10HEALTH = $G10HEALTH + $G10row['Health'];  
												$G10THEMATIC = $G10THEMATIC + $G10row['RO_Thematic'];  
											  }
											  $G10Total=$G10Eng+$G10Scie+$G10Math+$G10Fil+$G10Aral+$G10ESP+$G10TLE+$G10MUSIC+$G10ARTS+$G10PE+$G10HEALTH+$G10THEMATIC;
											
											echo '<tr>
													<td style="text-align:center;">4</td>
													<td style="text-align:center;">Grade 10</td>
													<td style="text-align:center;">'.number_format($G10Eng,0).'</td>
													<td style="text-align:center;">'.number_format($G10Scie,0).'</td>
													<td style="text-align:center;">'.number_format($G10Math,0).'</td>
													<td style="text-align:center;">'.number_format($G10Fil,0).'</td>
													<td style="text-align:center;">'.number_format($G10Aral,0).'</td>
													<td style="text-align:center;">'.number_format($G10ESP,0).'</td>
													<td style="text-align:center;">'.number_format($G10TLE,0).'</td>
													<td style="text-align:center;">'.number_format($G10MUSIC,0).'</td>
													<td style="text-align:center;">'.number_format($G10ARTS,0).'</td>
													<td style="text-align:center;">'.number_format($G10PE,0).'</td>
													<td style="text-align:center;">'.number_format($G10HEALTH,0).'</td>
													<td style="text-align:center;">'.number_format($G10THEMATIC,0).'</td>
													<td style="text-align:center;">'.number_format($G10Total,0).'</td>
													<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=10" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											$EngTotal=$ScieTotal=$MathTotal=$FilTotal=$AralTotal=$ESPTotal=$TLETotal=$MUSICTotal=$ARTSTotal=$PETotal=$HEALTHTotal=$THEMATICTotal=$SubTotal=0;
											$EngTotal=$G7Eng+$G8Eng+$G9Eng+$G10Eng;
											$ScieTotal=$G7Scie+$G8Scie+$G9Scie+$G10Scie;
											$MathTotal=$G7Math+$G8Math+$G9Math+$G10Math;
											$FilTotal=$G7Fil+$G8Fil+$G9Fil+$G10Fil;
											$AralTotal=$G7Aral+$G8Aral+$G9Aral+$G10Aral;
											$ESPTotal=$G7ESP+$G8ESP+$G9ESP+$G10ESP;
											$TLETotal=$G7TLE+$G8TLE+$G9TLE+$G10TLE;
											$MUSICTotal=$G7MUSIC+$G8MUSIC+$G9MUSIC+$G10MUSIC;
											$ARTSTotal=$G7ARTS+$G8ARTS+$G9ARTS+$G10ARTS;
											$PETotal=$G7PE+$G8PE+$G9PE+$G10PE;
											$HEALTHTotal=$G7HEALTH+$G8HEALTH+$G9HEALTH+$G10HEALTH;
											$THEMATICTotal=$G7THEMATIC+$G8THEMATIC+$G9THEMATIC+$G10THEMATIC;
											$SubTotal=$G7Total+$G8Total+$G9Total+$G10Total;
											echo '<tr>
													
													<th style="text-align:center;" colspan="2">Total</th>
													<td style="text-align:center;">'.number_format($EngTotal,0).'</td>
													<td style="text-align:center;">'.number_format($ScieTotal,0).'</td>
													<td style="text-align:center;">'.number_format($MathTotal,0).'</td>
													<td style="text-align:center;">'.number_format($FilTotal,0).'</td>
													<td style="text-align:center;">'.number_format($AralTotal,0).'</td>
													<td style="text-align:center;">'.number_format($ESPTotal,0).'</td>
													<td style="text-align:center;">'.number_format($TLETotal,0).'</td>
													<td style="text-align:center;">'.number_format($MUSICTotal,0).'</td>
													<td style="text-align:center;">'.number_format($ARTSTotal,0).'</td>
													<td style="text-align:center;">'.number_format($PETotal,0).'</td>
													<td style="text-align:center;">'.number_format($HEALTHTotal,0).'</td>
													<td style="text-align:center;">'.number_format($THEMATICTotal,0).'</td>
													<td style="text-align:center;">'.number_format($SubTotal,0).'</td>
													
											</tr>';
												?>
									</tbody>
									</table><!--end secondary-->
										<?php
										$subTotalCore11=$subTotalCore12=$subTotalApp11=$subTotalApp12=$subTotalSpec11=$subTotalSpec12=0;
										?>
										<table width="100%" class="table table-striped table-bordered table-hover"><!--senior high secondary-->
										<thead>
											<tr>
												<th colspan="17">SENIOR HIGH SCHOOL</th>
											</tr>
											<tr>
															        <th width="7%" style="text-align:center;" rowspan="2">#</th>
																	<th width="30%" style="text-align:center;" rowspan="2">LEARNING AREAS</th>
																	<th colspan="2">CORE SUBJECTS</th>
																	<th colspan="2">APPLIED SUBJECTS</th>
																	<th colspan="2">SPECIALIZED SUBJECTS</th>
																	<th width="7%" rowspan="2"></th>
															</tr>
															<tr>
																<td style="text-align:center;">GRADE 11</td>
																<td style="text-align:center;">GRADE 12</td>
																<td style="text-align:center;">GRADE 11</td>
																<td style="text-align:center;">GRADE 12</td>
																<td style="text-align:center;">GRADE 11</td>
																<td style="text-align:center;">GRADE 12</td>																
															</tr>
												</thead>
												<tbody>
												<?php
												//Grade11 Core Subject
												$no=$g11TotalCore=$g12TotalCore=0;
												$grade11core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12345' AND tbl_shs_report.WeekNo='".$_GET['id']."' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g11rowcore=mysqli_fetch_array($grade11core))
												{
													$no++;
													$g11TotalCore=$g11TotalCore+$g11rowcore['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g11rowcore['SubStrandDescription'].'</td>
														<td>'.$g11TotalCore.'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=11&Type=12345&Code='.$g11rowcore['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
													$subTotalCore11=$subTotalCore11	+ $g11TotalCore;										
												}
												//Grade 12 core subject
												$grade12core=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12345'AND tbl_shs_report.WeekNo='".$_GET['id']."' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g12rowcore=mysqli_fetch_array($grade12core))
												{
													$no++;
													$g12TotalCore=$g12TotalCore+$g12rowcore['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g12rowcore['SubStrandDescription'].'</td>
														<td>0</td>
														<td>'.$g12TotalCore.'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=12&Type=12345&Code='.$g12rowcore['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
													$subTotalCore12=$subTotalCore12+$g12TotalCore;											
												}
												
												
												//Grade11 Applied Subject
												$g11TotalApp=$g12TotalApp=0;
												$grade11App=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.WeekNo='".$_GET['id']."' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g11rowApp=mysqli_fetch_array($grade11App))
												{
													$no++;
													$g11TotalApp=$g11TotalApp+$g11rowApp['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g11rowApp['SubStrandDescription'].'</td>
														
														<td>0</td>
														<td>0</td>
														<td>'.$g11TotalApp.'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=11&Type=12346&Code='.$g11rowApp['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
												$subTotalApp11=$subTotalApp11+$g11TotalApp;												
												}
												//Grade 12 Applied subject
												$grade12App=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12346' AND tbl_shs_report.WeekNo='".$_GET['id']."' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g12rowApp=mysqli_fetch_array($grade12App))
												{
													$no++;
													$g12TotalApp=$g12TotalApp+$g12rowApp['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g12rowApp['SubStrandDescription'].'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>'.$g12TotalApp.'</td>
														<td>0</td>
														<td>0</td>
														
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=12&Type=12346&Code='.$g12rowApp['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
												$subTotalApp12=$subTotalApp12+$g12TotalApp;												
												}
											
											//Grade11 Specialized Subject
												$g11TotalSpec=$g12TotalSpec=0;
												$grade11Spec=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='11' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12347' AND tbl_shs_report.WeekNo='".$_GET['id']."' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g11rowSpec=mysqli_fetch_array($grade11Spec))
												{
													$no++;
													$g11TotalSpec=$g11TotalSpec+$g11rowSpec['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g11rowSpec['SubStrandDescription'].'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>'.$g11TotalSpec.'</td>
														<td>0</td>
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=11&Type=12347&Code='.$g11rowSpec['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
												$subTotalSpec11=$subTotalSpec11+$g11TotalSpec;													
												}
												//Grade 12 Specialized subject
												$grade12Spec=mysqli_query($con,"SELECT * FROM tbl_shs_report INNER JOIN tbl_senior_sub_strand ON tbl_shs_report.SubCode=tbl_senior_sub_strand.StrandsubCode WHERE tbl_shs_report.GradeLevel='12' AND tbl_shs_report.Developedby='Central' AND tbl_shs_report.Subject_type='12347' ORDER BY tbl_shs_report.WeekNo Asc");
												while($g12rowSpec=mysqli_fetch_array($grade12Spec))
												{
													$no++;
													$g12TotalSpec=$g12TotalSpec+$g12rowSpec['No_of_copies'];													
													
												echo '<tr>
														<th>'.$no.'</th>
														<td>'.$g12rowSpec['SubStrandDescription'].'</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>0</td>
														<td>'.$g12TotalSpec.'</td>
														
														<td style="text-align:center;"><a href="view-school.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c&GL=12&Type=12347&Code='.$g12rowSpec['StrandsubCode'].'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
											</tr>';
													$subTotalSpec12=$subTotalSpec12+$g12TotalSpec;													
												}
												
											echo '<tr>
													<th colspan="2">Total:</th>
													
													<td>'.$subTotalCore11.'</td>
													<td>'.$subTotalCore12.'</td>
													<td>'.$subTotalApp11.'</td>
													<td>'.$subTotalApp12.'</td>
													<td>'.$subTotalSpec11.'</td>
													<td>'.$subTotalSpec12.'</td>
													
													
																
												</tr>';
												?>
												
												</tbody>
												</table>