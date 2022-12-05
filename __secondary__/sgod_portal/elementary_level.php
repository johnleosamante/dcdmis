                 <h2></h2>
				 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=bGlzdF9vZl9hcHBsaWNhbnQ%3D" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;">Back</a>
                       <a href="#myapplicant" class="btn btn-primary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">NEW APPLICANT</a>
                        <!--<a href="download.php" class="btn btn-warning" style="float:right;padding:4px;margin:4px;">Download</a>
                      <a href="#myupload" class="btn btn-warning" style="float:right;padding:4px;margin:4px;" data-toggle="modal">UPLOAD</a>-->
						
						
				  <h2>List of elementary applicants</h2>
				  <?php
					 date_default_timezone_set("Asia/Manila");
					$dateposted = date("Y-m-d H:i:s");
				  if (isset($_POST['save_element']))
				  {
					  mysqli_query($con,"INSERT INTO tbl_applicant (Last_Name,First_Name,Middle_Name,Gender,Contact_No,Home_Address,Category,Year_Applied) VALUES('".$_POST['FName']."','".$_POST['GName']."','".$_POST['MName']."','".$_POST['sex']."','".$_POST['CellNo']."','".$_POST['homeaddress']."','ELEMENTARY','".$_POST['year']."')");
					if (mysqli_affected_rows($con)==1)
					{
						?>
							<script type="text/javascript">
							$(document).ready(function(){						
									$('#access').modal({
										show: 'true'
									}); 				
								});
							</script>
									
							 
					   <?php  
					}
				  }elseif (isset($_POST['new_rating']))
{
						echo $filename=$_FILES["uploaddata"]["tmp_name"];
							if($_FILES["uploaddata"]["size"] > 0)
								{
									$file = fopen($filename, "r");
									while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
									{
										mysqli_query($con,"INSERT INTO tbl_applicant (Last_Name,First_Name,Middle_Name,Gender,Contact_No,Home_Address,Category,Year_Applied)VALUES('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','ELEMENTARY','".$_SESSION['year']."')");
						
									}
									fclose($file);
								}
							else{
							echo 'Invalid File:Please Upload CSV File';
						}
						if (mysqli_affected_rows($con)==1)
						{
							?>
								<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
								</script>
														
												 
							<?php   
						}
					}
				  ?>
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="15%">FAMILY NAME</th>											
												<th width="15%">GIVEN NAME</th>
												<th width="15%">MIDDLE NAME</th>
												<th width="10%">SEX</th>
												<th width="10%">CONTACT #</th>
												<th>ADDRESS</th>
												<th>SCORE</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='ELEMENTARY' ORDER BY Last_Name Asc");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_applicant_rating WHERE ApplicanNo='".$row['Appl_No']."' LIMIT 1");
										$score=mysqli_fetch_assoc($myscore);
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Last_Name'].'</td>
												<td>'.$row['First_Name'].'</td>
												<td>'.$row['Middle_Name'].'</td>
												<td>'.$row['Gender'].'</td>
												<td>'.$row['Contact_No'].'</td>
												<td>'.$row['Home_Address'].'</td>
												<td>'.$score['OverALL'].'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&account='.urlencode(base64_encode($row['Appl_No'])).'&Category='.urlencode(base64_encode("ELEMENTARY")).'&v='.urlencode(base64_encode("individual_rating")).'">VIEW</a></td>
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
             
	
  <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="myupload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										 <div class="modal-header">
											  <h3 class="modal-title"><center>UPLOAD APPLICANT</center></h3>
											</div>
											<form action="" Method="POST" enctype="multipart/form-data">
											<div class="modal-body">
											 <label>UPLOAD FILE:</label>
											 <input type="file" name="uploaddata" required accept=".csv">
											</div>
										<div class="modal-footer">
										<input type="submit" name="new_rating" value="SUBMIT" class="btn btn-primary">
										  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
										</div>
										</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
	<!--../../pcdmis/'.$row['DownloadLocation'].'-->
	
			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myapplicant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h3 class="modal-title"><center>New Applicant Information</center></h3>
		  	
        </div>
		<form action="" Method="POST">
        <div class="modal-body">
		<label>FAMILY NAME: </label>
		<input type="text" class="form-control" name="FName" placeholder="Family Name" required>
		<label>GIVEN NAME: </label>
		<input type="text" class="form-control" name="GName" placeholder="Given Name" required>
		<label>MIDDLE NAME: </label>
		<input type="text" class="form-control" name="MName" placeholder="Middle Name" required>
		<label>SEX: </label>
		<select class="form-control" name="sex" required>
		  <option value="">--Select--</option>
		  <option value="MALE">MALE</option>
		  <option value="FEMALE">FEMALE</option>
		</select>
		<label>CONTACT #</label>
		<input type="number" class="form-control" name="CellNo" placeholder="Contact Number" required>
		<label>HOME ADDRESS</label>
		<textarea class="form-control" name="homeaddress" rows="2" required></textarea>
		<label>SCHOOL YEAR</label>
		<input type="text" class="form-control" name="year" placeholder="Contact Number" value="2021"required>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="save_element" Value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
	      </div>
      </div>
</div></div>
		
		
	