
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">	
					 <?php
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&cat='.urlencode(base64_encode($_SESSION['Category'])).'&v='.urlencode(base64_encode("category")).'" style="float:right;" class="btn btn-secondary">Back to course</a>';
					 ?>
						<p>GRADE <?php echo $_GET['Grade']; ?> LEARNING AREAS</p>
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th>LEARNING AREAS</th>											
												<th width="10%" style="text-align:center;">UNITS</th>
												<th width="10%" style="text-align:center;">MODULE STATUS</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
								   <?php
								   $no=0;
								   $_SESSION['Grade_Level']=$_GET['Grade'];
								   
								   if ($_GET['Grade']>=1 AND $_GET['Grade']<=6)
								   {
									$areas=mysqli_query($con,"SELECT * FROM tbl_element_subject ORDER BY SubNo Desc");
								   while($row=mysqli_fetch_array($areas))
								   {
									   $no++;
								    $datarec=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE SubCode='".$row['SubNo']."' AND Quarter ='".$_SESSION['Quarter']."' AND Grade_Level='". $_SESSION['Grade_Level']."' ORDER BY Filename Asc");
							
									 echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$row['LearningAreas'].'</td>											
												<td style="text-align:center;">'.$row['SubUnit'].'</td>';
												if (mysqli_num_rows($datarec)==0)
												{
												echo '<td style="text-align:center;">No Module Available</td>';
												}else{
												echo '<td style="text-align:center;">'.mysqli_num_rows($datarec).'</td>';	
												}
												echo '<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['SubNo'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("uploadfile")).'">VIEW</a?</td>
											</tr>';  
								   }  
								   }elseif ($_GET['Grade']>=7 AND $_GET['Grade']<=10)
								   {
								   $areas=mysqli_query($con,"SELECT * FROM tbl_jhs_subject ORDER BY SubNo Asc");
								   while($row=mysqli_fetch_array($areas))
								   {
									   $no++;
									   $datarec=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE SubCode='".$row['SubNo']."' AND Quarter ='".$_SESSION['Quarter']."' AND Grade_Level='". $_SESSION['Grade_Level']."' ORDER BY Filename Asc");
							
									 echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$row['LearningAreas'].'</td>											
												<td style="text-align:center;">'.$row['SubUnit'].'</td>';
												if (mysqli_num_rows($datarec)==0)
												{
												echo '<td style="text-align:center;">No Module Available</td>';
												}else{
												echo '<td style="text-align:center;">'.mysqli_num_rows($datarec).'</td>';	
												}
												echo '<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['SubNo'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("uploadfile")).'">VIEW</a?</td>
											</tr>';  
								   }
								   }elseif ($_GET['Grade']>=11 AND $_GET['Grade']<=12)
								   {
									 $areas=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand WHERE SubGradeLevel='".$_GET['Grade']."' ORDER BY LearningAreas Asc");
								   while($row=mysqli_fetch_array($areas))
								   {
									   $no++;
									     $datarec=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE SubCode='".$row['StrandsubCode']."' AND Quarter ='".$_SESSION['Quarter']."' AND Grade_Level='". $_SESSION['Grade_Level']."' ORDER BY Filename Asc");
							
									 echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$row['LearningAreas'].'</td>											
												<td style="text-align:center;">'.$row['SubUnit'].'</td>';
												if (mysqli_num_rows($datarec)==0)
												{
												echo '<td style="text-align:center;">No Module Available</td>';
												}else{
												echo '<td style="text-align:center;">'.mysqli_num_rows($datarec).'</td>';	
												}
												echo '<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['StrandsubCode'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("uploadfile")).'">VIEW</a?</td>
											</tr>';  
								   }  
								   }
								   ?>
								</tbody>
						   </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12</td>
												-->
            </div>
