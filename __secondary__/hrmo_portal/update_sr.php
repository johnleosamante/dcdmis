<?php
session_start();
$_SESSION['Num']=$_GET['code'];
?>
 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
 
		  <h4 class="modal-title"><center>New Service Record Entry</center></h4>
		  	
        </div>
			<div class="modal-body">
		 <form role="form" action="update_service_record.php" Method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<!--Begin-->	
					<div class="row">
					 <div class="col-lg-12">
						      
                                          <div class="form-group">
                                            <label>TO</label>
                                            <input class="form-control" type="date" name="date_to" required>
                                        </div>
                                      
										
                                        <input type="submit" class="btn btn-primary" value="SAVE">
                                      
						
				
					<!--End-->	
					</div>
				</div>
			
			
				</div></form>
		    </div>