		 
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>				
	            <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4>List of Registered Learner's</h4>
							<?php
							if (isset($_POST['assign']))
								{
								if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
								{
									if ($_SESSION['Sem']=='First Semester')
									{
									mysqli_query($con,"INSERT INTO first_semester VALUES(NULL,'".$_SESSION['lrn']."','".$_POST['track']."','".$_POST['section']."','".$_SESSION['year']."','".date('Y-m-d')."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");	
									
									}elseif ($_SESSION['Sem']=='Second Semester')
									{
									mysqli_query($con,"INSERT INTO second_semester VALUES(NULL,'".$_SESSION['lrn']."','".$_POST['track']."','".$_POST['section']."','".$_SESSION['year']."','".date('Y-m-d')."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");	
										
									}
									
								}else{	
                                 $query=mysqli_query($con,"SELECT * FROM tbl_learners WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
									 if(mysqli_num_rows($query)==0)
									 {
										mysqli_query($con,"INSERT INTO tbl_learners VALUES(NULL,'".$_SESSION['lrn']."','".$_POST['section']."','".$_SESSION['year']."','".date('Y-m-d h:m:i')."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");	
									 }else{
										 mysqli_query($con,"UPDATE tbl_learners SET SecCode = '".$_POST['section']."' WHERE lrn ='".$_SESSION['lrn']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."'");
									 }
								}
								mysqli_query($con,"UPDATE tbl_student_user SET status='Active' WHERE username='".$_SESSION['lrn']."' LIMIT 1");
								mysqli_query($con,"UPDATE tbl_registration SET tbl_registration.Sem_Status ='Enrolled' WHERE tbl_registration.lrn='".$_SESSION['lrn']."' AND tbl_registration.Grade='".$_SESSION['Grade']."' LIMIT 1");	
								$Err = "Learner Successfully Enrolled";
											echo '<script type="text/javascript">
												$(document).ready(function(){						
												$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
												
												});</script>
												';	
										echo '<div class="alert alert-success">'.$Err.'</div>';
								}elseif (isset($_POST['updatesection']))
								{
									if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
									{
										if ($_SESSION['Sem']=='First Semester')
										{
										mysqli_query($con,"UPDATE first_semester SET SecCode='".$_POST['section']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
								
										}elseif ($_SESSION['Sem']=='Second Semester')
										{
										mysqli_query($con,"UPDATE second_semester SET SecCode='".$_POST['section']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
								
										}
									}else{
										mysqli_query($con,"UPDATE tbl_learners SET SecCode='".$_POST['section']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
									}
									if (mysqli_affected_rows($con)==1)
									{
										$Err = "Section Assigned Successfully Changed!!!";
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
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="width:5%;">#</th>
												<th style="width:15%;">Date Time Register</th>
												<th>Learner\'s Name</th>
												 <th width="10%">Gender</th>
												<th style="text-align:center;width:15%;">Grade Level</th>
												<th width="5%"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										
										
										$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Sem_Status='Register' ORDER BY tbl_student.Lname Asc");
										
									while($row=mysqli_fetch_array($myinfo))
									{
										$no++;
                                      echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Date_enrolled'].'</td>
											<td>'.utf8_encode($row['Lname'].', '.$row['FName'].' '.$row['MName']).'</td>
											<td style="text-align:center;">'.$row['Gender'].'</td>
											<td style="text-align:center;">'.$row['Grade'].'</td>
																												
											<td style="text-align:center;">';
															if ($row['Sem_Status']<>'Enrolled')
															{
															echo '<a href="confirm_info.php?Grade='.urlencode(base64_encode($row['Grade'])).'&id='.urlencode(base64_encode($row['lrn'])).'" data-toggle="modal" data-target="#assign_sec" class="btn btn-primary" style="padding:4px;margin:4px;"> Accept</a><br/>
																<a id="'.urlencode(base64_encode($row['lrn'])).'" class="btn btn-warning" style="padding:4px;margin:4px;cursor:pointer;" onclick="delete_data(this.id)"> Decline</a>
																';
															}else{
																echo '<a href="" > Enroled</a>
																      <a href="view_section_confirm.php?Grade='.urlencode(base64_encode($row['Grade'])).'&id='.urlencode(base64_encode($row['lrn'])).'" data-toggle="modal" data-target="#assign_sec"> View</a>
																';
															}
																
														echo '
															
														
													</td>
                                        </tr>';
                                    $query=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn='".$row['lrn']."'ORDER BY tbl_student.Lname Asc");
								
									 if (mysqli_num_rows($query)>1)
									 {
										 mysqli_query($con,"DELETE FROM tbl_registration WHERE tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn='".$row['lrn']."' LIMIT 1");
									 }
									}	
																		
										echo '</tbody>
									</table>';
						
							
							
							?>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           
<script>
function delete_data(id)
{
	if(confirm("Are you sure you want to Decline?"))
	{
		window.location.href="delete_info.php?id="+id;
	}
}
</script>


   <!-- Modal for Re-assign-->
 
 <div class="panel-body">
   <div class="modal fade" id="assign_sec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   
      <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->