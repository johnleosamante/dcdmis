	<div class="col-lg-6">
					      <div class="panel panel-default">
                                    <div class="panel-heading">
									<h4>IPCRF CONSOL SUMMARY</h4>				 
                                     </div>
								<div class="panel-body" style="overflow-x:auto;">							
																
								
									<table width="100%" class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" rowspan="2">Profecientcy</th>
                                        <th style="text-align:center;" rowspan="2">Position</th>
                                        <th style="text-align:center;" colspan="5">Adjectival Rating</th>
                                        <th style="text-align:center;" rowspan="2">Total</th>
                                    </tr>
									<tr>
										<th style="text-align:center;">Poor</th>
										<th style="text-align:center;">UnSatisfactory</th>
										<th style="text-align:center;">Satisfactory</th>
										<th style="text-align:center;">Very Satisfactory</th>
										<th style="text-align:center;">Outstanding</th>
									</tr>
                                </thead>
                                <tbody>
								<tr>
									<th rowspan="6">PROFICIENT</th>
									<td>SPET 1</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
								</tr>
								<tr>
									<td>SPET 2</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>						
								</tr>
								<tr>
									<td>SPET 3</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
								</tr>
								<tr>
									<td>TEACHER I</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
								</tr>
								<tr>
									<td>TEACHER II</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
								</tr>
								<tr>
									<td>TEACHER III</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
								</tr>
								</tbody>
								</table>
					</div>
				</div>
				</div>
				    <div class="col-lg-6">
				            <div class="panel panel-default">
                                    <div class="panel-heading">
								<?php	
								  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("view_ipcrf_by_school")).'" style="float:right;" class="btn btn-primary">VIEW BY SCHOOL</a>';
								 ?>
									<h4>INDIVIDUAL PERFORMANCE COMMITMENT AND REVIEW FORM (IPCRF)</h4>				 
                                     </div>
								<div class="panel-body" style="overflow-x:auto;">							
																
								
									<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Name</th>
                                        <th>School</th>
                                        <th width="10%" style="text-align:center;">School Year</th>
                                        <th width="15%" style="text-align:center;">Position</th>
                                        <th width="10%" style="text-align:center;">Rating</th>
                                        <th width="10%" style="text-align:center;">Remarks</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
												<?php
												$no=0;
												$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated INNER JOIN tbl_school_year ON tbl_ipcrf_consolidated.SchoolYear = tbl_school_year.SYCode INNER JOIN tbl_job ON tbl_ipcrf_consolidated.Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_ipcrf_consolidated.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_school ON tbl_ipcrf_consolidated.SchoolID = tbl_school.SchoolID WHERE tbl_ipcrf_consolidated.SchoolYear='2021' ORDER BY tbl_employee.Emp_LName Asc");
												while($rowdata=mysqli_fetch_array($result))
												{
													$no++;
													echo '<tr>
														     <td>'.$no.'</td>
														       <td>'.$rowdata['Emp_LName'].', '.$rowdata['Emp_FName'].'</td>
														       <td>'.$rowdata['SchoolName'].'</td>
														       <td style="text-align:center;">'.$rowdata['SchoolYear'].'</td>
														       <td style="text-align:center;">'.$rowdata['Job_description'].'</td>
														      <td style="text-align:center;">'.$rowdata['RatingScore'].'</td>
														    <td style="text-align:center;">'.$rowdata['RatingAdjective'].'</td>
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
             
				