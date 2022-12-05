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
					<h3>Junior Learner's Masterlist</h3>
					
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
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION["year"]."' AND tbl_section.School_Year='".$_SESSION["year"]."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");
									
								
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
														<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&cat='.urlencode(base64_encode("Junior")).'&l='.urlencode(base64_encode($row['lrn'])).'&&Code='.urlencode(base64_encode($row['Grade'])).'&v='.urlencode(base64_encode("individual_info")).'" title="View information" class="btn btn-primary" style="padding:4px;margin:4px;">VIEW</a>
													
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

