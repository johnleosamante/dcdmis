
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							
						 	<h4> School's Masterlist</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                   <tr>
                                       	<th style="width:3%;" rowspan="2">School ID</th>
										<th style="width:45%;" rowspan="2">School Name</th>
										<th style="width:25%;" rowspan="2">Teacher-incharge</th>
										<th style="width:15%;" rowspan="2">District</th>
										<th  style="width:6%;text-align:center;" colspan="3"># of Personel</th>
										
										<th style="width:15%;" rowspan="2">Contact No </th>
										
                                    </tr>
									
										<tr style="background-color:#0012;">
											<th  style="width:2%;text-align:center;">M</th>
											<th  style="width:2%;text-align:center;">F</th>
											<th  style="width:2%;text-align:center;">T</th>
										</tr>
									
                                </thead>
                                <tbody>
								<?php
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_school.Incharg_ID INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									$no=$m=$f=$t=0;
									while($r = mysqli_fetch_assoc($recstudent)) {
										//Gender 
										$male=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID=tbl_employee.Emp_ID WHERE tbl_employee.Emp_Sex ='Male' AND tbl_station.Emp_Station='".$r['SchoolID']."'");
										$m=mysqli_num_rows($male);
										$female=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID=tbl_employee.Emp_ID WHERE tbl_employee.Emp_Sex ='Female' AND tbl_station.Emp_Station='".$r['SchoolID']."'");
										$f=mysqli_num_rows($female);
										$t=$m+$f;
										print '<td>'.$r['SchoolID'].'</td>';
										print '<td>'.$r['SchoolName'].'</td>';
										print '<td>'.$r['Emp_LName'].', '.$r['Emp_FName'].'</td>';
										print '<td>'.$r['District_Name'].'</td>';
										print '<td style="text-align:center;">'.$m.'</td>';
										print '<td style="text-align:center;">'.$f.'</td>';
										print '<td style="text-align:center;">'.$t.'</td>
										
												<td style="text-align:center;">'.$r['Emp_Cell_No'].'</td>
										
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
          
<style>
   
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:600px;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
		}
		th{
			text-align:center;
		}
		#myProgress {
  width: 100%;
 text-align:center;
}

#myBar {
  height: 30px;
  background-color: #4CAF50;
}
   </style>
