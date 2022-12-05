<style>
	td,th{
		text-align:center;
	}
</style>
         <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>LOCATOR/PASS SLIP</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
                           <div class="col-lg-12">
						     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="15%">Date</th>
												<th width="15%">Requestedby</th>
												<th width="15%">Purpose / Destination</th>
												<th width="15%">Time Leaving</th>
												<th width="15%">Time Return</th>
												<th width="15%">Sctions</th>
												<th width="15%">Status</th>
												<th width="7%"></th>
											</tr>
										</thead>
									<tbody>	
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_locator_passslip INNER JOIN tbl_employee ON tbl_locator_passslip.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_locator_passslip.Emp_ID=tbl_station.Emp_ID") or die("Table Error");
					   
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['dateout'].'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
											<td>'.$row['Purpose'].'</td>
											<td>'.$row['TimeLeaving'].'</td>
											<td>'.$row['TimeReturn'].'</td>
											<td>'.$row['Office'].'</td>
											<td>'.$row['RequestStatus'].'</td>
											<td><a href="view_information_pass.php?code='.$row['LocatorNo'].'" data-toggle="modal" data-target="#viewstatus">VIEW</a></td>
										</tr>';
									}
									?>
									</tbody>
								</table>									
						   </div>
						   
						
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                <!-- /.col-lg-12 -->
          
   
              <!-- Modal -->
	 <div class="modal fade" id="viewstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="width:75%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;">
    
      <!-- Modal content-->
      <div class="modal-content">
	
		

	</div></div>
	</div>
 
