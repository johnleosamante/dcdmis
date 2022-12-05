                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
							<h4>List of subejcts </h4>
							
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
													
							<label style="width:100%;padding:4px;margin-left:auto;margin-right:auto;">
                           <table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th style="text-align:center;" width="7%">#</th>
												<th width="20%">Subject Code</th>
												<th>Learning Areas</th>
												<th style="text-align:center;" width="15%">Unit</th>
												<th style="text-align:center;" width="7%"></th>
												
											</tr>	
											
										</thead>
										<tbody>
										<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_jhs_subject WHERE SchoolID='".$_SESSION['school_id']."'");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>	
													<td>'.$row['SubCode'].'</td>	
													<td>'.$row['SubDesc'].'</td>	
													<td style="text-align:center;">'.$row['SubUnit'].'</td>	
													<td style="text-align:center;">
															<a href="?link='.sha1("Deped pagadian city data management system v.1.0").'&&grade='.$row['Grade'].'" data-toggle="modal" data-target="#list-of-student"><i class="fa  fa-desktop fa-fw" title="View Students"></i></a>
													</td>
												  </tr>';
										}
										?>
										
										</tbody>
										
									</table>
						
							
						</label>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
              
