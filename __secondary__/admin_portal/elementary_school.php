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
													<td style="text-align:center;">Project Rush</td>
													<td style="text-align:center;">Total</td>
											
											</tr>
									</thead>
									<tbody>
									  <?php 
									   $TotEng=$TotScie=$TotMath=$TotFil=$TotAral=$TotESP=$TotTLE=$TotMAPEH=$TotMT=$Total=$TotPR=$TotRO=0;
									  $KinEng=$KinScie =$KinMath=$KinFil=$KinAral=$KinESP=$KinTLE=$KinMAPEH=$KinMT=$KinRO=$KinTotal=$KinPR=0;
									  $mydata=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='Kinder' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
										//$KinRO = $KinRO + $kinderrow['RO_Thematic'];  
										$KinPR = $KinPR + $kinderrow['Project_Rush'];  
									  }
									  $KinTotal=$KinEng+$KinScie+$KinMath+$KinFil+$KinAral+$KinESP+$KinTLE+$KinMAPEH+$KinMT+$KinPR;
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
													<td style="text-align:center;">'.number_format($KinPR,0).'</td>
													
													<td style="text-align:center;">'.number_format($KinTotal,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("Kinder")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
									  $G1Eng=$G1Scie=$G1Math=$G1Fil=$G1Aral=$G1ESP=$G1TLE=$G1MAPEH=$G1MT=$G1RO=$G1Total=$G1PR=0;
									  $myG1=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='1' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
										//$G1RO = $G1RO + $G1row['RO_Thematic'];  
										$G1PR = $G1PR + $G1row['Project_Rush'];  
									  }
									  $G1Total=$G1Eng+$G1Scie+$G1Math+$G1Fil+$G1Aral+$G1ESP+$G1TLE+$G1MAPEH+$G1MT+$G1PR;
											
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
													<td style="text-align:center;">'.number_format($G1PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G1Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
									  $G2Eng=$G2Scie=$G2Math=$G2Fil=$G2Aral=$G2ESP=$G2TLE=$G2MAPEH=$G2MT=$G2Total=$G2RO=$G2PR=0;
									  $myG2=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='2' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
										//$G2RO = $G2RO + $G2row['RO_Thematic'];  
										$G2PR = $G2PR + $G2row['Project_Rush'];  
									  }
									  $G2Total=$G2Eng+$G2Scie+$G2Math+$G2Fil+$G2Aral+$G2ESP+$G2TLE+$G2MAPEH+$G2MT+$G2PR;
											
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
													<td style="text-align:center;">'.number_format($G2PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G2Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("2")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G3Eng=$G3Scie=$G3Math=$G3Fil=$G3Aral=$G3ESP=$G3TLE=$G3MAPEH=$G3MT=$G3RO=$G3Total=$G3PR=0;
											  $myG3=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='3' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G3RO = $G3RO + $G3row['RO_Thematic'];  
												$G3PR = $G3PR + $G3row['Project_Rush'];  
											  }
											  $G3Total=$G3Eng+$G3Scie+$G3Math+$G3Fil+$G3Aral+$G3ESP+$G3TLE+$G3MAPEH+$G3MT+$G3PR;
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
													<td style="text-align:center;">'.number_format($G3PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G3Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("3")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>
											';
											 $G4Eng=$G4Scie=$G4Math=$G4Fil=$G4Aral=$G4ESP=$G4TLE=$G4MAPEH=$G4MT=$G4RO=$G4Total=$G4PR=0;
											  $myG4=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='4' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G4RO = $G4RO + $G4row['RO_Thematic']; 
												$G4PR = $G4PR + $G4row['Project_Rush'];  												
											  }
											  $G4Total=$G4Eng+$G4Scie+$G4Math+$G4Fil+$G4Aral+$G4ESP+$G4TLE+$G4MAPEH+$G4MT+$G4PR;
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
													<td style="text-align:center;">'.number_format($G4PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G4Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("4")).'&v='.urlencode(base64_encode("view-school")).'" title="View School"> <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G5Eng=$G5Scie=$G5Math=$G5Fil=$G5Aral=$G5ESP=$G5TLE=$G5MAPEH=$G5MT=$G5Total=$G5RO=$G5PR=0;
											  $myG5=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='5' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G5RO = $G5RO + $G5row['RO_Thematic'];  
												$G5PR = $G5PR + $G2row['Project_Rush'];  
											  }
											  $G5Total=$G5Eng+$G5Scie+$G5Math+$G5Fil+$G5Aral+$G5ESP+$G5TLE+$G5MAPEH+$G5MT+$G5RO+$G5PR+$G5PR;
											   
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
													<td style="text-align:center;">'.number_format($G5PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G5Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("5")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											 $G6Eng=$G6Scie=$G6Math=$G6Fil=$G6Aral=$G6ESP=$G6TLE=$G6MAPEH=$G6MT=$G6RO=$G6Total=$G6PR=0;
											  $myG6=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE GradeLevel='6' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G6RO = $G6RO + $G6row['RO_Thematic'];  
												$G6PR = $G6PR + $G6row['Project_Rush'];  
											  }
											  $G6Total=$G6Eng+$G6Scie+$G6Math+$G6Fil+$G6Aral+$G6ESP+$G6TLE+$G6MAPEH+$G6MT+$G6RO+$G6PR;
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
													<td style="text-align:center;">'.number_format($G6PR,0).'</td>
													
													<td style="text-align:center;">'.number_format($G6Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("6")).'&v='.urlencode(base64_encode("view-school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
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
											//  $TotRO=$KinRO+$G1RO+$G2RO+$G3RO+$G4RO+$G5RO+$G6RO;
											  $TotPR=$KinPR+$G1PR+$G2PR+$G3PR+$G4PR+$G5PR+$G6PR;
											  
											  $Total=$TotEng+$TotScie+$TotMath+$TotFil+$TotAral+$TotESP+$TotTLE+$TotMAPEH+$TotMT+$TotPR;
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
													<td style="text-align:center;">'.number_format($TotPR,0).'</td>
													
													<td style="text-align:center;">'.number_format($Total,0).'</td>
											</tr>';
											?>
									</tbody>
									</table><!--End of Elementary-->
																		