  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>PRINT YOUR CERTIFICATE</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include("../vendor/jquery/function.php");
	    echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="30%">Certificate No</th>
												<th width="20%">Title of Training</th>
												<th width="20%">Certificate Name</th>
												<th width="7%"></th>
												
											</tr>
																					
									</thead>
									<tbody>';
										
										

									
                               echo '</tbody>
                            </table>		';
					
					?>
		</div>