<style>
  
	 th,td{
		text-transform:uppercase;
	}	
		
   </style>
                <div class="col-lg-12">
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 
					
						<?php
						echo '<a href="print_by_grade.php?link='.sha1("Deped Pagadian City Division Data Management syetem").'" target="_blank"class="btn btn-primary" style="float:right;">Print Preview</a>
						 <h4>List of ';
							if ($_GET['Code']=='Kinder')
							{
								echo $_GET['Code'];
							}else{
								echo 'Grade '.$_GET['Code'];
							}
							 echo " Enrolled Learner's. </h4>";
							 $_SESSION['Grade']=$_GET['Code'];
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
						mysqli_query($con,"INSERT INTO tbl_learners VALUES(NULL,'".$_SESSION['lrn']."','".$_POST['section']."','".$_SESSION['year']."','".date('Y-m-d h:m:i')."','".$_SESSION['Grade']."','No Status','".$_SESSION['school_id']."')");	
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
						}
							
						?>	 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="10%">LRN</th>
                                        <th width="14%">Last Name</th>
                                        <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                        <th width="10%">Gender</th>
                                        <th width="20%">Contact #</th>
                                       
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='".$_GET['Code']."' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");
											
									while($row=mysqli_fetch_array($myinfo))
									{
										
                                      echo '<tr>
											<td>'.$row['lrn'].'</td>
											<td>'.utf8_encode($row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName']).'</td>
											<td>'.$row['Gender'].'</td>
											<td >'.$row['ContactNo'].'</td>
																												
											<td style="text-align:center;">';
															if ($row['Sem_Status']<>'Enrolled')
															{
															echo '<a href="confirm_info.php?id='.urlencode(base64_encode($row['lrn'])).'" data-toggle="modal" data-target="#assign_sec"> Accept</a><br/>
																<a href="delete_info.php?id='.urlencode(base64_encode($row['lrn'])).'" > Decline</a>
																';
															}else{
																echo '<a href="" > Enroled</a>
																';
															}
																
														echo '
															
														
													</td>
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
   <div class="modal fade" id="assign_sec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   
      <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->