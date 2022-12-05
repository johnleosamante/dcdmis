
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="#newrole" data-toggle="modal" class="btn btn-primary" style="float:right;">Add Role</a>
						 	<h4> School Property Custodian Masterlist</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                       	<th style="width:3%;" >#</th>
										<th style="width:25%;" >Name of Employee</th>
										<th  style="width:25%;text-align:center;" >School / Station</th>
										
										<th style="text-align:center;width:15%;" >Contact #</th>
										
                                    </tr>
									
										
									
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode WHERE tbl_user.position ='PROPERTY CUSTODIAN' AND tbl_station.Emp_Category ='TEACHER' ORDER BY tbl_employee.Emp_LName Asc")or die ("School Table not found!");
									
									while($r = mysqli_fetch_assoc($recstudent)) {
										$no++;
										print '<td>'.$no.'</td>';
										print '<td>'.utf8_encode($r['Emp_LName'].', '.$r['Emp_FName']).'</td>';
										print '<td>'.$r['SchoolName'].'</td>';
										print '<td>'.$r['Emp_Cell_No'].'</td>
										
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
           
