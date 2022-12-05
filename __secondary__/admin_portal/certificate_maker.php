<style>
th,td{
	text-transform:uppercase;
}
</style>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					    	<h2>List of Training</h2>							
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" rowspan="2">#</th>
												<th width="35%" rowspan="2">TITLE OF TRAININGS / ACTIVITIES</th>
												<th width="20%" colspan="2" >DATE COVERED</th>
												
												<th width="20%" rowspan="2">VENUE</th>
												<th width="5%" rowspan="2"></th>
											</tr>
										<tr>
											<th>FROM</th>
											<th>TO</th>
										</tr>										
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$seminar=mysqli_query($con,"SELECT * FROM tbl_seminar ORDER BY Title_of_training Asc") or die ("error training data");
										while($row=mysqli_fetch_array($seminar))
										{
											$no++;
										echo '<tr><td style="text-align:center;">'.$no.'</td>
												<td>'.$row['Title_of_training'].'</td>
												<td>'.$row['covered_from'].'</td>
												<td>'.$row['covered_to'].'</td>
												
												<td>'.$row['TVenue'].'</td>
												
												<td style="text-align:center;">
												    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['Training_Code'])).'&v='.urlencode(base64_encode("view_list")).'"> View</a><br/>										 
																		 
											</td></tr>
												';
										}
													?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
 