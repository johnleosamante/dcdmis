
	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}
	</style>
<?php
if(isset($_POST["Import"]))
//if ($_SERVER_REQUEST['METHOD']=='POST')	
{
	 echo $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            $sql = "INSERT into tbl_service_records VALUES (NULL,'$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]','". $_SESSION['EmpID']."')";
			mysqli_query($con,$sql);	
        }
        fclose($file);
		if (mysqli_affected_rows($con)==1)
		{
			$Err = "Service Record Successfully Uploaded.";
			echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
					});</script>';	
		     echo '<div class="alert alert-success">'.$Err.'</div>';
		}
		}
    else{
        echo 'Invalid File:Please Upload CSV File';
}
}

?>



                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
							  <a href="<?php echo './?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode( $_SESSION['SchoolID'])).'&v='.urlencode(base64_encode("view_school")); ?>" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">Back</a>
							  <a href="#uploadService" class="btn btn-success" data-toggle="modal" style="float:right;">Upload Service Record</a>
						<table style="padding:4px;margin:10px;">
						<?php
							$repre=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_GET['c']."' AND tbl_employee.Emp_Status ='Active'") or die("Table not found!!!");
							$data=mysqli_fetch_assoc($repre);
							
							echo '<img src="'.$data['Picture'].'" width="150" height="150" align="left" style="padding:4px;border-radius:50%;" id="pic">
							<tr style="text-transform:uppercase;"><td>Employee ID #:</td><td style="color:blue;padding:4px;margin:4px;">'.$_GET['c'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Name: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_LName'].', '.$data['Emp_FName'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Sex: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Sex'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Position: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Job_description'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Contact No.: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Cell_No'].'</font></td></tr>';
					
						?>
								</table> 
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover">
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
											<td>'.number_format($row['salary'],2).'</td>
											<td>'.$row['station'].'</td>
											<td>'.$row['branch'].'</td>
											<td>'.$row['pay_status'].'</td>
											<td>'.$row['separation'].'</td>';
											
											echo '</tr>';
                                    
									}	
									
										
									?>
									
                                </tbody>
                            </table>	
					
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            

			   <!-- Modal for Re-assign-->
		   
    <div class="modal fade" id="uploadService" role="dialog" data-backdrop="static" data-keyboard="false">
     <div style="width:30%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;">
    
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Select Excel File to upload</center></h3>
		 
        </div>
        <div class="modal-body">
		<form enctype="multipart/form-data" method="post" role="form" action="">
		 <input type="file" name="file" id="file" size="150" accept=".csv">
        <p class="help-block">Only Excel/CSV File Import.</p>
		
			<button type="submit" class="btn btn-success" name="Import">Upload</button>
			</form>	  
			
			</div>
		</div>
		 </div>
			  </div></div>
		
<!-- Ending Modal for re-assign->
		