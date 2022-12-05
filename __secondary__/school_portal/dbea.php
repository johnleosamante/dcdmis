<?php
 if (!is_dir('../image/')) {
    mkdir('../image/', 0777, true);
}

?>
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

          
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <?php
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("addNewExaminee")).'" class="btn btn-primary" style="float:right;">Add Examinee</a>';
						?>
						<h4>Learner's Masterlist for the RAT</h4>
							<?php
								if (isset($_POST['register']))
								{
								 $myfile = $_FILES['image']['name'];
									//$myfile = preg_replace("/[^a-zA-Z0-9-.]/", "", $myfile);
									$temp = $_FILES['image']['tmp_name'];
									$type = $_FILES['image']['type'];
									$ext = pathinfo($myfile, PATHINFO_EXTENSION);	
									$mynewimage='../image/'.$_POST['lrn'].'.'.$ext;
									move_uploaded_file($temp, $mynewimage);				
								 mysqli_query($con,"INSERT INTO tbl_student VALUES('".$_POST['lrn']."','".$_POST['Last_Name']."','".$_POST['First_Name']."','".$_POST['Middle_Name']."','-','-','".$_POST['Parent_Contact']."','-','-','-','-','-','-','-','-','".$_POST['school']."','-','-','-','".$mynewimage."')");
								 mysqli_query($con,"INSERT INTO tbl_assessment_rat VALUES (NULL,'".$_POST['deped_email']."','".$_POST['school']."','".$_POST['year_level']."','".$_POST['lrn']."','-','Offline','123131','NONE')");						
									if(mysqli_affected_rows($con)==1)
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
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Last Name</th>
                                        <th width="14%">First Name</th>
                                        <th width="14%">Middle Name</th>
                                        <th width="10%">YLevel</th>
                                        <th width="15%">Username</th>
                                        <th width="15%">Password</th>
                                        <th width="5%"></th>
										
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$password="";
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID = tbl_school.SchoolID WHERE tbl_assessment_rat.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$password=mb_strimwidth($row['lrn'],6,6);
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName'].'</td>
											<td style="text-align:center;">'.$row['YLevel'].'</td>
											<td>'.$row['DepedEmail'].'</td>
											<td>'.$password.'</td>
											<td><a href="view_score.php?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&YLevel='.urlencode(base64_encode($row['YLevel'])).'&id='.urlencode(base64_encode($row['lrn'])).'" target="_blank">View Score</a></td>
											
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
         