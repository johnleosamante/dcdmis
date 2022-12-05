<?php
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
if (isset($_POST['addsal']))
{
		mysqli_query($con,"INSERT INTO tbl_salary_grade_level VALUES (NULL,'".$_POST['sal_grade']."','".$_POST['sal_step']."','".$_POST['sal_amount']."','".$dateposted."')");
		
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
	text-align:center;
}
</style>
                <div class="col-lg-8">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   	<h4>List of Salary Amount by grade level</h4>
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="14%">Salary Grade</th>
                                        <th width="10%">Step</th>
                                        <th width="14%">Amount</th>
                                        <th width="14%">Last updated</th>
                                        <th width="7%"></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								   <?php
								   $no=0;
									 $result=mysqli_query($con,"SELECT * FROM tbl_salary_grade_level");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td>'.$no.'</td>
													<td>Grade '.$row['Salary_Grade'].'</td>
													<td>'.$row['Salary_step'].'</td>
													<td>'.number_format($row['Salary_amount'],2).'</td>
													<td>'.$row['Last_update'].'</td>
													<td><a href="" data-toggle="modal" data-target="#update">VIEW</a></td>
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
				<form action="" Method="POST" enctype="multipart/form-data">
                <div class="col-lg-4">
				 <div class="panel panel-default">
                       <div class="panel-heading">
					   	<h4>New Salary Grade</h4>
						</div>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <label>Salary Grade</label>
						 <input type="text" name="sal_grade" class="form-control" required>
						 <label>Salary Step</label>
						 <input type="text" name="sal_step" class="form-control" required>
						 <label>Amount</label>
						 <input type="text" name="sal_amount" class="form-control" required>
						</div>
						 <div class="panel-footer">
						  <input type="submit" name="addsal" class="btn btn-primary" value="SAVE">
						 </div>
						
				  </div>
				</div>
        </form>