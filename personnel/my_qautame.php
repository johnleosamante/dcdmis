  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>QUATAME SURVEY</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
	include("../pcdmis/vendor/jquery/function.php");
	    echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="30%">Title of Training</th>
												<th width="20%">Day</th>
												<th width="20%">Status</th>
												<th width="7%"></th>
												
											</tr>
																					
									</thead>
									<tbody>';
										
										

									
                               echo '</tbody>
                            </table>		';
					
					?>
		</div>