
	<style>
	th,td{
		text-transform:uppercase;
		
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <?php
						 echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($_GET['Code'])).'&v='.urlencode(base64_encode("add_personnel")).'"  class="btn btn-primary" style="float:right;">ADD PERSONNEL</a>';
						 	
							if (isset($_POST['update']))
							{
								mysqli_query($con,"UPDATE tbl_f7_salary SET Basic_Salary='".$_POST['Basic']."',PERA_ACA='".$_POST['PERA']."' WHERE Emp_ID ='".$_POST['PName']."'AND CodeNo='".$_GET['Code']."'");
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
							
							
							
							
							 $mypayroll=mysqli_query($con,"SELECT * FROM tbl_salary_station WHERE CodeNo='".$_GET['Code']."' LIMIT 1");
							 $myrow=mysqli_fetch_assoc($mypayroll);
							 echo  '<label>Station Code:</label>
									<label>'.$_GET['Code'].'</label><br/>
									<label>Station:</label>
									<label>'.$myrow['Station'].'</label><br/>
									
									';
							
							
							?>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
												
								<thead>							
									<tr>
										<th style="text-align:center;width:10%;">EmpNo</th>
										<th>Employee Name</th>
										<th width="25%">Position Title</th>
										<th width="15%">Basic</th>
										<th width="15%">PERA/ACA</th>
										<th width="5%"></th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								$mysalary=mysqli_query($con,"SELECT * FROM tbl_f7_salary INNER JOIN tbl_employee ON tbl_f7_salary.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_f7_salary.CodeNo='".$_GET['Code']."'");
								while($rowsalary=mysqli_fetch_array($mysalary))
								{
									$mi=mb_strimwidth($rowsalary['Emp_MName'],0,1);
									echo '<tr>
										<td>'.$rowsalary['Emp_ID'].'</td>
										<td>'.$rowsalary['Emp_LName'].', '.$rowsalary['Emp_FName'].' '.$mi.'.</td>
										<td>'.$rowsalary['Job_description'].'</td>
										<td>'.number_format($rowsalary['Basic_Salary'],2).'</td>
										<td>'.number_format($rowsalary['PERA_ACA'],2).'</td>
										<td><a href="edit_salary.php?code='.urlencode(base64_encode($rowsalary['Emp_ID'])).'" data-target="#editnew" data-toggle="modal">Edit</a></td>
										
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
				
				
				
	     

	
	
		
				 <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="editnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
    
    
	</div>
	</div>
	</div>
</div>
      
	
	
	
	
	