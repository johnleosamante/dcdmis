
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   
                       <form action="submit_participant.php" Method="POST" enctype="multipart/form-data">
                            <?php
							$_SESSION['code']=$_GET['code'];
									
										
							echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_activity")).'" class="btn btn-success" style="float:right;">Back</a>
						 <!-- /.panel-heading -->
						 <h3 class="modal-title">LIST OF SCHOOLS</h3>	
                        			
						 </div>
						<div class="panel-body"> ';
						 echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    
                                <thead>
                                    <tr>
                                       	<th style="width:3%;text-align:center;" >#</th>
										<th style="width:25%;">School Name</th>						
										<th style="text-align:center;width:5%;">Select</th>
                                    </tr>
									
										                                </thead>
                                <tbody>';
								
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school  WHERE tbl_school.SchoolID <>'123131' ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									$no=$m=$f=$t=0;
									while($r = mysqli_fetch_assoc($recstudent)) {
										
										$no++;
										print '<td style="text-align:center;">'.$no.'</td>';
										print '<td>'.$r['SchoolName'].'</td>
																			
											<td class="dropdown">
												<center><input type="radio" name="part-'.$no.'" value="'.$r['SchoolID'].'" title="part-'.$no.'"></center>	
														
											</td>
                                        </tr>';
                                    
									}						
									
                               echo '</tbody>
                            </table>';
							?>
					 <input type="submit" class="btn btn-primary" name="submit_data" value="SUBMIT">
					</form> 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
          