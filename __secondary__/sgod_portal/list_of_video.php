
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
				  <h2>List of Videos</h2>
				  					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="10%">DATE SUBMITTED</th>											
												<th width="25%">SCHOOL NAME </th>
												<th width="15%">GROUP NAME</th>
												<th width="15%">DISTRICT</th>
												<th width="20%">TEACHER NAME</th>
												<th width="15%">CONTACT #</th>
												<th width="7%"></th>
											</tr>
																				
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$mypost=mysqli_query($con,"SELECT * FROM tbl_wtd ORDER BY Date_post Asc");
									while($row=mysqli_fetch_array($mypost))
									{
										$no++;
									echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Date_post'].'</td>
											<td>'.$row['SchoolName'].'</td>
											<td>'.$row['GroupName'].'</td>
											<td>'.$row['District'].'</td>
											<td>'.$row['TeacherRep'].'</td>
											<td>'.$row['ContactNo'].'</td>
											<td style="text-align:center;"><a href="../files/videos/'.$row['Filename'].'" title="Click to view Video" target="_blank"> <i class="fa   fa-desktop  fa"></i></a></td>
										</tr>';	
									}
									?>
									</tr>
									</tbody>
									</table>
									
								</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               