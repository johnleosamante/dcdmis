<?php

if(isset($_POST['upload'])) {
	
	$query=mysqli_query($con,"SELECt * FROM tbl_sr_logs WHERE Emp_ID='".$_GET['c']."'");
	if(mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"INSERT INTO tbl_sr_logs VALUES(NULL,'".date("Y-m-d")."','".$_GET['c']."')");
	
     if(isset($_FILES['uploadsr']['name']) && $_FILES['uploadsr']['name'] != "") {
        $allowedExtensions = array("xls","xlsx");
        $ext = pathinfo($_FILES['uploadsr']['name'], PATHINFO_EXTENSION);
		
        if(in_array($ext, $allowedExtensions)) {
				// Uploaded file
               //$file = "uploads/".$_FILES['uploadsr']['name'];
               $file = $_FILES['uploadsr']['name'];
               $isUploaded = copy($_FILES['uploadsr']['tmp_name'], $file);
			   // check uploaded file
               if($isUploaded) {
					// Include PHPExcel files and database configuration file
                    //include("db.php");
					//require_once __DIR__ . '/vendor/autoload.php';
                    include('../../pcdmis/Classes/PHPExcel/IOFactory.php');
                    try {
                        // load uploaded file
                        $objPHPExcel = PHPExcel_IOFactory::load($file);
                    } catch (Exception $e) {
                         die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
                    }
                    
                    // Specify the excel sheet index
                    $sheet = $objPHPExcel->getSheet(0);
                    $total_rows = $sheet->getHighestRow();
					$highestColumn      = $sheet->getHighestColumn();	
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);		
					
					//	loop over the rows
					for ($row = 21; $row <= $total_rows; ++ $row) {
						for ($col = 0; $col < $highestColumnIndex; ++ $col) {
							$cell = $sheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$records[$row][$col] = $val;
						}
					}
					
					foreach($records as $row){
						// HTML content to render on webpage
						$html.="<tr>";
						$FROM = isset($row[0]) ? $row[0] : '';
						$TO = isset($row[1]) ? $row[1] : '';
						$DESIGNATION = isset($row[2]) ? $row[2] : '';
						$STATUS = isset($row[3]) ? $row[3] : '';
						$SALARY = isset($row[4]) ? $row[4] : '';
						$STN = isset($row[5]) ? $row[5] : '';
						$BRANCH = isset($row[6]) ? $row[6] : '';
						$ABSENCES = isset($row[7]) ? $row[7] : '';
						$SEPARATION = isset($row[8]) ? $row[8] : '';
					mysqli_query($con,"INSERT INTO tbl_service_records VALUES(NULL,'".$FROM."','".$TO."','".$DESIGNATION."','".$STATUS."','".$SALARY."','".$STN."','".$BRANCH."','".$ABSENCES."','".$SEPARATION."','".$_GET['c']."')");
							if(mysqli_affected_rows($con)==1)
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
					$html.="</table>";
					echo $html;
					echo "<br/>Data inserted in Database";
				
                    unlink($file);
                } else {
                    echo '<span class="msg">File not uploaded!</span>';
                }
        } else {
            echo '<span class="msg">Please upload excel sheet.</span>';
        }
    } else {
        echo '<span class="msg">Please upload excel file.</span>';
    }
}
}
?>
       
           <div class="row">
                <div class="col-lg-12">
                   		
                        <a href="print_service_record.php" class="btn btn-primary"  target="_blank" style="float:right;">Print Preview</a><br/><br/>	
					<?php
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['c']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					   echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
					 echo '<h3>Employee ID: '.$_GET['c'].'</h3>';
					 echo '<h3>Employee Name: '.utf8_encode($data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName']).'</h3>';
					 echo '<h3>Station: '.$data['SchoolName'].'</h3>';
					 echo '<h3>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</h3>';
					 $_SESSION['surname']=$data['Emp_LName'];
					 $_SESSION['given']=$data['Emp_FName'];
					 $_SESSION['middle']=mb_strimwidth($data['Emp_MName'],0,1);
					 $_SESSION['birth']=$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'];
					 $_SESSION['place']=$data['Emp_place_of_birth'];
					 $_SESSION['SR']=$_GET['c'];
					?>
					<a href="#uploadsr" class="btn btn-primary" data-toggle="modal">Upload File</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="20%" colspan="2">SERVICE RECORD</th>
                                        <th width="30%" colspan="3">RECORDS OF APPOINTMENT</th>
                                        <th width="30%" colspan="2">OFFICE ENTITY / DIV</th>
                                        <th width="10%" rowspan="2">V/L ABSENCES W/O PAY</th>
                                        <th width="10%" rowspan="2">SEPARATION</th>
                                    </tr>
									<tr>
										<th>FROM</th>
										<th>TO</th>
										<th>DESIGNATION</th>
										<th>STATUS</th>
										<th>SALARY</th>
										<th>STN / PLACE OF ASSIGNMENT</th>
										<th>BRANCH</th>
										
                                </thead>
                                <tbody>
								<?php
								$result=mysqli_query($con,"SELECT * FROM tbl_service_records  WHERE tbl_service_records.Emp_ID='".$_GET['c']."'");
									while($row=mysqli_fetch_array($result))
										{
										
                                      echo '<tr class="gradeA">
											<td>'.$row['date_from'].'</td>
											<td>'.$row['date_to'].'</td>
											<td>'.$row['position'].'</td>
											<td>'.$row['work_status'].'</td>
											<td>'.$row['salary'].'</td>
											<td>'.$row['station'].'</td>
											<td>'.$row['branch'].'</td>
											<td>'.$row['pay_status'].'</td>
											<td>'.$row['separation'].'</td>';
											if ($row['date_to']<>'PRESENT')
											{
											echo '<td></td>';
											}else{
																				
											echo '<td><a href="update_sr.php?code='.$row['No'].'" data-target="#myEditTo" class="btn btn-secondary" data-toggle="modal">Edit</a></td>';
											}
											echo '</tr>';
                                    
									}	
									
										
									?>
									<tr>
									<form action="save_service_record.php" Method="POST">
										<td><input type="date" name="date_from" class="form-control"></td>
										<td><input type="text" name="date_to" class="form-control"></td>
										<td>
											<select name="position" class="form-control">
											<option value="">--Select--</option>
											<?php
											$myjob=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
											while($myrow=mysqli_fetch_array($myjob))
											{
												echo '<option value="'.$myrow['Job_code'].'">'.$myrow['Job_description'].'</option>';
											}
											?>
											</select>
										</td>
										<td>
											<select name="work_status" class="form-control">
												<option value="">--Select--</option>
												<option value="Permanent">Permanent</option>
												<option value="Provisional">Provisional</option>
												<option value="Contractual">Contractual</option>
												<option value="Substitute">Substitute</option>
											</select>
										</td>
										<td><input type="text" name="salary" class="form-control"></td>
										<td>
											<select name="school" class="form-control">
												<option value="">--Select--</option>
												<?php
												$mySchool=mysqli_query($con,"SELECT * FROM tbl_school");
												while($row=mysqli_fetch_array($mySchool))
												{
													echo '<option value="DepEd, '.$row['SchoolName'].'">'.$row['SchoolName'].'</option>';
												}
												?>
											</select>
										</td>
										<td><input type="text" name="branch" class="form-control"></td>
										<td><input type="text" name="pay_status" class="form-control"></td>
										<td><input type="text" name="separation" class="form-control"></td>
										<td><input type="submit" name="submit" class="btn btn-secondary" value="Save"></td>
										</form>
									</tr>
                                </tbody>
                            </table>		
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				
			



<!-- Modal for New Leave-->
  <div class="modal fade" id="myEditTo" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

       <!-- Modal content-->
      <div class="modal-content">
       
			
			
		</div>
	</div>
</div>
<!--End Supervisor-->



<!-- Modal for New Leave-->
  <div class="modal fade" id="uploadsr" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

       <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
 
		  <h4 class="modal-title"><center>Upload Service Record Entry</center></h4>
		  	
        </div>
		    <form role="form" action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 
				
                            <label>Select File to upload</label>
                            <input type="file" name="uploadsr" accept=".csv,.xls,.xlsx" required>
                           
                        
					<!--End-->	
					</div>
					<div class="modal-footer">
							<input type="submit" class="btn btn-primary" name="upload" value="SAVE">
							 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
					
			</form>		
				</div>
			
			
				</div>
			 
		    </div>
			
			
		</div>
	</div>
</div>
<!--End Supervisor-->
