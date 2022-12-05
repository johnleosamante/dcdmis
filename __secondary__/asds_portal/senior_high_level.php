                 <h2></h2>
				 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=bGlzdF9vZl9hcHBsaWNhbnQ%3D" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;">Back</a>
                       <a href="#myapplicant" class="btn btn-primary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">NEW APPLICANT</a>
						
						
				  <h2>List of Senior High School applicants</h2>
				  <?php
					 date_default_timezone_set("Asia/Manila");
					$dateposted = date("Y-m-d H:i:s");
				  if (isset($_POST['save_element']))
				  {
					  mysqli_query($con,"INSERT INTO tbl_applicant VALUES('".date("ydms")."','".$_POST['FName']."','".$_POST['GName']."','".$_POST['MName']."','".$_POST['sex']."','".$_POST['CellNo']."','".$_POST['homeaddress']."','SENIOR HIGH','".$_SESSION['year']."','".$_POST['Track']."')");
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
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='SENIOR HIGH'");
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
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&account='.urlencode(base64_encode($row['Appl_No'])).'&Category='.urlencode(base64_encode("SENIOR HIGH")).'&v='.urlencode(base64_encode("individual_rating")).'">VIEW</a></td>
											
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
		<label>TRACK/STRAND</label>
		<input type="text" class="form-control" name="Track" placeholder="Track/Strand" required>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="save_element" Value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
	      </div>
      </div>
</div></div>
		
		
	