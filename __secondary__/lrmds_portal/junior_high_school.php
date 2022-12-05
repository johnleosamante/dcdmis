 <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th colspan="17">SECONDARY SCHOOL</th>
											</tr>
											<tr>
															        <th width="7%" style="text-align:center;" rowspan="2">#</th>
																	<th width="15%" style="text-align:center;" rowspan="2">GRADE LEVEL</th>
																	<th colspan="11">JUNIOR HIGH LEARNING AREAS</th>
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
																
															</tr>
									</thead>
									<tbody>
									<?php
									//GRADE 7
											$G7Eng=$G7Scie=$G7Math=$G7Fil=$G7Aral=$G7ESP=$G7TLE=$G7MUSIC=$G7ARTS=$G7PE=$G7HEALTH=$G7THEMATIC=$G7Total=0;
											  
											  $myG7=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='7' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
											  
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
												//$G7THEMATIC = $G7THEMATIC + $G7row['RO_Thematic'];  
											  }
											  $G7Total=$G7Eng+$G7Scie+$G7Math+$G7Fil+$G7Aral+$G7ESP+$G7TLE+$G7MUSIC+$G7ARTS+$G7PE+$G7HEALTH;
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
													<td style="text-align:center;">'.number_format($G7Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("7")).'&v='.urlencode(base64_encode("view_school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
												//GRADE 8
											$G8Eng=$G8Scie=$G8Math=$G8Fil=$G8Aral=$G8ESP=$G8TLE=$G8MUSIC=$G8ARTS=$G8PE=$G8HEALTH=$G8THEMATIC=$G8Total=0;
											  $myG8=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='8' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G8THEMATIC = $G8THEMATIC + $G8row['RO_Thematic'];  
											  }
											  $G8Total=$G8Eng+$G8Scie+$G8Math+$G8Fil+$G8Aral+$G8ESP+$G8TLE+$G8MUSIC+$G8ARTS+$G8PE+$G8HEALTH;
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
													
													<td style="text-align:center;">'.number_format($G8Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("8")).'&v='.urlencode(base64_encode("view_school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';	
												//GRADE 9
											$G9Eng=$G9Scie=$G9Math=$G9Fil=$G9Aral=$G9ESP=$G9TLE=$G9MUSIC=$G9ARTS=$G9PE=$G9HEALTH=$G9THEMATIC=$G9Total=0;
											  $myG9=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='9' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G9THEMATIC = $G9THEMATIC + $G9row['RO_Thematic'];  
											  }
											  $G9Total=$G9Eng+$G9Scie+$G9Math+$G9Fil+$G9Aral+$G9ESP+$G9TLE+$G9MUSIC+$G9ARTS+$G9PE+$G9HEALTH;
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
												
													<td style="text-align:center;">'.number_format($G9Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("9")).'&v='.urlencode(base64_encode("view_school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
											</tr>';
											//GRADE 10
											$G10Eng=$G10Scie=$G10Math=$G10Fil=$G10Aral=$G10ESP=$G10TLE=$G10MUSIC=$G10ARTS=$G10PE=$G10HEALTH=$G10THEMATIC=$G10Total=0;
											  $myG10=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE GradeLevel='10' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."'");
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
												//$G10THEMATIC = $G10THEMATIC + $G10row['RO_Thematic'];  
											  }
											  $G10Total=$G10Eng+$G10Scie+$G10Math+$G10Fil+$G10Aral+$G10ESP+$G10TLE+$G10MUSIC+$G10ARTS+$G10PE+$G10HEALTH;
											
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
													
													<td style="text-align:center;">'.number_format($G10Total,0).'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&GL='.urlencode(base64_encode("10")).'&v='.urlencode(base64_encode("view_school")).'" title="View School" > <i class="fa   fa-desktop  fa"></i></td>
										
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
											//$THEMATICTotal=$G7THEMATIC+$G8THEMATIC+$G9THEMATIC+$G10THEMATIC;
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
													
													<td style="text-align:center;">'.number_format($SubTotal,0).'</td>
													
											</tr>';
												?>
									</tbody>
									</table><!--end secondary-->