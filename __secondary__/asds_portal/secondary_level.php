                 <h2></h2>
				 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                    <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=bGlzdF9vZl9hcHBsaWNhbnQ%3D" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;">Back</a>
                       <a href="#myapplicant" class="btn btn-primary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">NEW APPLICANT</a>
						
						
				  <h2>List of secondary applicants</h2>
				  <?php
					 date_default_timezone_set("Asia/Manila");
					$dateposted = date("Y-m-d H:i:s");
					$_SESSION['ApplicantCat']="SECONDARY";
				  if (isset($_POST['save_element']))
				  {
					  mysqli_query($con,"INSERT INTO tbl_applicant VALUES('".date("ydms")."','".$_POST['FName']."','".$_POST['GName']."','".$_POST['MName']."','".$_POST['sex']."','".$_POST['CellNo']."','".$_POST['homeaddress']."','SECONDARY','".$_SESSION['year']."','".$_POST['Major']."','".$_POST['Status']."')");
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
				  }else if (isset($_POST['update_applicant']))
				  {
					  mysqli_query($con,"UPDATE tbl_applicant SET Last_Name='".$_POST['FName']."',First_Name='".$_POST['GName']."',Middle_Name='".$_POST['MName']."',Gender='".$_POST['sex']."',Contact_No='".$_POST['CellNo']."',Home_Address='".$_POST['homeaddress']."',Major='".$_POST['Major']."' WHERE Appl_No='".$_SESSION['AccountNo']."' LIMIT 1");
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
						<div class="col-lg-11">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="10%">FAMILY NAME</th>											
												<th width="10%">GIVEN NAME</th>
												<th width="10%">MIDDLE NAME</th>
												<th width="10%">SEX</th>
												<th width="10%">CONTACT #</th>
												<th>ADDRESS</th>
												<th>MAJOR</th>
												<th>STATUS</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='SECONDARY' ORDER BY Last_Name Asc");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Last_Name'].'</td>
												<td>'.$row['First_Name'].'</td>
												<td>'.$row['Middle_Name'].'</td>
												<td>'.$row['Gender'].'</td>
												<td>'.$row['Contact_No'].'</td>
												<td>'.$row['Home_Address'].'</td>
												<td>'.$row['Major'].'</td>
												<td>'.$row['Status'].'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&account='.urlencode(base64_encode($row['Appl_No'])).'&Category='.urlencode(base64_encode("SECONDARY")).'&v='.urlencode(base64_encode("individual_rating")).'" title="View Applicant Profile"><i class="fa fa-desktop fa-fw"></i></a> 
												     <a href="update_applicant.php?code='.urlencode(base64_encode($row['Appl_No'])).'" title="Edit Profile" data-toggle="modal" data-target="#editapplicant"><i class="fa  fa-external-link fa-fw"></i></a>
													 <a style="cursor:pointer;" onclick="delete_me(this.id)" id="'.$row['Appl_No'].'"><i class="fa  fa-trash fa-fw"></i></a>
													 </td>
												 </tr>';
									}
									?>
								
									</tbody>
									</table>
                            
                        </div>
						<div class="col-lg-1">
						  <a href="print_all/" class="btn btn-info" style="padding:4px;margin:4px;" target="_blank">ALL A > Z</a>
						  <a href="print_all_highest/" class="btn btn-info" style="padding:4px;margin:4px;" target="_blank">ALL H > L</a>
						  <a href="#major" class="btn btn-warning" style="padding:4px;margin:4px;" data-toggle="modal">MAJOR</a>
						  <a href="print_rqa/" class="btn btn-danger" style="padding:4px;margin:4px;" target="_blank">RQA POST</a>
						 <!-- <a href="print_sds_copy/" class="btn btn-info" style="padding:4px;margin:4px;" target="_blank">OSDS  COPY</a>
						 <a href="#signature" class="btn btn-success" style="padding:4px;margin:4px;"  data-toggle="modal">SIGNATURE</a>
						  <a href="download_rqa_sds_copy.php" class="btn btn-primary" style="padding:4px;margin:4px;" target="_blank">EXCEL FILE</a>-->
						
						</div>
                        </div>
						
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
		<script>
			function delete_me(id)
			{
				if (confirm("Are you sure you want to remove entire row?"))
				{
				  window.location.href="deleteme.php?id="+id;
				}
				
			}
		</script>		
			  
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
		<form action="" Method="POST" enctype="multipart/form-data">
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
		<label>MAJOR</label>
		<input type="text" class="form-control" name="Major" placeholder="Major Subject" required>
		<label>APPLICANT STATUS: </label>
		<select class="form-control" name="Status" required>
		  <option value="">--Select--</option>
		  <option value="NEW">NEW</option>
		  <option value="OLD">OLD</option>
		  <option value="UPDATED">UPDATED</option>
		</select>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="save_element" Value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
	      </div>
      </div>
</div></div>
		
		<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="editapplicant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	   </div>
</div>
</div>
</div>
	
	
		
		<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="major" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	   <div class="modal-header">
         
          <h3 class="modal-title"><center>SELECT MAJOR</center></h3>
		  	
        </div>
		
        <div class="modal-body">
		 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th width="5%" style="text-align:center;">#</th>
					<th>LEARNING AREAS</th>											
					<th width="10%"></th>
				</tr>															
			</thead>
			<tbody>
			<?php
			$no=0;
			  $subject=mysqli_query($con,"SELECT * FROM tbl_ranking_subject ORDER BY RankSubject Asc");
			  while($rowsub=mysqli_fetch_array($subject))
			  {
				  $no++;
				echo '<tr>
					  <td style="text-align:center;">'.$no.'</td>
					  <td>'.$rowsub['RankSubject'].'</td>											
					  <td>
					     <a href="print_by_major.php?code='.urlencode(base64_encode($rowsub['RankSubject'])).'" target="_blank">OSDS</a><br/>
					     <a href="print_by_major_highest.php?code='.urlencode(base64_encode($rowsub['RankSubject'])).'" target="_blank">HIGHEST</a>
					  </td>
				  </tr>';		 
			  }
			  ?>
			</tbody>
		</table>
		
		
		
		</div>
		 <div class="modal-footer">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		
	  
	   </div>
</div>
</div>
</div>
	
	
	
		
		<!-- Modal for Signature-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="signature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	   <div class="modal-header">
          <h3 class="modal-title"><center>SEQUENCE OF SIGNATURE</center></h3>
        </div>
		<form action="" method="POST">
        <div class="modal-body">
		<input type="text" name="first" class="form-control">
		<label>NAPSHII President</label>
		<input type="text" name="second" class="form-control">
		<label>Teachers' Ass. Representative</label>
		<input type="text" name="third" class="form-control">
		<label>Sec. FPTA-Presidente</label>
		<input type="text" name="fourth" class="form-control">
		<label>Education Program Supervisor</label>
		<input type="text" name="fifth" class="form-control">
		<label>Education Program Supervisor</label>
		<input type="text" name="six" class="form-control">
		<label>Education Program Supervisor</label>
		<input type="text" name="seven" class="form-control">
		<label>Assistant Schools Division Superintendent- Chairman</label>
		<input type="text" name="eight" class="form-control">
		<label>Schools Division Superintendent</label>
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="save_signature" class="btn btn-primary" value="SUBMIT">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
	  </div>
   </div>
  </div>
</div>
	