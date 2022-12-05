       <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>NAME</th>
                                        <th width="10%" style="text-align:center;">Grade Level</th>
                                        <th width="10%" style="text-align:center;">Date Taken</th>
                                        <th width="10%" style="text-align:center;">No. of Item</th>
                                        <th width="10%" style="text-align:center;">Score</th>
                                                                               
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								session_start();
								include_once("../../pcdmis/vendor/jquery/function.php");
								$_SESSION['CurrentDate']=$_GET['id'];
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_pisa_participant WHERE SchoolID ='".$_SESSION['school_id']."' ORDER BY ParticipantName Asc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								    $mon=mysqli_query($con,"SELECT * FROM tbl_pisa_monitoring WHERE LRN='".$row['LRN']."' AND SubCode='".$_SESSION['SubCode']."' AND SchoolID='".$_SESSION['school_id']."' AND date_taken ='".$_GET['id']."'");
									$rowscore=mysqli_fetch_assoc($mon);	
								 echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['ParticipantName'].'</td>
											<td style="text-align:center;">'.$row['Grade_Level'].'</td>
											<td style="text-align:center;">'.$rowscore['date_taken'].'</td>
											<td style="text-align:center;">'.$rowscore['ItemNo'].'</td>
											<td style="text-align:center;">'.$rowscore['Score'].'</td>
											
										</tr>';
								}
								?>
                                </tbody>
                            </table>