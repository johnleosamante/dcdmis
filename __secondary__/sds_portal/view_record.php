<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
	date_default_timezone_set("Asia/Manila");
	$_SESSION['currentdate']=$_GET['id'];
		
?>
									
									
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">NAME</th>
									<th rowspan="2">DATE</th>
									<th colspan="2" style="text-align:center;">MORNING LOG</th>
									<th colspan="2" style="text-align:center;">AFTERNOON LOG</th>
								</tr>
								<tr>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
			
								</tr>
                                </thead>
                                <tbody>
								
								<?php
								$no=0;
									$mydtrrecord=mysqli_query($con,"SELECT * FROM tbl_dtr INNER JOIN tbl_employee ON tbl_dtr.Emp_ID=tbl_employee.Emp_ID WHERE tbl_dtr.DTRDate = '".$_GET['id']."' ORDER BY tbl_dtr.TimeINAM Asc");
										while($DTRRow=mysqli_fetch_array($mydtrrecord))
										{
											$no++;
											echo '<tr>
												   <td>'.$no.'</td>
													<td>'.$DTRRow['Emp_LName'].', '.$DTRRow['Emp_FName'].'</td>
													<td style="text-align:center;">'.$DTRRow['DTRDate'].'</td>
													<td style="text-align:center;">'.$DTRRow['TimeINAM'].'</td>
													<td style="text-align:center;">'.$DTRRow['TimeOUTAM'].'</td>
													<td style="text-align:center;">'.$DTRRow['TimeINPM'].'</td>
												  <td style="text-align:center;">'.$DTRRow['TimeOUTPM'].'</td>
												</tr>';
									}
									?>
									
                                </tbody>
                            </table>									