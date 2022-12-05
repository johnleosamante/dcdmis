<?php
if (isset($_POST['submit']))
{
	//if(mysqli_affected_rows($con)==1)
	//{
		?>
			<script type="text/javascript">
				$(document).ready(function(){						
				$('#access').modal({
					show: 'true'
				}); 				
				});
			</script>
									
							 
		<?php 
	//}
}
?>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>List of Request for Transfer </h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						   <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Request by</th>
										<th>From </th>
										<th>Transfer To</th>
										<th>Reason to Transfer</th>
										<th>Status</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
						
									<?php
									$no=0;
									$myrequest=mysqli_query($con,"SELECT * FROM tbl_transfer_data INNER JOIN tbl_employee ON tbl_transfer_data.Trans_Emp_ID=tbl_employee.Emp_ID")or die("Error transfer data");
									while($rtransfer=mysqli_fetch_array($myrequest))
									{
									$no=$no+1;
									echo '<tr>
										<td>'.$no.'</td>
										<td>'.$rtransfer['Emp_LName'].', '.$rtransfer['Emp_FName'].'</td>
										<td>'.$rtransfer['Trans_From'].'</td>
										<td>'.$rtransfer['Trans_TO'].'</td>
										<td>'.$rtransfer['Trans_Reason'].'</td>
										<td>'.$rtransfer['Trans_Status'].'</td>
										<td>
											<a href="" data-toggle="modal" data-target="#myEvaluation" class="btn btn-primary" style="padding:4px;margin:4px;" title="For Approval"> <i class="fa  fa-thumbs-o-up   fa-fw"></i></a>
											<a href="" class="btn btn-danger" style="padding:4px;margin:4px;" title="Disapproved"><i class="fa  fa-thumbs-o-down   fa-fw"></i></a>
																					
																			
										</td>
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
                <!-- /.col-lg-12 -->
           