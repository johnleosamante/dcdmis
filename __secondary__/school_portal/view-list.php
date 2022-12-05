
<script>
var _validFileExtensions = [".xls", ".xlsx", ".csv"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
</script> 
<script>
{
   document.addEventListener('contextmenu', event => event.preventDefault());
}
   </script> 
   <style>
  
		th,td{
			text-transform:uppercase;
		}
   </style>

			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<a href="print-list.php??link=bcead8efbf9d3ebfc554f2017c141e37533b9af8" class="btn btn-primary"  style="float:right;" target="_blank">Print List</a>
							
							<h3>SECTION MATERLIST</h3>
							<?php
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
						if(isset($_FILES['excel']) && $_FILES['excel']['error']==0) {
							require_once "../Classes/PHPExcel.php";
							$tmpfname = $_FILES['excel']['tmp_name'];
							$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
							$excelObj = $excelReader->load($tmpfname);
							$worksheet = $excelObj->getSheet(0);
							$lastRow = $worksheet->getHighestRow();
							
							
							for ($row = 8; $row <= $lastRow; $row++) {
								
								  $lrn= $worksheet->getCell('B'.$row)->getValue();
								  $LName= $worksheet->getCell('C'.$row)->getValue();
								  $FName= $worksheet->getCell('D'.$row)->getValue();
								  $MName= $worksheet->getCell('E'.$row)->getValue();
								  $Birthdate= $worksheet->getCell('F'.$row)->getValue();
								  $Sex= $worksheet->getCell('G'.$row)->getValue();
								  $ContactNo= $worksheet->getCell('H'.$row)->getValue();
								  $FatherName= $worksheet->getCell('I'.$row)->getValue();
								  $FContact= $worksheet->getCell('J'.$row)->getValue();
								  $FWork= $worksheet->getCell('K'.$row)->getValue();
								  $Mother= $worksheet->getCell('L'.$row)->getValue();
								  $MContact= $worksheet->getCell('M'.$row)->getValue();
								  $MWork= $worksheet->getCell('N'.$row)->getValue();
								  $Home_Address= $worksheet->getCell('O'.$row)->getValue();
								  $PMember= $worksheet->getCell('P'.$row)->getValue();
								  $Graduated= $worksheet->getCell('Q'.$row)->getValue();
								  $GWA= $worksheet->getCell('R'.$row)->getValue();
						$querydata=mysqli_query($con,"SELECt * FROM tbl_student WHERE lrn='".$lrn."'");	
						if (mysqli_num_rows($querydata)==0)
						{
						mysqli_query($con,"INSERT INTO tbl_student VALUES('".$lrn."','".$LName."','".$FName."','".$MName."','".$Birthdate."','".$Sex."','".$ContactNo."','".$FatherName."','".$FContact."','".$FWork."','".$Mother."','".$MContact."','".$MWork."','".$Home_Address."','".$PMember."','".$_SESSION['school_id']."','".$Graduated."','80','Promoted','../images/user.png')");
						}
					 $query=mysqli_query($con,"SELECT * FROM tbl_registration WHERE lrn='".$lrn."'");
					 if (mysqli_num_rows($query)==0)
					 {
					 mysqli_query($con,"INSERT INTO tbl_registration VALUES(NULL,'".$lrn."','".$_SESSION['year']."','".$dateposted."','".$_SESSION['Grade']."','Enrolled','".$_SESSION['school_id']."','No Status','".$GWA."')");
					 }
					 if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
					 {
						if ($_SESSION['Sem']=='First Semester')
						{
							 mysqli_query($con,"INSERT INTO first_semester VALUES(NULL,'".$lrn."','-','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$dateposted."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");
						}else{
							 mysqli_query($con,"INSERT INTO second_semester VALUES(NULL,'".$lrn."','-','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$dateposted."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");
						
						}					
					 }else{
						  mysqli_query($con,"INSERT INTO tbl_learners VALUES(NULL,'".$lrn."','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$dateposted."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");
						
				
			 }
			  
			
		}
	
			}elseif (isset($_POST['update_section'])){
							$mytitle=$_POST['Section_name'];
							$mytitle=str_replace("'","\'",$mytitle);
								mysqli_query($con,"UPDATE tbl_section SET SecDesc='".$mytitle."',Grade='".$_POST['Grade_Level']."',Room_location='".$_POST['rm_location']."',Emp_ID='".$_POST['class_adviser']."' WHERE SecCode ='".$_SESSION['upsection']."'");
							if (mysqli_affected_rows($con))
							{
							$Err = "Section Successfully Updated";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}
							}
?>				
                        </div>
                        <!-- /.panel-heading -->
						
						
						
                        <div class="panel-body">
						<?php
                           $_SESSION['SecCode']= $_GET['SecCode'];
						   $str=sha1("Pagadian City Division Data Management Information System");
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_SESSION['SecCode']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
						 $data=mysqli_fetch_assoc($emp_info);
						
						 if ($data['Picture']<>NULL)
							 {
							  echo  '<img src="../../../pcdmis/images/'.$data['Picture'].'" style="width:140px;height:140px;" align="right">';
						
							 }else{
								 echo  '<img src="../../../pcdmis/images/user.png" style="width:140px;height:140px;" align="right">';
							 
							 }
				
						  
							echo '<p>Section Code: '.$_GET['SecCode'].'</p>';
						echo '<p>Section Name: '.$data['SecDesc'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
							{	
							  echo '<p>Grade: '.$data['Grade'].'</p>';
										
							}else{
							   echo '<p>Grade: Grade '.$data['Grade'].'</p>';
											
								}
						$_SESSION['Grade']=$data['Grade'];
						$_SESSION['Adviser']=$data['Emp_LName'].', '.$data['Emp_FName'];		
						echo '<p>Class Adviser: '.$data['Emp_LName'].', '.$data['Emp_FName'].'</p>';
						echo '<p>Position: '.$data['Job_description'].'</p>';
						echo  '<p>Room Location: '.$data['Room_location'].'</p><hr/>';
						
						echo ' <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
                                    <tr>
                                        <th width="7%">LRN</th>
                                        <th width="10%">LAST NAME</th>
                                        <th width="10%">FIRST NAME</th>
                                        <th width="10%">MIDDLE NAME</th>
                                        <th width="10%">BIRTHDATE</th>
                                        <th width="10%">CONTACT #</th>
                                        <th width="5%"></th>
                                      
                                    </tr>
                                </thead>
                                <tbody>';
						if ($data['Grade']=='11' || $data['Grade']=='12')
						{
								if ($_SESSION['Sem']=='First Semester')
								{
									$secdata=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SecCode='".$_SESSION['SecCode']."' ORDER BY tbl_student.Lname Asc ");
						
								}elseif ($_SESSION['Sem']=='Second Semester')
								{
									$secdata=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SecCode='".$_SESSION['SecCode']."' ORDER BY tbl_student.Lname Asc  ");
						
								}
						}else{							
						$secdata=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_SESSION['SecCode']."' GROUP BY tbl_learners.lrn ORDER BY tbl_student.Lname Asc ");
						}			
							while($row_secdata=mysqli_fetch_array($secdata))
							{
								
						echo '<tr>
									<td>'.$row_secdata['lrn'].'</td>
									<td>'.utf8_encode($row_secdata['Lname'].'</td>
									<td>'.$row_secdata['FName'].'</td>
									<td>'.$row_secdata['MName']).'</td>
									<td>'.$row_secdata['Birthdate'].'</td>
									<td>'.$row_secdata['ContactNo'].'</td>
									<td style="text-align:center;">
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&l='.urlencode(base64_encode($row_secdata['lrn'])).'&&Code='.urlencode(base64_encode($row_secdata['Grade'])).'&v='.urlencode(base64_encode("individual_info")).'" title="View information" class="btn btn-primary">VIEW</a>
										</td>					
							</tr>';
							}	
						echo '</tbody>
								</table>';
								?>
                            
                        </div>
						<div class="panel-footer">
						<?php
						  echo '<a href="edit-section.php?id='.urlencode(base64_encode($_SESSION['SecCode'])).'" data-toggle="modal" data-target="#list-of-student" class="btn btn-warning">UPDATE</a>
						  <a style="cursor:pointer;" id="'.urlencode(base64_encode($_SESSION['SecCode'])).'" onclick="remove_data(this.id);" class="btn btn-danger">DELETE</a>';
						?>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
          

 <div class="panel-body">
                            
                            <!-- Modal -->
                            <div class="modal fade" id="newenroll" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
										<h4 class="modal-title" id="myModalLabel">Upload Learners profile</h4>
										</div>

										<div class="modal-body">
											<form enctype="multipart/form-data" method="post" role="form" action="">
													<div class="form-group">
														<label for="exampleInputFile">File Upload</label>
														<input type="file" name="excel" id="file" size="150" onchange="ValidateSingleInput(this)">
														<p class="help-block">Only Excel/CSV File Import.</p>
													</div>
													<button type="submit" class="btn btn-default" name="upload" value="Import">Upload</button>
												</form>	
															
											</div>	
																
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- .panel-body -->
						
		

   <script>
   function remove_data(id)
   {
	 	
			if(confirm("Are you sure you want to deleted?"))
			{
				window.location.href='remove-section.php?id='+id;
			}
		
   }
   </script>
							


   <!-- Modal for view list of learners-->
    <div class="panel-body">
                            
         <!-- Modal -->
            <div class="modal fade" id="list-of-student" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->					