
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

          
                    <div class="panel panel-default">
                         <div class="panel-heading">
						<?php
						echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dbea")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						echo '<a href="print_list.php" style="float:right;" class="btn btn-primary" target="_blank">Print</a>';
						
						?>
							
							<h4>BUREAU OF EDUCATION ASSESSMENT > PAGADIAN CITY DIVISION > <?php echo $_SESSION['CurrentExam']; ?> > LEARNER'S MASTERLIST</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="14%">Last Name</th>
                                        <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                        
                                        <th width="10%">YLevel</th>
                                        <th>School</th>
                                         <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID = tbl_school.SchoolID WHERE  tbl_assessment_rat.School_Year='".$_SESSION['year']."' AND tbl_assessment_rat.Exam_Code='".$_SESSION['assessment']."' ORDER BY tbl_student.Lname Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName'].'</td>
											
											<td style="text-align:center;">Grade '.$row['YLevel'].'</td>
											<td>'.$row['SchoolName'].'</td>
											
											<td style="text-align:center;">
											<a href="test_paper.php?/13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&SchoolName='.urlencode(base64_encode($row['SchoolName'])).'&YLevel='.urlencode(base64_encode($row['YLevel'])).'&code='.urlencode(base64_encode($row['lrn'])).'" target="_blank"> <i class="fa fa-desktop"></i></a>			
											<a style="cursor:pointer;" onclick="remove_id(this.id)" id="'.$row['lrn'].'"><i class="fa fa-trash"></i></a>			
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
         

			
				
<script>
function  remove_id(id)
{
		if(confirm("Are you sure you want to delete all row?"))
			{
				window.location.href='delete_record.php?re='+id;
			}
}
</script>



<!-- Modal for Re-assign-->
<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="setaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
