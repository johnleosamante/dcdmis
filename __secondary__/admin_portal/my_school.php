 <style>
	th,td{
		text-transform:uppercase;
	}
	</style>

 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="" data-toggle="modal" data-target="#mySchool" class="btn btn-primary" style="float:right;">Add School</a>
							
						 	<h4> School's Masterlist</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                   <tr>
                                       	<th style="width:3%;" >School ID</th>
										<th style="width:45%;" >School Name</th>
										<th style="width:25%;">Teacher-incharge</th>
										
										<th style="text-align:center;width:5%;"></th>
                                    </tr>
									
									
									
                                </thead>
                                <tbody>
								<?php
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_school.Incharg_ID INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code WHERE tbl_school.DivCode='".$_GET['SchoolID']."' ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									$no=$m=$f=$t=0;
									while($r = mysqli_fetch_assoc($recstudent)) {
										print '<td>'.$r['SchoolID'].'</td>';
										print '<td>'.$r['SchoolName'].'</td>';
										print '<td>'.$r['Emp_LName'].', '.$r['Emp_FName'].'</td>
										
											<td style="text-align:center;">
												<a href=./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($r['SchoolID'])).'&v='.urlencode(base64_encode("view_school")).'"> View</a><br/>
																									
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