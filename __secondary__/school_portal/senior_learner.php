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
					<h3>Senior High Learner's Masterlist</h3>
									
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
								if ($_SESSION['Sem']=="First Semester")
								{
								$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND first_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc ");
									
								}elseif ($_SESSION['Sem']=="Second Semester")
								{
								$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND second_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn ORDER BY tbl_student.Lname Asc ");
									
								}
									
								
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr>
											<td>'.$row['lrn'].'</td>
											<td>'.utf8_encode($row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName']).'</td>
											<td>'.$row['Gender'].'</td>';
											
											echo '<td style="text-align:center;">Grade '.$row['Grade'].' - '.$row['SecDesc'].'</td>';
															
											echo '<td style="text-align:center;">
													
															
															<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&l='.urlencode(base64_encode($row['lrn'])).'&&Code='.urlencode(base64_encode($row['Grade'])).'&SecCode='.urlencode(base64_encode($row['SecCode'])).'&v='.urlencode(base64_encode("individual_info")).'" title="View information" class="btn btn-primary" style="margin:4px;padding:4px;">VIEW</a><br/>
																
																													
														
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