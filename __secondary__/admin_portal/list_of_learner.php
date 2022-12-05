		 
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>				
	            <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4>List of Registered Learner's</h4>
							</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
													
							
                            <?php
							$tot=$totm=$totf=0;
							
								echo ' <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="width:5%;">#</th>
												<th style="width:15%;">Date Time Register</th>
												<th>Learner\'s Name</th>
												 <th width="10%">Gender</th>
												<th style="text-align:center;width:15%;">Grade Level</th>
												
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										
										
										$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['SchoolID']."'  ORDER BY tbl_student.Lname Asc");
										
									while($row=mysqli_fetch_array($myinfo))
									{
										$no++;
                                      echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Date_enrolled'].'</td>
											<td>'.utf8_encode($row['Lname'].', '.$row['FName'].' '.$row['MName']).'</td>
											<td>'.$row['Gender'].'</td>';
											if($row['Grade']=='Kinder')
											{
											echo '<td>'.$row['Grade'].'</td>';
												
											}else{
											echo '<td>Grade '.$row['Grade'].'</td>';
											}
												
                                        echo '</tr>';
                                    
									}	
																		
										echo '</tbody>
									</table>';
						
							
							
							?>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           
