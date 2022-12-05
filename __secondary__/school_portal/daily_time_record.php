<div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
	<div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<?php
						  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("view_date")).'" class="btn btn-success" style="float:right;" target="_blank">PRINT DAILY TIME RECORD</a>';
						  ?>
							<h4>School Daily Time Record</h4>
						
                        </div>
           
                        <!-- /.panel-heading -->
                        <div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
								<tr>
									<th rowspan="2">#</th>
									<th rowspan="2">NAME</th>
									<th rowspan="2">DATE</th>
									<th colspan="2" style="text-align:center;">MORNING LOG</th>
									<th colspan="2" style="text-align:center;">AFTERNOON LOG</th>
								</tr>
								<tr>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
									<th style="text-align:center;">IN</th>
									<th style="text-align:center;">OUT</th>
			
								</tr>
                                </thead>
                                <tbody>
								
								<?php
								date_default_timezone_set("Asia/Manila");
									$no=0;
									$_SESSION['currentdate']=date("Y-m-d");
									$mydtrrecord=mysqli_query($con,"SELECT * FROM tbl_dtr INNER JOIN tbl_employee ON tbl_dtr.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_dtr.Emp_ID = tbl_station.Emp_ID WHERE tbl_dtr.DTRDate = '".date("Y-m-d")."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."' ORDER BY tbl_dtr.TimeINAM Asc");
									while($DTRRow=mysqli_fetch_array($mydtrrecord))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$DTRRow['Emp_LName'].', '.$DTRRow['Emp_FName'].'</td>
												<td style="text-align:center;">'.$DTRRow['DTRDate'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeINAM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeOUTAM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeINPM'].'</td>
												<td style="text-align:center;">'.$DTRRow['TimeOUTPM'].'</td>
										</tr>';
									}
									?>
									
                                </tbody>
                            </table>
						</div>	
						</div>	
						</div>	