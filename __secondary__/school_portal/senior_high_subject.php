<style>
th,td{
	text-transform:uppercase;
}
</style>    
	<div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>List of senior high School subjects </h4>
							 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
													
							<label style="width:100%;padding:4px;margin-left:auto;margin-right:auto;">
                           <table class="table table-striped table-bordered table-hover">
										<thead>
										<tr>
											<th colspan="4">Grade 11 First Semester</th>
										</tr>
											<tr>
												<th style="text-align:center;" width="7%">#</th>
												<th width="10%">Subject Code</th>
												<th>Learning Areas</th>
												
												<th style="text-align:center;" width="10%">Type</th>
												
												
											</tr>	
											
										</thead>
										<tbody>
										<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_senior_sub_strand.SubStrandtype = tbl_senior_strand_type.StrandCode WHERE tbl_shs_subject.Grade='11' AND tbl_shs_subject.Semester='First Semester' AND tbl_shs_subject.SchoolID='".$_SESSION['school_id']."' GROUP BY SubNo ");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>	
													<td>'.$row['SubNo'].'</td>	
													<td>'.$row['SubStrandDescription'].'</td>	
													
													<td style="text-align:center;">'.$row['StrandDescription'].'</td>	
													
												  </tr>';
										}
										?>
										<tr>
											<th colspan="6">Grade 11 Second Semester</th>
										</tr>
										<tr>
												<th style="text-align:center;" width="7%">#</th>
												<th width="10%">Subject Code</th>
												<th>Learning Areas</th>
												
												<th style="text-align:center;" width="20%">Type</th>
												
												
											</tr>	
											<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_senior_sub_strand.SubStrandtype = tbl_senior_strand_type.StrandCode WHERE tbl_shs_subject.Grade='11' AND tbl_shs_subject.Semester='Second Semester' AND tbl_shs_subject.SchoolID='".$_SESSION['school_id']."' GROUP BY SubNo");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>	
													<td>'.$row['SubNo'].'</td>	
													<td>'.$row['SubStrandDescription'].'</td>	
													
													<td style="text-align:center;">'.$row['StrandDescription'].'</td>	
													
												  </tr>';
										}
										?>
										<tr>
											<th colspan="6">Grade 12 First Semester</th>
										</tr>
										<tr>
												<th style="text-align:center;" width="7%">#</th>
												<th width="10%">Subject Code</th>
												<th>Learning Areas</th>
												
												<th style="text-align:center;" width="20%">Type</th>
												
												
											</tr>	
											<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_senior_sub_strand.SubStrandtype = tbl_senior_strand_type.StrandCode WHERE tbl_shs_subject.Grade='12' AND tbl_shs_subject.Semester='First Semester' AND tbl_shs_subject.SchoolID='".$_SESSION['school_id']."' GROUP BY SubNo");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>	
													<td>'.$row['SubNo'].'</td>	
													<td>'.$row['SubStrandDescription'].'</td>	
													
													<td style="text-align:center;">'.$row['StrandDescription'].'</td>	
													
												  </tr>';
										}
										?>
										<tr>
											<th colspan="6">Grade 12 Second Semester</th>
										</tr>
										<tr>
												<th style="text-align:center;" width="7%">#</th>
												<th width="10%">Subject Code</th>
												<th>Learning Areas</th>
												
												<th style="text-align:center;" width="20%">Type</th>
												
												
											</tr>	
											<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_shs_subject INNER JOIN tbl_senior_sub_strand ON tbl_shs_subject.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_senior_strand_type ON tbl_senior_sub_strand.SubStrandtype = tbl_senior_strand_type.StrandCode WHERE tbl_shs_subject.Grade='12' AND tbl_shs_subject.Semester='Second Semester' AND tbl_shs_subject.SchoolID='".$_SESSION['school_id']."' GROUP BY SubNo");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>	
													<td>'.$row['SubNo'].'</td>	
													<td>'.$row['SubStrandDescription'].'</td>	
													
													<td style="text-align:center;">'.$row['StrandDescription'].'</td>	
													
												  </tr>';
										}
										?>

										</tbody>
										
									</table>
						
							
						</label>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             


