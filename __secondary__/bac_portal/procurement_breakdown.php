<script>
		 function remove_me(id)
		 {
			if (confirm("Are you sure yuo want to remove this project No. "+id ))
			{
				window.location.href='remove_bac_post.php?id='+id;
			}
		 }
		</script>             
				<div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
					 <?php
					 
                     echo '<a href="?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=YmFjX3Bvc3Rpbmc%3D" style="float:right;padding:4px;margin:4px;cursor:pointer;"  class="btn btn-secondary">BACK</a>
                     <a style="float:right;padding:4px;margin:4px;cursor:pointer;" id="'.$_GET['project'].'" onclick="remove_me(this.id)" class="btn btn-danger">REMOVE</a>';
					 ?>
                     <a href="#" data-toggle="modal" style="float:right;padding:4px;margin:4px;" class="btn btn-info">UPDATE</a>
						<h2>PROCUREMENT DETAILS</h2>
				  
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<b>
						<?php
						$result=mysqli_query($con,"SELECT * FROM bac_posting WHERE ProjectNo='".$_GET['project']."' LIMIT 1");
						$row=mysqli_fetch_assoc($result);
						$newpub = date("F d, Y", strtotime($row['DatePub']));  
						$duedate = date("F d, Y", strtotime($row['datedue']));  
						echo '<table width="100%" class="table table-striped table-bordered table-hover">
							<tbody>
								<tr>
									<td width="50%">Project No.</td>
									<td>'.$row['ProjectNo'].'</td>
								</tr>
								<tr>
									<td>Project</td>
									<td>'.$row['ProjectDetails'].'</td>
								</tr>
								<tr>
									<td>ABC</td>
									<td>₱ '.number_format($row['ABC'],2).'</td>
								</tr>
								<tr>
									<td>End-user Unit:</td>
									<td>'.$row['Enuserunit'].'</td>
								</tr>
								<tr>
									<td>Date</td>
									<td>'.$newpub.'</td>
								</tr>
								<tr>
									<td>Due Date</td>
									<td>'.$duedate.'</td>
								</tr>
								<tr>
									<td>Request for Quotation (RFQ):</td>
									<td><a href="'.$row['quotation'].'" target="_blank">VIEW</a></td>
								</tr>
							</tbody>
						</table>';
						?>
						</b>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
			  			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="updatepost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h3 class="modal-title"><center>Update Post</center></h3>
		  	
        </div>
		<form action="" Method="POST" ENCTYPE="multipart/form-data">
        <div class="modal-body">
		<label>Project No: </label>
		<input type="text" class="form-control" name="prodNo" value="<?php echo $_GET['project'];?>"disabled>
		<label>Project: </label>
		<textarea class="form-control" name="project" rows="5" required></textarea>
		<label>ABC: </label>
		<input type="text" class="form-control" name="amount" required>
		<label>End-user-Unit: </label>
		<input type="text" class="form-control" name="enduser" required>
		<label>Date: </label>
		<input type="date" class="form-control" name="datepub" required>
		<label>Due Date: </label>
		<input type="date" class="form-control" name="datedue" required>
		
		<label>Post Status: </label>
		<select name="status" class="form-control" required>
		 <option value="">--select--</option>
		 <option value="New">New</option>
		 <option value="Re-Post">Re-post</option>
		 <option value="Re-BID">Re-BID</option>
		</select>
		</div>
		 <div class="modal-footer">
		
		<input type="submit" name="save_post" Value="POST" class="btn btn-success">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		