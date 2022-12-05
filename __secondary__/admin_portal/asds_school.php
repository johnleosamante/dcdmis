 <div class="col-lg-12">
 <h2></h2>
 </div>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						<h4>School's Masterlist</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       	<th style="width:15%;">SCHOOL ID</th>
										<th >SCHOOL NAME</th>
										<th style="text-align:center;">PRINCIPAL</th>
										<th style="width:15%;" >PROGRESS</th>
										<th style="width:7%;" ></th>
										
                                    </tr>
									
										
                                </thead>
                                <tbody>
								<?php
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_school.Incharg_ID WHERE tbl_school.SchoolID<>'123131' ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									
									while($r = mysqli_fetch_assoc($recstudent)) {
										$percent=$annex1=$annex2=$annex3=$annex4=$annex5=$annex6=$annex7=$annex8=$annex9=$annex10=0;
										//Annex1
										$myannex1=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex1)<>0)
										{
											$annex1=10;
										}//Annex2
										$myannex2=mysqli_query($con,"SELECT * FROM tbl_sep_annexa2 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex2)<>0)
										{
											$annex2=10;
										}
										//Annex3
										$myannex3=mysqli_query($con,"SELECT * FROM tbl_sep_annexa3 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex3)<>0)
										{
											$annex3=10;
										}//Annex4
										$myannex4=mysqli_query($con,"SELECT * FROM tbl_sep_annexa4 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex4)<>0)
										{
											$annex4=10;
										}//Annex5
										$myannex5=mysqli_query($con,"SELECT * FROM tbl_sep_annexa5 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex5)<>0)
										{
											$annex5=10;
										}//Annex6
										$myannex6=mysqli_query($con,"SELECT * FROM tbl_sep_annexa6 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex6)<>0)
										{
											$annex6=10;
										}//Annex7
										$myannex7=mysqli_query($con,"SELECT * FROM tbl_sep_annexa7 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex7)<>0)
										{
											$annex7=10;
										}//Annex8
										$myannex8=mysqli_query($con,"SELECT * FROM tbl_sep_annexa8 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex8)<>0)
										{
											$annex8=10;
										}//Annex9
										$myannex9=mysqli_query($con,"SELECT * FROM tbl_sep_annexa9 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex9)<>0)
										{
											$annex9=10;
										}//Annex10
										$myannex10=mysqli_query($con,"SELECT * FROM tbl_sep_annexa10 WHERE SEP_SchoolID='".$r['SchoolID']."'");
										if(mysqli_num_rows($myannex10)<>0)
										{
											$annex10=10;
										}
										$percent=$annex1+$annex2+$annex3+$annex4+$annex5+$annex6+$annex7+$annex8+$annex9+$annex10;
										print '<td style="width:7%;text-align:center;">'.$r['SchoolID'].'</td>';
										print '<td>'.$r['SchoolName'].'</td>';
										print '<td>'.$r['Emp_LName'].', '.$r['Emp_FName'].' '.$r['Emp_MName'].'</td>
											   <td><div style="background:green;width:100%;text-align:center;color:white;"
												<label style="width:'.$percent.'%;height:20px;padding:4px;margin:4px;background:blue;">'.$percent.'%</label></div></td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($r['SchoolID'])).'&v='.urlencode(base64_encode("asds_report")).'">VIEW</a></td>
											
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
              