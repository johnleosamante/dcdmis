<?php
if (isset($_POST['new_rating']))
{
	//mysqli_query($con,"INSERT INTO tbl_ipcrf_consolidated (Emp_ID,RatingScore,RatingAdjective) VALUES('".$_POST['personnel']."','".$_POST['rating']."','".$_POST['remarks']."')");
	echo $filename=$_FILES["uploaddata"]["tmp_name"];
		if($_FILES["uploaddata"]["size"] > 0)
			{
				$file = fopen($filename, "r");
				while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
				{
					mysqli_query($con,"INSERT INTO tbl_ipcrf_consolidated_reports (Emp_LName,Emp_FName,Emp_MName,Position,RatingScore,RatingAdjective) VALUES('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]')");
	
				}
				fclose($file);
			}
		else{
		echo 'Invalid File:Please Upload CSV File';
	}
	if (mysqli_affected_rows($con)==1)
	{
		?>
			<script type="text/javascript">
				$(document).ready(function(){						
					 $('#access').modal({
						show: 'true'
					}); 				
				});
			</script>
									
							 
		<?php   
	}
}
?>



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
						<a href="#newrating" style="float:right;padding:4px;margin:4px;" class="btn btn-primary" data-toggle="modal">Upload File</a>
						<a href="ipcrfconsoldownload.php" style="float:right;padding:4px;margin:4px;" class="btn btn-success">REPORTS</a>
							<h4>INDIVIDUAL IPCRF CONSOLIDATION REPORTS</h4>
									
					</div>
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th>NAME</th>
                                        <th  width="20%" style="text-align:center;">POSITION</th>
                                        <th  width="15%" style="text-align:center;">NUMERICAL RATING</th>
                                        <th  width="15%" style="text-align:center;">ADJECTIVAL RATING</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								//$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated INNER JOIN tbl_station ON tbl_ipcrf_consolidated.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_employee ON tbl_ipcrf_consolidated.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code");
								$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated_reports ORDER BY Position Asc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								echo '<tr>
                                        <td style="text-align:center;">'.$no.'</th>
										 <td>'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'</td>
                                        <td style="text-align:center;">'.$row['Position'].'</td>
                                        <td style="text-align:center;">'.$row['RatingScore'].'</td>
                                        <td style="text-align:center;">'.$row['RatingAdjective'].'</td>
                                       
                                    </tr>';
								}
								?>
                                </tbody>
                            </table>
                            
                        </div>
                        </div>
                        </div>
                    
					
                            <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="newrating1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										 <div class="modal-header">
											  <h3 class="modal-title"><center>NEW RATINGS</center></h3>
											</div>
											<form action="" Method="POST" enctype="multipart/form-data">
											<div class="modal-body">
											<label>PERSONNEL NAME:</label>
											<select name="personnel" class="form-control" required>
												<option value="">--select--</option>
												<?php
												 $rateper=mysqli_query($con,"SELECT * FROM tbl_employee ORDER BY Emp_LName Asc");
												 while ($rowper=mysqli_fetch_array($rateper))
												 {
													 echo '<option value="'.$rowper['Emp_ID'].'">'.$rowper['Emp_LName'].', '.$rowper['Emp_FName'].'</option>';
												 }
												?>
											</select>
											<label>NUMERICAL RATING:</label>
											<input type="text" name="rating" class="form-control" required>
											<label>ADJECTIVAL RATING:</label>
											<input type="text" name="remarks" class="form-control" required>
											</div>
										<div class="modal-footer">
										<input type="submit" name="new_rating" value="SUBMIT" class="btn btn-primary">
										  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
										</div>
										</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                     
						
					
					
					  <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="newrating" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										 <div class="modal-header">
											  <h3 class="modal-title"><center>NEW RATINGS</center></h3>
											</div>
											<form action="" Method="POST" enctype="multipart/form-data">
											<div class="modal-body">
											 <label>UPLOAD FILE:</label>
											 <input type="file" name="uploaddata" required accept=".csv">
											</div>
										<div class="modal-footer">
										<input type="submit" name="new_rating" value="SUBMIT" class="btn btn-primary">
										  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
										</div>
										</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
	<!--../../pcdmis/'.$row['DownloadLocation'].'-->