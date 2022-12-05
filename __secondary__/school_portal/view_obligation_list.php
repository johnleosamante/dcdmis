  
 <div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>	
 <div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<?php
						$obligate=mysqli_query($con,"SELECT * FROM tbl_school_obligation WHERE SchoolID='".$_SESSION['school_id']."' AND AccountNo='".$_GET['account']."' LIMIT 1");
						$rowob=mysqli_fetch_assoc($obligate);
						
						echo '<a href="print_list" class="btn btn-success" style="float:right;" target="_blank">Print List</a>
						<label style="width:100px;">Account #:</label><label>'.$rowob['AccountNo'].'</label><br/>
						<label style="width:100px;">Description:</label><label>'.$rowob['Description_info'].'</label><br/>
						<label style="width:100px;">Amount:</label><label>₱ '.number_format($rowob['Amount_to_be_collect'],2).'</label><br/>
						<label style="width:100px;">Due Date:</label><label>'.$rowob['Due_date'].'</label><br/>';
						
					    ?>
					
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Learner's Name</th>
                                        <th width="14%">Grade Level</th>
                                        <th width="14%">Section</th>
                                        <th width="14%">Adviser</th>
                                        <th width="14%">Amount</th>
                                        <th width="14%">Status / Date Paid</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$requery=mysqli_query($con,"SELECT * FROM tbl_learner_payment INNER JOIN tbl_student ON tbl_learner_payment.lrn=tbl_student.lrn INNER JOIN tbl_learners ON tbl_learner_payment.lrn = tbl_learners.lrn INNER JOIN tbl_section ON tbl_learners.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_learner_payment.School_year='".$_SESSION['year']."' AND tbl_learner_payment.SchoolID='".$_SESSION['school_id']."' AND tbl_learner_payment.AccountNo='".$_GET['account']."'");
								while($rowquery=mysqli_fetch_array($requery))
								{
									$no++;
									echo '<tr>
                                           <td>'.$no.'</th>
                                           <td>'.$rowquery['Lname'].', '.$rowquery['FName'].'</td>
                                           <td>Grade '.$rowquery['Grade'].'</td>
                                           <td>'.$rowquery['SecDesc'].'</td>
                                           <td>'.$rowquery['Emp_LName'].', '.$rowquery['Emp_FName'].'</td>
                                          <td>₱ '.number_format($rowquery['AmountPaid'],2).'</td>
                                          <td>Paid ('.$rowquery['Date_paid'].')</td>
                                      
                                    </tr>';
								}
								?>
                                </tbody>
                            </table>
                            
                        </div>
						
						
                        <!-- /.panel-body 
						-->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			