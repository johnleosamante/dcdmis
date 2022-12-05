<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

	
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	
						<h4>Module's Masterlist</h4>
						
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                         <table class="table table-striped table-bordered table-hover" id="dataTables-example">
						  <thead>	
								<tr>
									<th style="width:5%;">#</th>
									<th style="width:15%;">Date Posted</th>
									<th style="width:15%;">Quarter #</th>
									<th style="width:15%;">Grade Level</th>
									<th>Learning Areas</th>
									
									<th style="width:7%;"></th>
									
								</tr>
						  </thead>
						  <tbody>
						   <?php
							$no=0;
							 if ($_SESSION['Category']=='Elementary')
							{
							$result=mysqli_query($con,"SELECT * FROM tbl_list_of_modules INNER JOIN tbl_employee ON tbl_list_of_modules.postedBy = tbl_employee.Emp_ID WHERE tbl_list_of_modules.Grade_Level BETWEEN '01' AND '06' ORDER BY tbl_list_of_modules.Date_Posted Desc");
							} elseif ($_SESSION['Category']=='Secondary')
								{
									$result=mysqli_query($con,"SELECT * FROM tbl_list_of_modules INNER JOIN tbl_employee ON tbl_list_of_modules.postedBy = tbl_employee.Emp_ID WHERE tbl_list_of_modules.Grade_Level BETWEEN '07' AND '12' ORDER BY tbl_list_of_modules.Date_Posted Desc");
							
								}
							while ($row=mysqli_fetch_array($result))
							{
								$no++;
							echo '<tr>
									<td>'.$no.'</td>
									<td>'.$row['Date_Posted'].'</td>
									<td>'.$row['Quarter'].'</td>';
									if ($row['Grade_Level']=='Kinder')
									{
									echo '<td>'.$row['Grade_Level'].'</td>';
									}else{
										echo '<td> Grade '.$row['Grade_Level'].'</td>';
									}
									echo '<td>'.$row['Filename'].'</td>
									
								   <td style="text-align:center;"> <a href="download.php?link=e7951f3eee040744517000b200a55777c6f1a9dc&id='.$row['No'].'" target="_blank" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-download fa-fw"></i></a></td>
									
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
				
				
            