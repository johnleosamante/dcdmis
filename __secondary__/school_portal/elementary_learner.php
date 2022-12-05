<style>
td,th
{
 text-transform:uppercase;	
}
</style>
<div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
					<div class="panel-heading">
					<h3>Elementary Learner's Masterlist</h3>
					<?php
					$rat=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_status LIMIT 1");
					$rowstatus=mysqli_fetch_assoc($rat);
					$_SESSION['ExamStatus']=$rowstatus['Exam_Status'];
					if (isset($_POST['update']))
					{
					
						mysqli_query($con,"UPDATE tbl_learners SET SecCode='".$_POST['section']."' WHERE lrn='".$_SESSION['LRN']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' AND Grade ='".$_SESSION['Grade']."' LIMIT 1");	
						
											
						if(mysqli_affected_rows($con)==1)
						{
						$Err="Successfully Updated!";	
                      echo '<div class="panel-heading">
							<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
								
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'</div>
							 
                        </div>';
						$_SESSION['LRN']="";
						}
					}elseif (isset($_POST['changepass'])){
						if ($_POST['newpass']==$_POST['conpass'])
						{
							$pass=md5($_POST['newpass']);
							$query=mysqli_query($con,"SELECT * FROM tbl_student_user WHERE username='".$_SESSION['LRN']."'");
							if (mysqli_num_rows($query)==0)
							{
							mysqli_query($con,"INSERT INTO tbl_student_user VALUES (NULL,'".$_SESSION['LRN']."','".$pass."','Active','".$_SESSION['Grade']."','".$_SESSION['school_id']."')");	
															   
							}else{
								mysqli_query($con,"UPDATE tbl_student_user SET password='".$pass."' WHERE username='".$_SESSION['LRN']."' LIMIT 1");
							}
							if(mysqli_affected_rows($con)==1)
							{
							$Err="Password Successfully Updated!";	
						  echo '<div class="panel-heading">
								<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
									
									});</script>
									';	
							echo '<div class="alert alert-success">'.$Err.'</div></div>';
							}
						}else{
							$Err="Password not match!";	
						  echo '<div class="panel-heading">
								<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
									
									});</script>
									';	
							echo '<div class="alert alert-success">'.$Err.'</div></div>';
						}
					}elseif (isset($_POST['change_grade']))
					{
					
						mysqli_query($con,"UPDATE tbl_learners SET Grade='".$_POST['GLevel']."',SecCode='".$_POST['section']."' WHERE lrn='".$_SESSION['LRN']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' AND Grade ='".$_SESSION['Grade']."' LIMIT 1");	
						mysqli_query($con,"UPDATE tbl_registration SET Grade='".$_POST['GLevel']."' WHERE lrn='".$_SESSION['LRN']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' AND Grade ='".$_SESSION['Grade']."' LIMIT 1");	
						
											
						if(mysqli_affected_rows($con)==1)
						{
						$Err="Successfully Updated!";	
                      echo '<div class="panel-heading">
							<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
								
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'</div>
							 
                        </div>';
						$_SESSION['LRN']="";
						}
					}elseif (isset($_POST['tag']))
					{
						$querydata=mysqli_query($con,"SELECT * FROM tbl_assessment_rat WHERE SchoolID='".$_SESSION['school_id']."' AND LRN='".$_SESSION['LRN']."' AND Learning_Status='Offline' AND ExamStatus='".$_SESSION['ExamStatus']."' AND Type_of_modality ='".$_POST['Modality']."' AND Place_of_examination='".$_POST['place_of_exam']."' AND Type_of_Gadget='".$_POST['type_of_gadget']."' AND School_Year='".$_SESSION['year']."'");
						if (mysqli_num_rows($querydata)==0)
						{
							mysqli_query($con,"INSERT INTO tbl_assessment_rat VALUES(NULL,'".$_SESSION['school_id']."','".$_SESSION['LRN']."','Offline','".$_SESSION['ExamStatus']."','".$_POST['Modality']."','".$_POST['place_of_exam']."','".$_POST['type_of_gadget']."','".$_SESSION['year']."')");
						}
						if(mysqli_affected_rows($con)==1)
						{
						$Err="Learner Successfully Tag!";	
                      echo '<div class="panel-heading">
							<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
								
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'</div>
							 
                        </div>';$_SESSION['LRN']="";
						}
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
                                        <th width="20%">Grade & Section</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc ");
									
								
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr>
											<td>'.$row['lrn'].'</td>
											<td>'.utf8_encode($row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName']).'</td>
											<td>'.$row['Gender'].'</td>';
											if ($row['Grade']=='Nursery' || $row['Grade']=='Kinder 1' || $row['Grade']=='Kinder 2')
											{
											echo '<td style="text-align:center;">'.$row['Grade'].' - '.$row['SecDesc'].'</td>';
												
											}else{
											echo '<td style="text-align:center;">Grade '.$row['Grade'].' - '.$row['SecDesc'].'</td>';
											}						
											echo '<td style="text-align:center;">
													
												<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&l='.urlencode(base64_encode($row['lrn'])).'&&Code='.urlencode(base64_encode($row['Grade'])).'&v='.urlencode(base64_encode("individual_info")).'" title="View information">VIEW</a>
												
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
           

<script>
function delete_lerner(id)
{
	if(confirm("Are you sure you want to remove this row?"))
	{
		window.location.href='delete_learner.php?id='+id;
	}
}
</script>




   <!-- Modal for Re-assign-->
    <div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="assign_sec" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		     </div>
		     </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="newassign" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->

