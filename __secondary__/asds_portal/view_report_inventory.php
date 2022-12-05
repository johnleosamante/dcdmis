<style>
  th,td{
	  text-align:center;
  }
</style>
 <div class="col-lg-12">
 <h1></h1>
</div> 
				<div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                       <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBNQ%3D%3D" class="btn btn-secondary" style="float:right;">Back</a>
                       <a href="" class="btn btn-primary" style="float:right;">Print</a>
						
				  <h2>INVENTORY TRANSFER REPORT</h2>
				 
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th width="15%" style="text-align:center;">Date Acquired</th>
												<th width="10%" >Item No</th>											
												<th width="15%">ICS No./Date</th>
												<th>Description</th>
												<th width="15%">Amount</th>
												<th width="15%" >Condition of Inventory</th>
												<th width="5%"></th>
											</tr>
																	
									</thead>
									<tbody>
									
									<?php
									
									?>
									</tr>
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
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Announcement</center></h3>
		  	
        </div>
		<form action="" Method="POST">
        <div class="modal-body">
		<label>Date Post: </label>
		<input type="text" class="form-control" value="<?php echo $dateposted; ?>" disabled>
		<label>Post Details: </label>
		<textarea class="form-control" name="message" rows="5" required></textarea>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="save_post" Value="POST" class="btn btn-success">
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
		
		<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mypost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  </div>
	  </div>
	  </div>
	  </div>
