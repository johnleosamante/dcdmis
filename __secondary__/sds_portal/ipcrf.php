<style>
th,td{
	text-transform:uppercase;
}
</style>
<div class="row">
 <div class="col-lg-12">
 </div>
</div>
<div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<?php
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("ipcrfconsol")).'" style="float:right;" class="btn btn-primary">Consolidation</a>';
						?>
							<h4>LIST OF IPCRF/E-SAT UPLOADED BY SCHOOL</h4>
									
					</div>
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th width="15%">DATE</th>
                                        <th>SCHOOL NAME</th>
                                        <th>UPLOADED BY</th>
                                        <th>FILENAME</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_upload INNER JOIN tbl_school ON tbl_ipcrf_upload.SchoolID = tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_ipcrf_upload.Emp_ID = tbl_employee.Emp_ID WHERE tbl_ipcrf_upload.Year='".$_SESSION['year']."'");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								echo '<tr>
                                        <td style="text-align:center;">'.$no.'</th>
                                        <td>'.$row['DateUpload'].'</th>
                                        <td>'.$row['SchoolName'].'</th>
                                        <td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</th>
                                        <td>'.$row['FileName'].'</td>
                                        <td style="text-align:center;"><a href="../'.$row['DownloadLocation'].'" target="_blank"><i class="fa fa-download fa-fw"></i></a></td>
                                    </tr>';
								}
								?>
                                </tbody>
                            </table>
                            
                        </div>
                        </div>
                        </div>
                    
	<!--../../pcdmis/'.$row['DownloadLocation'].'-->